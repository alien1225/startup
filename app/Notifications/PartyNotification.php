<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\User;
use Illuminate\Notifications\Messages\BroadcastMessage;
use App\Http\Resources\PartyResource;

class PartyNotification extends Notification
{
    use Queueable;

    public $data;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($party, string $type, string $message)
    {
        $this->data = [
            'message' => $message,
            'type' => $type,
            'party' => new PartyResource($party),
        ];
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['broadcast'];
    }

    public function broadcastType() {
        return $this->data['type'];
    }
    

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'message' => $this->data['message'],
            'party' => $this->data['party'],
        ]);
    }
}
