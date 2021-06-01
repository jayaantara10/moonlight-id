<?php

namespace App\Notifications;

use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;

class CustomDbChannelAdmin
{
    public function send($notifiable, AdminNotification $notification)
    {
        $data = $notification->toArray($notifiable);

        return $notifiable->routeNotificationFor('database')->create([ 
            'notifiable_id' => 2,
            'type' => get_class($notification),
            'data' => $data,
            'read_at' => null,
        ]);
    }
}