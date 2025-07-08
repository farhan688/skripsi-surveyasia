<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RespondentCompletedSurvey extends Notification
{
    use Queueable;

    protected $respondentName;
    protected $surveyTitle;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($respondentName, $surveyTitle)
    {
        $this->respondentName = $respondentName;
        $this->surveyTitle = $surveyTitle;
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
            'type' => 'respondent_completed_survey',
            'respondent_name' => $this->respondentName,
            'survey_title' => $this->surveyTitle,
            'message' => "{$this->respondentName} telah mengisi survey \"{$this->surveyTitle}\" Anda.",
        ];
    }
}