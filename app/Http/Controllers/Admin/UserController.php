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
            $region = $request->get('region', null);
            $searchString = $request->query('search');
            $sortParam = $request->query('sort_property');
            $sortDirection = $request->query('sort_direction');
            $tariffs = Tariff::select(['tariffs.id', 'tariffs.type'])->get();
            $userTariffs = $tariffs->where('type', 'tariff')->pluck('id')->toArray();
            $botTariffs = $tariffs->where('type', 'bot_tariff')->pluck('id')->toArray();
            $users = User::leftJoin('regions', 'regions.id', '=', 'users.region_id')
                ->select([
                    'users.*',
                    'regions.title',
                    'user_tariff.tariff_id as user_tariff_id',
                    'bot_tariff.tariff_id as bot_tariff_id',
                    DB::raw('DATE_FORMAT(user_tariff.finished_at, "%d.%m.%Y, %H:%i") as finished_at'),
                    DB::raw('DATE_FORMAT(bot_tariff.finished_at, "%d.%m.%Y, %H:%i") as bot_finished_at')
                ])
                ->when(isset($searchString), function ($query) use ($searchString) {
                    $query->where('email', 'LIKE', '%' . $searchString . '%')
                        ->orWhere('phone', 'LIKE', '%' . $searchString . '%')
                        ->orWhere('name', 'LIKE', '%' . $searchString . '%')
                        ->orWhere('surname', 'LIKE', '%' . $searchString . '%');

                })
                ->leftJoin('payments as user_tariff', function($join) use($userTariffs)
                {
                    $join->on('users.id', '=', 'user_tariff.user_id')
                        ->where('user_tariff.tariff_id', '!=', null)
                        ->where('user_tariff.is_confirmed', true)
                        ->where('user_tariff.status', 'Settled')
                        ->whereIn('user_tariff.tariff_id', $userTariffs)
                        ->where('user_tariff.finished_at', '>=', Carbon::now()->setTimezone('Europe/Moscow'));
                })
                ->leftJoin('payments as bot_tariff', function($join) use($botTariffs)
                {
                    $join->on('users.id', '=', 'bot_tariff.user_id')
                        ->where('bot_tariff.tariff_id', '!=', null)
                        ->where('bot_tariff.is_confirmed', true)
                        ->where('bot_tariff.status', 'Settled')
                        ->whereIn('bot_tariff.tariff_id', $botTariffs)
                        ->where('bot_tariff.finished_at', '>=', Carbon::now()->setTimezone('Europe/Moscow'));
                })
                ->when(!is_null($region) && $region != 'null', function ($q) use ($region) {
                    $q->where('regions.code','=', $region);
                })
                ->when(isset($sortParam) && isset($sortDirection), function ($query) use ($sortParam, $sortDirection) {
                    $query->orderBy($sortParam, $sortDirection);
                })->groupBy('users.id')
                ->paginate(20);
            return response(new UserCollection($users), 200);
        }
        catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }

    }

    public function edit($id)
    {
        $tariffs = Tariff::select(['tariffs.id', 'tariffs.type'])->get();
        $userTariffs = $tariffs->where('type', 'tariff')->pluck('id')->toArray();
        $botTariffs = $tariffs->where('type', 'bot_tariff')->pluck('id')->toArray();
        $user = User::select([
            'users.*',
            'regions.title',
            'user_tariff.tariff_id as user_tariff_id',
            'bot_tariff.tariff_id as bot_tariff_id',
            DB::raw('DATE_FORMAT(user_tariff.finished_at, "%d.%m.%Y, %H:%i") as finished_at'),
            DB::raw('DATE_FORMAT(bot_tariff.finished_at, "%d.%m.%Y, %H:%i") as bot_finished_at')
        ])
            ->leftJoin('regions', 'regions.id', '=', 'users.region_id')
            ->leftJoin('payments as user_tariff', function ($join) use ($userTariffs) {
                $join->on('users.id', '=', 'user_tariff.user_id')
                    ->where('user_tariff.tariff_id', '!=', null)
                    ->where('user_tariff.is_confirmed', true)
                    ->where('user_tariff.status', 'Settled')
                    ->whereIn('user_tariff.tariff_id', $userTariffs)
                    ->where('user_tariff.finished_at', '>=', Carbon::now()->setTimezone('Europe/Moscow'));
            })
            ->leftJoin('payments as bot_tariff', function ($join) use ($botTariffs) {
                $join->on('users.id', '=', 'bot_tariff.user_id')
                    ->where('bot_tariff.tariff_id', '!=', null)
                    ->where('bot_tariff.is_confirmed', true)
                    ->where('bot_tariff.status', 'Settled')
                    ->whereIn('bot_tariff.tariff_id', $botTariffs)
                    ->where('bot_tariff.finished_at', '>=', Carbon::now()->setTimezone('Europe/Moscow'));
            })
            ->where('users.id', $id)
            ->groupBy('users.id')
            ->first();
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
        } else {
            if ($userTariff) {
                $paymentService->checkPreviousActiveTariff($user->id, $userTariff->tariff->period, false);
                $userTariff->delete();
            }
        }

        if(isset($request->botTariff)) {
            $tariff = Tariff::find($request->botTariff);
            if ($botTariff) {
                if ($botTariff->tariff_id != $request->botTariff) {
                    $paymentService->checkPreviousActiveTariff($user->id, $botTariff->tariff->period, false, 'bot_tariff');
                    $botTariff->delete();
                    Payment::create([
                        'user_id' => $user->id,
                        'tariff_id' => $request->botTariff,
                        'finished_at' => Carbon::now()->setTimezone('Europe/Moscow')->addDays($tariff->period),
                        'is_confirmed' => true,
                        'status' => 'Settled'
                    ]);
                }
            } else {
                Payment::create([
                    'user_id' => $user->id,
                    'tariff_id' => $request->botTariff,
                    'finished_at' => Carbon::now()->setTimezone('Europe/Moscow')->addDays($tariff->period),
                    'is_confirmed' => true,
                    'status' => 'Settled'
                ]);
            }
        }
        else {
            if ($botTariff) {
                $paymentService->checkPreviousActiveTariff($user->id, $botTariff->tariff->period, false, 'bot_tariff');
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
