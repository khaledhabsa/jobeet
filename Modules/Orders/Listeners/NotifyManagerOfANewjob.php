<?php

namespace Modules\Orders\Listeners;

use Modules\Orders\Events\JobPosted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyManagerOfANewjob implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  JobPosted  $event
     * @return void
     */

    public function handle(JobPosted $event)
    {
        //$current_timestamp = Carbon::now()->toDateTimeString();

        $userinfo = $event->$job;

        // $saveHistory = DB::table('login_history')->insert(
        //     ['name' => $userinfo->name, 'email' => $userinfo->email, 'created_at' => $current_timestamp, 'updated_at' => $current_timestamp]
        // );
        return $userinfo;
    }
}
