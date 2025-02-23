<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Filament\Notifications\Notification as FilamentNotification;

class NewUserRegistered extends Notification
{
    use Queueable;

    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'User Registration!',
            'body' => "{$this->user->name}Registered",
            'url' => url('/admin/users'),
        ];
    }
}
