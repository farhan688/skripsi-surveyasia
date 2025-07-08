<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProfileVerificationStatusChanged extends Notification
{
    use Queueable;

    protected $status;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($status)
    {
        $this->status = $status;
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
        $message = "Status verifikasi profil Anda telah berubah menjadi: ";
        if ($this->status == 'verified') {
            $message .= "Terverifikasi. Anda sekarang dapat mengisi survei.";
        } elseif ($this->status == 'rejected') {
            $message .= "Ditolak. Mohon periksa kembali data Anda.";
        } else {
            $message .= $this->status;
        }

        return [
            'type' => 'profile_verification_status_changed',
            'status' => $this->status,
            'message' => $message,
        ];
    }
}