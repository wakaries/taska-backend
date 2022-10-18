<?php
namespace App\Infrastructure\Symfony\Security;

use App\Domain\Core\Entity\User as AppUser;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user): void
    {
        if (!$user instanceof AppUser) {
            return;
        }

        if ($user->getStatus() != 'active') {
            throw new CustomUserMessageAccountStatusException('Usuario no activo');
        }
    }

    public function checkPostAuth(UserInterface $user): void
    {
    }
}