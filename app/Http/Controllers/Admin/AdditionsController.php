<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddEditAdditionRequest;
use App\Http\Resources\Admin\AdditionsCollection;
use App\Http\Resources\Admin\AdditionsResource;
use App\Models\AdditionalLotInfo;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdditionsController extends Controller
{

    /**
     * Проверка прав на совершение действий
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:additions-list', ['only' => ['get']]);
        $this->middleware('permission:additions-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:additions-add', ['only' => ['add']]);
        $this->middleware('permission:additions-delete', ['only' => ['delete']]);
    }

    public function get(Request $request)
    {
        try {
            $search = $request->query('pattern', null);
            $dateFrom = $request->get('dateFrom', null);
            $dateFrom = $dateFrom && $dateFrom != 'null' ? Carbon::parse($request->get('dateFrom'))->startOfDay() : null;
            $dateTo = $request->get('dateTo', null);
            $dateTo = $dateTo && $dateTo != 'null' ? Carbon::parse($request->get('dateTo'))->endOfDay() : null;
            $isModerated = $request->query('isModerated', null);
            $sortParam = $request->query('sort_property');
            $sortDirection = $request->query('sort_direction');

            $additions = AdditionalLotInfo::select(['additional_lot_infos.*', 'auction.trade_id'])
                ->when($isModerated, function ($query) {
                    $query->where('is_moderated', false);
                })
                ->when(!is_null($dateFrom) && $dateFrom != 'null', function ($q) use ($dateFrom) {
                    $q->where('additional_lot_infos.created_at','>=', $dateFrom);
                })
                ->when(!is_null($dateTo) && $dateTo != 'null', function ($q) use ($dateTo) {
                    $q->where('additional_lot_infos.created_at','<=',$dateTo);
                })
                ->when(isset($search), function ($q) use ($search) {
                    $q->where('additional_lot_infos.lot_id', 'LIKE', '%' . $search . '%')
                        ->orWhere('additional_lot_infos.message', 'LIKE', '%' . $search . '%')
                        ->orWhere('auction.trade_id', 'LIKE', '%' . $search . '%');
                })
                ->when(isset($sortParam) && isset($sortDirection), function ($query) use ($sortParam, $sortDirection) {
                    $query->orderBy($sortParam, $sortDirection);
                })
                ->withCount('files')
                ->leftJoin('lots', 'lots.id', '=', 'additional_lot_infos.lot_id')
                ->leftJoin('auctions as auction', 'auction.id', '=', 'lots.auction_id')
                ->paginate(20);
            return response(new AdditionsCollection($additions), 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function edit($id)
    {
        $addition = AdditionalLotInfo::find($id);
        if (!$addition) {
            return response(null, 404);
        }
        return response(new AdditionsResource($addition), 200);
    }

    public function add(AddEditAdditionRequest $request)
    {
        $addition = new AdditionalLotInfo();
        $addition->lot_id = $request->lotId;
        $addition->initial_message = $request->message;
        $addition->message = $request->message;
        $addition->is_moderated = $request->isModerated;
        $addition->save();
        return response(null, 200);

    }

    public function update(AddEditAdditionRequest $request)
    {
        $addition = AdditionalLotInfo::find($request->id);
        if (!$addition) {
            return response(null, 404);
        }
        $addition->message = $request->message;
        $addition->is_moderated = $request->isModerated;
        $addition->save();
        return response(null, 200);

    }

    public function changeStatus($id)
    {
        $addition = AdditionalLotInfo::find($id);
        if ($addition) {
            $addition->is_moderated = !$addition->is_moderated;
            $addition->save();
            return response(null, 200);
        }
        return response(null, 404);
    }

    public function delete($id)
    {
        $addition = AdditionalLotInfo::find($id);
        if (!$addition) {
            return response(null, 404);
        }
        $addition->delete();
        return response(null, 200);
    }

    public function processText(Request $request) {
        $message = $request->message;
        $html = str_replace('&nbsp;', '', $message);
        $pattern = '/<img[\s\S]*?>/';
        preg_match_all($pattern, $html, $matches);
        if (count($matches[0]) > 0) {
            foreach ($matches[0] as $img) {
                $html = str_replace($img, '', $html);
            }
        }
        $html = str_replace('div', 'p', $html);
        /*START Удаление всех html-тегов и искаженных символов*/
        $text = str_replace('</p>', ' </p> ', $html);
        $text = str_replace('<br>', ' ', $text);
        $text = str_replace("&nbsp;", " ", $text);
        $text = preg_replace("/<([^>]*(<|$))/", "&lt;$1 ", $text);
        $text = strip_tags($text);
        $text = str_replace(chr(194), " ", $text);
        $text = str_replace(chr(160), " ", $text);
        $text = preg_replace(array('/\s{2,}/', '/[\r\t\n]/', '/\r/', '/\t/', '/\n/'), ' ', $text);
        $text = str_replace("&lt;", "", str_replace("&gt;", "", $text));
        $text = iconv('utf-8//IGNORE', 'windows-1251//IGNORE', $text);
        $text = iconv('windows-1251//IGNORE', 'utf-8//IGNORE', $text);
        $initialText = $text;
        /*END Удаление всех html-тегов и искаженных символов*/
        /*START Удаление почты арбитражного управляющего*/
//                $arbitrEmail = $auction->arbitrationManager->email;
//                $text = preg_replace('/\b' . $arbitrEmail . '\b/u', str_repeat('░', strlen($arbitrEmail) - 1), $text);
        /*END Удаление почты арбитражного управляющего*/

        $replacement = '░░░░░░░░░░░░░░░░░░';
        /*START Удаление любой почты */
        $patternEmail = "/[^@\s]*@[^@\s]*\.[^@\s]*/";
        $text = preg_replace($patternEmail, $replacement, $text);
        /*END Удаление любой почты*/
        /*START Удаление любой ссылки */
        $patternUrl = "/[a-zA-Z]*[:\/\/]*[A-Za-z0-9\-_]+\.+[A-Za-z0-9\.\/%&=\?\-_]+/i";
        $text = preg_replace($patternUrl, $replacement, $text);
        /*END Удаление любой почты*/

        return $text;
    }

}
