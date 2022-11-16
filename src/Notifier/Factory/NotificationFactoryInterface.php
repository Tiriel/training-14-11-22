<?php

namespace App\Notifier\Factory;

use Symfony\Component\Notifier\Notification\Notification;

interface NotificationFactoryInterface
{
    public function createNotification(): Notification;

    public static function getDefaultIndexName(): string;
}