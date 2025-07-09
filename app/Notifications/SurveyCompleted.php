<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SurveyCompleted extends Notification
{
    use Queueable;

    protected $surveyTitle;
    protected $rewardAmount;
    protected $pointsAwarded;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($surveyTitle, $rewardAmount, $pointsAwarded)
    {
        $this->surveyTitle = $surveyTitle;
        $this->rewardAmount = $rewardAmount;
        $this->pointsAwarded = $pointsAwarded;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database']; // Store in database
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
            'type' => 'survey_completed',
            'survey_title' => $this->surveyTitle,
            'reward_amount' => $this->rewardAmount,
            'points_awarded' => $this->pointsAwarded,
            'message' => "Telah selesai mengisi survey \"{$this->surveyTitle}\" dengan reward sebesar Rp. {$this->rewardAmount} dan poin sebanyak {$this->pointsAwarded}.",
        ];
    }
}