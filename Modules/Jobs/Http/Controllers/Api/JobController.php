<?php

namespace Modules\Jobs\Http\Controllers\Api;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Jobs\Entities\Job;
use Modules\Jobs\Http\Requests\JobRequest;
use Illuminate\Support\Facades\DB;
use Modules\Jobs\Events\JobPosted;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        //var_dump(auth()->user()->company_id); exit;
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
        $job = new Job();
        $job->user_id          = $request->user('api')->id;
        $job->title            = $request->input('title') ;
        $job->description      = $request->input('description') ;
        $job->status           = $request->input('status') ;
        $job->save();

        // fire event to notify the manager with latest job posted.
        event(new JobPosted($job));

        return sendResponse(true, 'Job added successfully', []);
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
