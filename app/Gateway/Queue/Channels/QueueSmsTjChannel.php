<?php

namespace App\Gateway\Queue\Channels;


use App\Gateway\Sms\OsonSmsGateway;
use Faker\Provider\Uuid;
use Illuminate\Notifications\Notification;

class QueueSmsTjChannel
{
    /**
     * @param $notifiable
     * @param Notification $notification
     */
    public function send($notifiable, Notification $notification): void
    {
        $message = call_user_func(array($notification, 'toSmsTj'), $notifiable);

        $to = $notifiable->routeNotificationForSmsTj();

        OsonSmsGateway::send($to, $message, Uuid::uuid());
    }
}
