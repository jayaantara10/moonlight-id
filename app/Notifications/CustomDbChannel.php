<?php

namespace App\Notifications;

use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;

class CustomDbChannel
{
    public function send($notifiable, UserNotification $notification)
    {
        $data = $notification->toArray($notifiable);

        return $notifiable->routeNotificationFor('database')->create([ 
            'notifiable_id' => $notification->transaction->user_id,
            'type' => get_class($notification),
            'data' => $data,
            'read_at' => null,
        ]);
    }
}