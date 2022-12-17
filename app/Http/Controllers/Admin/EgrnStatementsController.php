<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\EgrnStatementCollection;
use App\Models\EgrnStatement;
use Illuminate\Http\Request;

class EgrnStatementsController extends Controller
{
    /**
     * Проверка прав на совершение действий
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:egrn-statements-list', ['only' => ['get']]);
    }

    public function get(Request $request){
        $cadastralNumber = $request->query('param');
        $statements = EgrnStatement::when(isset($cadastralNumber), function($query) use ($cadastralNumber) {
            $query->whereHas('application', function($que) use ($cadastralNumber){
                $que->where('cadastral_number', 'LIKE', '%'.$cadastralNumber.'%');
            });
        })->orderBy('created_at', 'desc')->paginate(20);
        return response(new EgrnStatementCollection($statements), 200);
    }
}
