<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddRoleRequest;
use App\Http\Requests\Admin\UpdateRoleRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{

    /**
     * Проверка прав на совершение действий
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:role-list', ['only' => ['get']]);
        $this->middleware('permission:role-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:role-add', ['only' => ['add']]);
        $this->middleware('permission:emails-delete', ['only' => ['delete']]);
    }


    public function get(Request $request)
    {
        $sortParam = $request->query('sort_property');
        $sortDirection = $request->query('sort_direction');
        $roles = Role::select(['id', 'name'])
            ->when(isset($sortParam) && isset($sortDirection), function ($query) use ($sortParam, $sortDirection) {
                $query->orderBy($sortParam, $sortDirection);
            })
            ->get();
        return response(['data' => $roles, 'pagination' => []], 200);
    }

    public function add(AddRoleRequest $request)
    {
        Role::create(['name' => $request->name, 'guard_name' => 'api']);
        return response(null, 200);
    }

    public function edit($id)
    {
        $role = Role::where('id', $id)->with('permissions')->first();
        if ($role) {
            return response($role, 200);
        } else {
            return response(null, 404);
        }
    }

    public function update(UpdateRoleRequest $request)
    {
        $role = Role::find($request->id);
        $role->name = $request->name;
        $role->save();
        $role->syncPermissions($request->permissions);
        return response(null, 200);
    }

    public function delete($id)
    {
        $role = Role::find($id);
        if ($role && $role->name != 'admin' && $role->name != 'user') {
            $role->delete();
            return response(null, 200);
        }
        return response(null, 404);
    }

    public function permissions()
    {
        $groups = Permission::groupBy('permission_group')->pluck('permission_group');
        $data = [];
        foreach ($groups as $group) {
            $data[] = ['group' => $group, 'permissions' => Permission::where('permission_group', $group)->select('id', 'name', 'visible_name')->get()];
        }
        return response($data, 200);
    }
}
