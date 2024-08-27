<?php

namespace App\Notifications;

use App\Gateway\Queue\Channels\QueueSmsTjChannel;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VerifyPhoneNotification extends Notification
{
    public function __construct()
    {
    }

    public function via($notifiable): array
    {
        return [QueueSmsTjChannel::class];
    }

    public function toSmsTj($notifiable): string
    {
        return sprintf('Салом. Код подтверждения: %s', $notifiable->sms_code);
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}
