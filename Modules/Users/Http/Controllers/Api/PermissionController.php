<?php

namespace Modules\Users\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Modules\Users\Http\Requests\EditRole;
use Modules\Users\Http\Requests\Roles;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        $permissions = [];
        foreach (Permission::where('guard_name', 'api')->pluck('name') as $permission) {
            $p =  explode('.',$permission);
            $permissions[$p[0]][$permission] = __('permissions.'.$permission);
        }

        return sendResponse('true', 'Existing permissions', $permissions);
    }
}
