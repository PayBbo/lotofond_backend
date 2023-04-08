<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ContentRuleUpdateRequest;
use App\Models\ContentRule;
use Illuminate\Http\Request;

class ContentRulesController extends Controller
{
    /**
     * Проверка прав на совершение действий
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:content-rules-list', ['only' => ['get']]);
        $this->middleware('permission:content-rules-edit', ['only' => ['update']]);
    }

    public function get(Request $request)
    {
        $content = $request->query('param');
        $sortParam = $request->query('sort_property');
        $sortDirection = $request->query('sort_direction');
        $rules = ContentRule::when(isset($content), function ($query) use ($content) {
            $query->where('title', 'LIKE', '%' . $content . '%');
        })
            ->when(isset($sortParam) && isset($sortDirection), function ($query) use ($sortParam, $sortDirection) {
                $query->orderBy($sortParam, $sortDirection);
            })
            ->select('title', 'code', 'is_available as isAvailable')
            ->get();
        return response(['data' => $rules, 'pagination' => []], 200);
    }

    public function update(ContentRuleUpdateRequest $request)
    {
        $rule = ContentRule::where('code', $request->code)->first();
        $rule->is_available = !$rule->is_available;
        $rule->save();
        return response(null, 200);
    }
}
