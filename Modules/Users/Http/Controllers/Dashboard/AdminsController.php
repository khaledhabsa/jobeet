<?php

namespace Modules\Users\Http\Controllers\Dashboard;

use App\Traits\UploadFiles;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Modules\Users\Entities\User;
use Modules\Users\Http\Requests\AdminRequest;
use Modules\Users\Http\Requests\CreateAdmin;
use Modules\Users\Http\Requests\EditAdmin;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class AdminsController extends Controller
{
    use UploadFiles;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::where('user_type', 'admin');
        $keyword = $request->filter_keyword;
        if($keyword){
            $users = $users->where('name', 'like', '%'.$keyword.'%')->orwhere('email', 'like', '%'.$keyword.'%');
        }

        $users = $users->paginate(20);
        $links = $users->links();
        if ($request->ajax()) {
            return view('users::admins.table', ['users' => $users, 'links' => $links ])->render();
        }

        return view('users::admins.index', compact( 'users', 'links'));    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $roles = Role::all(['id','name']);
        return view('users::admins.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'                  => 'required|string|min:3',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|string|confirmed|min:8',
            'profile_image_file'    => 'nullable|image|max:2048|dimensions:width=80,height=80'
        ]);

        if ($validator->fails()){
            return response()->json(['errors' => $validator->errors()]);
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->user_type = 'admin';

        if ($request->hasFile('profile_image_file')){
            $user->profile_image = $this->uploadS3File($request->profile_image_file, 'profiles');
        }

        $user->save();
        $user->assignRole($request->role_id);
        $request->session()->flash('success', 'Admin added successfully');
        return response()->json(['success' => true, 'url'=> route('admins.index')]);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('users::admins.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(User $admin)
    {
        $roles = Role::all(['id','name']);
        return view('users::admins.edit', compact('admin', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     */
    public function update(Request $request, User $admin)
    {
        $validator = Validator::make($request->all(), [
            'name'                  => 'required|string|min:3',
            'email'                 => 'required|email|unique:users,email,'.$admin->id,
            'password'              => 'nullable|string|confirmed|min:8',
            'profile_image_file'    => 'nullable|image'
        ]);

        if ($validator->fails()){
            return response()->json(['errors' => $validator->errors()]);
        }

        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->user_type = 'admin';

        if ($request->has('password')){
            $admin->password = Hash::make($request->password);
        }

        if ($request->hasFile('profile_image_file')){
            $admin->profile_image = $this->uploadS3File($request->profile_image_file, 'profiles');
        }

        $admin->save();
        $admin->syncRoles($request->role_id);

        $request->session()->flash('success', 'Admin updated successfully');
        return response()->json(['success' => true, 'url'=> route('admins.index')]);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $admin)
    {
        if ($admin->id == 1){
            request()->session()->flash('danger', "Can't delete this account");
            return redirect()->back();
        }

        User::findOrFail($admin->id)->delete();
        request()->session()->flash('success', 'Admin deleted successfully');

        return redirect()->route('admins.index');
    }

    public function datatableList(){
        $users = User::where('user_type', 'admin')->get();
        return Datatables::of($users)
            ->addColumn('action', function ($model) {
                return view('users::admins.actions',compact('model'));
            })
            ->make(true);
    }

    /**
     * Show the form for edit a resource.
     * @return Renderable
     */
    public function EditProfile()
    {
        $admin = Auth::user();
        return view('users::admins.profile', compact('admin'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     */
    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'                  => 'required|string|min:3',
            'email'                 => 'required|email|unique:users,email,'.Auth::id(),
            'password'              => 'nullable|string|confirmed|min:8',
            'profile_image_file'    => 'nullable|image'
        ]);

        if ($validator->fails()){
            return response()->json(['errors' => $validator->errors()]);
        }

        $admin = Auth::user();

        $admin->name = $request->name;
        $admin->email = $request->email;

        if ($request->has('password')){
            $admin->password = Hash::make($request->password);
        }

        if ($request->hasFile('profile_image_file')){
            $admin->profile_image = $this->UpdateS3File($request->profile_image_file, 'profiles', $admin->profile_image, true, 80,80);
        }

        $admin->save();

        $request->session()->flash('success', 'Profile updated successfully');
        return response()->json(['success' => true, 'url'=> route('admins.profile.edit')]);
    }
}
