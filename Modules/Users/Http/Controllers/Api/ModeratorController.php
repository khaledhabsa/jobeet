<?php

namespace Modules\Users\Http\Controllers\Api;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Modules\Users\Entities\User;
use Modules\Users\Http\Requests\ModeratorRequest;
use Modules\Users\Transformers\ProfileResource;

class ModeratorController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('users::index');
    }

    /**
     * Store a newly created resource in storage.
     * @param ModeratorRequest $request
     * @return JsonResponse
     */
    public function store(ModeratorRequest $request)
    {
        $user = new user();
        // fixed company_id till we complete senario.
        $user->company_id   = 1;
        $user->email        = $request->input('email');
        $user->name         = $request->input('name');
        $user->password     = Hash::make($request->input('password'));
        $user->user_type    = 'regular';
        $user->save();
        $user->assignRole('1');

        //return sendResponse(true, 'Moderator created successfully', [], 201);
        return sendResponse(true, __('messages.successfully_registered'));
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
