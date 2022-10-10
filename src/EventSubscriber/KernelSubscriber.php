<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Twig\Environment;

class KernelSubscriber implements EventSubscriberInterface
{
    public function __construct(private Environment $twig) {}

    public function onKernelRequest(RequestEvent $event): void
    {
        $event->getRequest()->attributes->set('section2', 'section2');
        //$event->getRequest()->setlocale('es');
        $this->twig->addGlobal('section1', 'section1');
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', 10000],
        ];
    }
}
