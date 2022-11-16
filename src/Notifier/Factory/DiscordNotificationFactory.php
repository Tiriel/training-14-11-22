<?php

namespace App\Notifier\Factory;

use App\Notifier\Notification\DiscordNotification;
use Symfony\Component\Notifier\Notification\Notification;

class DiscordNotificationFactory implements NotificationFactoryInterface
{

    public function createNotification(): Notification
    {
        return new DiscordNotification();
    }

    public static function getDefaultIndexName(): string
    {
        return 'discord';
    }
}