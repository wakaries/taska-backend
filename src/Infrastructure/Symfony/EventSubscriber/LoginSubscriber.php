<?php

namespace App\Infrastructure\Symfony\EventSubscriber;

use App\Domain\Core\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Event\AuthenticationSuccessEvent;

class LoginSubscriber implements EventSubscriberInterface
{
    public function onSecurityAuthenticationSuccess(AuthenticationSuccessEvent $event): void
    {
        $token = $event->getAuthenticationToken();
        /** @var User $user */
        $user = $token->getUser();
        if ($user->getStatus() != 'active') {
//            throw new CustomUserMessageAccountStatusException('Usuario no activo');
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'security.authentication.success' => 'onSecurityAuthenticationSuccess',
        ];
    }
}
