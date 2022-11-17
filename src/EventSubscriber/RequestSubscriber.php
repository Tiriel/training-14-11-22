<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Twig\Environment;

class RequestSubscriber implements EventSubscriberInterface
{
    private Environment $twig;
    private bool $isMaintenance;

    public function __construct(Environment $twig, bool $isMaintenance)
    {
        $this->twig = $twig;
        $this->isMaintenance = $isMaintenance;
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        if ($this->isMaintenance) {
            $response = new Response();
            if ($event->isMainRequest()) {
                $response->setContent($this->twig->render('wip.html.twig'));
            }
            $event->setResponse($response);
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', 9999],
        ];
    }
}
