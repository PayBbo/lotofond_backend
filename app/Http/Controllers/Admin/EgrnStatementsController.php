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

    public function get(Request $request)
    {
        $cadastralNumber = $request->query('param');
        $sortParam = $request->query('sort_property');
        $sortDirection = $request->query('sort_direction');
        $statements = EgrnStatement::when(isset($cadastralNumber), function ($query) use ($cadastralNumber) {
            $query->whereHas('application', function ($que) use ($cadastralNumber) {
                $que->where('cadastral_number', 'LIKE', '%' . $cadastralNumber . '%');
            });
        })
            ->leftJoin('applications as application', 'egrn_statements.application_id', '=', 'application.id')
            ->select('egrn_statements.*','application.cadastral_number as cadastral_number')
            ->when(isset($sortParam) && isset($sortDirection), function ($query) use ($sortParam, $sortDirection) {
                $query->orderBy($sortParam, $sortDirection);
            })
            ->paginate(20);
        return response(new EgrnStatementCollection($statements), 200);
    }
}
