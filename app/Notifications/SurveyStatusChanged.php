<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SurveyStatusChanged extends Notification
{
    use Queueable;

    protected $surveyTitle;
    protected $status;

    /**
     *
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($surveyTitle, $status)
    {
        $this->surveyTitle = $surveyTitle;
        $this->status = $status;
    }

    /**
     *
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
     *
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $message = "Status survei \"{$this->surveyTitle}\" Anda telah berubah menjadi: ";
        if ($this->status == 'active') {
            $message .= "Disetujui. Survei Anda sekarang aktif.";
        } elseif ($this->status == 'rejected') {
            $message .= "Ditolak. Mohon periksa kembali survei Anda.";
        } else {
            $message .= $this->status;
        }

        return [
            'type' => 'survey_status_changed',
            'survey_title' => $this->surveyTitle,
            'status' => $this->status,
            'message' => $message,
        ];
    }
}