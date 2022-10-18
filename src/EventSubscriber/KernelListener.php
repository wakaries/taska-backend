<?php
namespace App\EventSubscriber;

use Symfony\Component\HttpKernel\Event\RequestEvent;

class KernelListener
{
    public function onKernelRequest(RequestEvent $event)
    {
        // ...
    }
}