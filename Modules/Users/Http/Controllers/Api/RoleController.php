<?php

namespace Modules\Users\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::where('guard_name', 'api')->get(['id', 'name']);
        return sendResponse('true', 'Existing roles', $roles);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:roles,name',
            'permissions' => 'required|array|min:1',
            'permissions.*' => 'required|string|exists:permissions,name',
        ],['permissions.*' => 'You have to choose at least one permission']);

        if ($validator->fails()){
            return sendResponse( false, $validator->errors(),[], 422);
        }

        $role = Role::create(['name' =>$request->name, 'guard_name' => 'api']);
        $role->syncPermissions($request->permissions);

        return sendResponse( false, 'Role added successfully',[]);
    }


    public function Show(Role $role)
    {
        $role = $role->load('permissions:id,name');

        $permissions = [];
        foreach ($role->permissions as $permission) {
            $p =  explode('.',$permission->name);
            $permissions[$p[0]][$permission->name] = __('permissions.'.$permission->name);
        }

        $r['id'] = $role->id;
        $r['name'] = $role->name;
        $r['permissions'] = $permissions;
        return sendResponse( false, 'Role details', $r);
    }

    public function update(Request $request, Role $role)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:roles,name,'.$role->id,
            'permissions' => 'required|array|min:1',
            'permissions.*' => 'required|string|exists:permissions,name',
        ],['permissions.*' => 'You have to choose at least one permission']);

        if ($validator->fails()){
            return sendResponse( false, $validator->messages()[0],[], 422);
        }

        $role->update(['name' =>$request->name]);
        $role->syncPermissions($request->permissions);

        return sendResponse( true, 'Role added successfully',[]);
    }

    public function destroy(Role $role)
    {
        if ($role->id == 1){
            request()->session()->flash('danger', "Can't delete this role");
            return sendResponse( false, "Can't delete this role",[], 422);
        }

        $role->delete();
    }
}
