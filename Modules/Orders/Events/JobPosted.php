<?php

namespace Modules\Orders\Events;

use Illuminate\Queue\SerializesModels;

class JobPosted
{
    use SerializesModels;
    public $job;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($job)
    {
        $this->job = $job;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('notify_channel');
    }
}
