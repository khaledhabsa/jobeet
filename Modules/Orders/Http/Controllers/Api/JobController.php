<?php

namespace Modules\Orders\Http\Controllers\Api;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Orders\Entities\Job;
use Modules\Orders\Http\Requests\JobRequest;
use Illuminate\Support\Facades\DB;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $user_type = auth()->user()->user_type;
        if($user_type == 'regular'){
            $trips = Job::where('user_id', auth()->user()->id)->get();
        }else{
            $trips = DB::table('jobs')
            ->join('users', 'users.id', '=', 'jobs.user_id')
            ->where('users.company_id', '=', auth()->user()->company_id)
            ->select('jobs.id','jobs.title','jobs.status', 'jobs.description')
            ->get();

        }
        return sendResponse(true, $trips);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(JobRequest $request)
    {
        $trip = new Job();
        $trip->user_id          = $request->user('api')->id;
        $trip->title            = $request->input('title') ;
        $trip->description      = $request->input('description') ;
        $trip->status           = $request->input('status') ;
        $trip->save();

        return sendResponse(true, 'Trip added successfully', []);
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
