<?php

namespace App\Notifier;

use App\Notifier\Factory\NotificationFactoryInterface;
use Symfony\Component\Notifier\NotifierInterface;

class MovieNotifier
{
    private NotifierInterface $notifier;
    /** @var NotificationFactoryInterface[] */
    private iterable $factories;

    public function __construct(NotifierInterface $notifier, iterable $factories)
    {
        $this->notifier = $notifier;
        $this->factories = $factories instanceof \Traversable ? iterator_to_array($factories) : $factories;
    }

    public function sendNotification($user)
    {
        $user = new class {
            public function getPreferredChannel(): string
            {
                return 'slack';
            }
        };
        $notification = $this->factories[$user->getPreferredChannel()]->createNotification();

        $this->notifier->send($notification);
    }
}