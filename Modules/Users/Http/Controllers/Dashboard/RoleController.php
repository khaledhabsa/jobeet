<?php

namespace Modules\Users\Http\Controllers\Dashboard;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Modules\Users\Http\Requests\EditRole;
use Modules\Users\Http\Requests\Roles;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class RoleController extends Controller
{
    protected $module;

    public function __construct()
    {
        $this->module = 'roles';
    }

    public function index(Request $request)
    {
        $roles = Role::paginate(20);

        $links = $roles->links();
        if ($request->ajax()) {
            return view('users::roles.table', ['roles' => $roles, 'links' => $links ])->render();
        }

        return view('users::roles.index', compact( 'roles', 'links'));
    }

    public function create()
    {
        $permissions = [];
        foreach (Permission::pluck('name') as $permission) {
            $permission =  explode('.',$permission);
            $permissions[$permission[0]][] = $permission[1];
        }
        return view('users::' . $this->module . '.create', compact('permissions'))->with(['module' => $this->module]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:roles,name',
            'permissions' => 'required|array|min:1',
            'permissions.*' => 'required|string|exists:permissions,name',
        ],['permissions.*' => 'You have to choose at least one permission']);

        if ($validator->fails()){
            return response()->json(['errors' => $validator->errors()]);
        }

        $role = Role::create(['name' =>$request->name, 'guard_name' => 'web']);
        $role->syncPermissions($request->permissions);

        return response()->json(['success' => true, 'url'=> route($this->module . '.index')]);
    }


    public function edit(Role $role)
    {
        $permissions = [];
        foreach (Permission::pluck('name') as $permission) {
            $permission =  explode('.',$permission);
            $permissions[$permission[0]][] = $permission[1];
        }
        $rolePermissions = $role->permissions->pluck('name')->toArray();
        return view('users::' . $this->module . '.edit', compact('role', 'permissions', 'rolePermissions'))->with(['module' => $this->module]);
    }

    public function update(Request $request, Role $role)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:roles,name,'.$role->id,
            'permissions' => 'required|array|min:1',
            'permissions.*' => 'required|string|exists:permissions,name',
        ],['permissions.*' => 'You have to choose at least one permission']);

        if ($validator->fails()){
            return response()->json(['errors' => $validator->errors()]);
        }
        $role->update(['name' =>$request->name]);

        $role->syncPermissions($request->permissions);
        return response()->json(['success' => true, 'url'=> route($this->module . '.index')]);
    }

    public function destroy(Role $role)
    {
        if ($role->id == 1){
            request()->session()->flash('danger', "Can't delete this role");
            return redirect()->back();
        }

        $role->delete();
        return redirect()->route( $this->module . '.index');
    }

    public function datatableList(){
        $books = Role::all();
        return Datatables::of($books)
            ->addColumn('action', function ($model) {
                return view('users::roles.actions',compact('model'));
            })
            ->make(true);
    }
}
