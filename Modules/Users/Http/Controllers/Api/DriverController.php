<?php

namespace Modules\Users\Http\Controllers\Api;

use App\Traits\UploadFiles;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Modules\Users\Entities\DriverInfo;
use Modules\Users\Entities\User;
use Modules\Users\Http\Requests\DriverRequest;
use Modules\Users\Http\Requests\ModeratorRequest;

class DriverController extends Controller
{
    use UploadFiles;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('users::index');
    }

    public function store(DriverRequest $request)
    {
        $user = new user();
        $user->parent_id    = auth()->user()->id;
        $user->email        = $request->input('email');
        $user->name         = $request->input('name');
        $user->password     = Hash::make($request->input('password'));
        if ($request->input('profile_image')){
            $user->profile_image = $this->uploadS3File($request->file('profile_image'), 'profiles');
        }
        $user->user_type    = 'driver';
        $user->save();

        $driver_info = new DriverInfo();
        $driver_info->license = $this->uploadS3File($request->file('license_image'), 'drivers');
        $driver_info->criminal_record = $this->uploadS3File($request->file('criminal_record_image'), 'drivers');

        return sendResponse(true, 'Driver created successfully', [], 201);
    }


    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('users::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('users::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
