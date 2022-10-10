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
        $request = $event->getRequest();
        $request->setLocale('es');
        $request->attributes->set('section2', 'SECTION2');

        $this->twig->addGlobal('section3', [
            'value' => 'value3'
        ]);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', 10000],
        ];
    }
}
