<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BadgeAchieved extends Notification
{
    use Queueable;

    protected $badgeName;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($badgeName)
    {
        $this->badgeName = $badgeName;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'type' => 'badge_achieved',
            'badge_name' => $this->badgeName,
            'message' => "Selamat Anda telah mencapai tier {$this->badgeName}.",
        ];
    }
}