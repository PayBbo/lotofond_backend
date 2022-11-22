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
    public function get(){
        $roles = Role::select(['id', 'name'])->get();
        return response(['data'=>$roles, 'pagination'=>[]], 200);
    }

    public function add(AddRoleRequest $request){
        Role::create(['name' => $request->name, 'guard_name'=>'api']);
        return response(null, 200);
    }

    public function edit($id){
        $role = Role::where('id', $id)->with('permissions')->first();
        return response($role, 200);
    }

    public function update(UpdateRoleRequest $request){

    }

    public function delete($id){
        $role = Role::find($id);
        if($role && $role->name != 'admin' && $role->name != 'user'){
            $role->delete();
            return response(null, 200);
        }
        return response(null, 404);
    }

    public function permissions(){
        $groups = Permission::groupBy('permission_group')->pluck('permission_group');
        $data = [];
        foreach ($groups as $group){
            $data[] = ['group'=>$group, 'permissions'=>Permission::where('permission_group', $group)->select('id', 'visible_name')->get()];
        }
        return response($data, 200);
    }
}
