<?php

namespace App\Notifier\Notification;

use Symfony\Component\Notifier\Message\ChatMessage;
use Symfony\Component\Notifier\Recipient\RecipientInterface;

class DiscordNotification extends \Symfony\Component\Notifier\Notification\Notification implements \Symfony\Component\Notifier\Notification\ChatNotificationInterface
{

    public function asChatMessage(RecipientInterface $recipient, string $transport = null): ?ChatMessage
    {
        return new ChatMessage('new Movier');
    }
}