<?php

namespace App\Notifications;

use App\Models\Log;
use App\Models\Queue;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Ramsey\Uuid\Type\Integer;

class ASPAKSyncUpdate extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Integer $success, Integer $failed, string $q, int $log)
    {
        $this->success = $success;
        $this->failed = $failed;
        $this->q = $q;
        $this->log = $log;
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
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
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
            'title' => "Sinkronisasi ASPAK ".ucfirst($this->q),
            'message' => $this->success." item berhasil dikirim \n".$this->failed." item gagal dikirim",
            'url' => route('queue.logs', ['queue' => $this->log->id]),
        ];
    }
}
