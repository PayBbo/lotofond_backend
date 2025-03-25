<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Http\Resources\Admin\UserCollection;
use App\Http\Resources\Admin\UserResource;
use App\Http\Resources\TextDataResource;
use App\Http\Services\PaymentService;
use App\Models\Payment;
use App\Models\Region;
use App\Models\Tariff;
use App\Models\TextData;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{

    /**
     * Проверка прав на совершение действий
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:user-list', ['only' => ['get']]);
        $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user-add', ['only' => ['add']]);
        $this->middleware('permission:user-delete', ['only' => ['delete']]);
    }


    public function get(Request $request)
    {
        try {
            $searchString = $request->query('param');
            $sortParam = $request->query('sort_property');
            $sortDirection = $request->query('sort_direction');
            $users = User::leftJoin('regions', 'regions.id', '=', 'users.region_id')
                ->select('users.*','regions.title', DB::raw('DATE_FORMAT(payments.finished_at, "%d.%m.%Y, %H:%i") as finished_at'))
                ->when(isset($searchString), function ($query) use ($searchString) {
                    $query->where('email', 'LIKE', '%' . $searchString . '%')
                        ->orWhere('phone', 'LIKE', '%' . $searchString . '%')
                        ->orWhere('name', 'LIKE', '%' . $searchString . '%')
                        ->orWhere('surname', 'LIKE', '%' . $searchString . '%');

                })
                ->leftJoin('payments', function($join)
                {
                    $join->on('users.id', '=', 'payments.user_id')
                        ->where('payments.tariff_id', '!=', null)
                        ->where('payments.is_confirmed', true)
                        ->where('payments.status', 'Settled')
                        ->where('payments.finished_at', '>=', Carbon::now()->setTimezone('Europe/Moscow'));
                })
                ->when(isset($sortParam) && isset($sortDirection), function ($query) use ($sortParam, $sortDirection) {
                    $query->orderBy($sortParam, $sortDirection);
                })
                ->paginate(20);
            return response(new UserCollection($users), 200);
        }
        catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }

    }

    public function edit($id)
    {
        $user = User::find($id);
        if ($user) {
            return response(new UserResource($user), 200);
        }
        return response(null, 404);
    }

    public function add(AddUserRequest $request)
    {
        $user = User::create([
            'surname' => $request->surname,
            'name' => $request->name,
            'middle_name' => $request->middleName,
            'not_from_favourite' => $request->notificationsFromFavourite,
            'not_from_monitoring' => $request->notificationsFromMonitoring,
            'not_to_email' => $request->notificationsToEmail,
            'email' => $request->value,
            'phone' => preg_replace('/\D/', '', $request->phone),
            'password' => Hash::make($request->password),
            'email_verified_at' => Carbon::now()->setTimezone('Europe/Moscow'),
            'region_id' => !is_null($request->region) ? Region::where('title', $request->region)->first()['id'] : null,
            'not_settings' => [
                'favouriteEventStart' => 1,
                'favouriteEventEnd' => 1,
                'favouriteApplicationStart' => 1,
                'favouriteApplicationEnd' => 1,
                'favouriteResult' => 1,
                'favouritePriceReduction' => 1
            ]
        ]);
        $user->assignRole($request->roles);
        $tariff = Tariff::find($request->tariff);
        if (isset($request->tariff)) {
            $payment = Payment::create([
                'user_id' => $user->id,
                'tariff_id' => $request->tariff,
                'finished_at' => Carbon::now()->setTimezone('Europe/Moscow')->addDays($tariff->period),
                'is_confirmed' => true
            ]);
        }
        return response(null, 200);
    }

    public function update(UpdateUserRequest $request)
    {
        $user = User::find($request->id);
        $user->name = $request->name;
        $user->surname = $request->surname;
        $user->middle_name = $request->middleName;
        $user->email = $request->email;
        $user->phone = preg_replace('/\D/', '', $request->phone);
        $user->region_id = !is_null($request->region) ? Region::where('title', $request->region)->first()['id'] : null;
        $user->save();
        $user->syncRoles($request->role);
        $user->assignRole($request->roles);
        $userTariff = $user->tariff;
        $botTariff = $user->botTariff;
        $paymentService = new PaymentService();
        if (isset($request->tariff)) {
            $tariff = Tariff::find($request->tariff);
            if ($userTariff) {
                if ($userTariff->tariff_id != $request->tariff) {
                    $paymentService->checkPreviousActiveTariff($user->id, $userTariff->tariff->period, false);
                    $userTariff->delete();
                    Payment::create([
                        'user_id' => $user->id,
                        'tariff_id' => $request->tariff,
                        'finished_at' => Carbon::now()->setTimezone('Europe/Moscow')->addDays($tariff->period),
                        'is_confirmed' => true,
                        'status' => 'Settled'
                    ]);
                }
            } else {
                Payment::create([
                    'user_id' => $user->id,
                    'tariff_id' => $request->tariff,
                    'finished_at' => Carbon::now()->setTimezone('Europe/Moscow')->addDays($tariff->period),
                    'is_confirmed' => true,
                    'status' => 'Settled'
                ]);
            }
            if ($botTariff) {
                if ($botTariff->tariff_id != $request->tariff) {
                    $paymentService->checkPreviousActiveTariff($user->id, $botTariff->tariff->period, false);
                    $botTariff->delete();
                    Payment::create([
                        'user_id' => $user->id,
                        'tariff_id' => $request->tariff,
                        'finished_at' => Carbon::now()->setTimezone('Europe/Moscow')->addDays($tariff->period),
                        'is_confirmed' => true,
                        'status' => 'Settled'
                    ]);
                }
            } else {
                Payment::create([
                    'user_id' => $user->id,
                    'tariff_id' => $request->tariff,
                    'finished_at' => Carbon::now()->setTimezone('Europe/Moscow')->addDays($tariff->period),
                    'is_confirmed' => true,
                    'status' => 'Settled'
                ]);
            }
        } else {
            if ($userTariff) {
                $paymentService->checkPreviousActiveTariff($user->id, $userTariff->tariff->period, false);
                $userTariff->delete();
            }
            if ($botTariff) {
                $paymentService->checkPreviousActiveTariff($user->id, $botTariff->tariff->period, false);
                $botTariff->delete();
            }
        }

        return response(null, 200);
    }

    public function delete($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
        }
        return response(null, 200);
    }
}
