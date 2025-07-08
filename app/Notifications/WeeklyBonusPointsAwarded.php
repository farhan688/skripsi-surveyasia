<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WeeklyBonusPointsAwarded extends Notification
{
    use Queueable;

    protected $bonusAmount;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($bonusAmount)
    {
        $this->bonusAmount = $bonusAmount;
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
            'type' => 'weekly_bonus_awarded',
            'bonus_amount' => $this->bonusAmount,
            'message' => "Selamat bonus poin mingguan Anda sebesar {$this->bonusAmount} telah masuk.",
        ];
    }
}