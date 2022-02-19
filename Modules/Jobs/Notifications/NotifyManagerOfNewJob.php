<?php

namespace Modules\Jobs\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NotifyManagerOfNewJob extends Notification
{
    use Queueable;
    private $notifyData;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($notifyData)
    {
        $this->notifyData = $notifyData;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)                    
            ->name($this->notifyData['name'])
            ->line($this->notifyData['body'])
            ->action($this->notifyData['job_id'])
            ->line($this->notifyData['thanks']);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'job_id' => $this->notifyData['job_id']
        ];
    }
}
