<?php

namespace Modules\Jobs\Listeners;

use Modules\Jobs\Events\JobPosted;
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
        $job = $event->$job;

        $notifyData = [
            'name' => 'new job posted succefuly',
            'body' => 'new job posted succefuly.',
            'thanks' => 'Thank you',
            'job_id' => 007
        ];
  
        Notification::send($userSchema, new OffersNotification($notifyData));

    }
}
