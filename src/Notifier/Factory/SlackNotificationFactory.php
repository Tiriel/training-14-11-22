<?php

namespace App\Notifier\Factory;

use App\Notifier\Notification\SlackNotification;
use Symfony\Component\Notifier\Notification\Notification;

class SlackNotificationFactory implements NotificationFactoryInterface
{
    public function createNotification(): Notification
    {
        return new SlackNotification();
    }

    public static function getDefaultIndexName(): string
    {
        return 'slack';
    }
}