<?php

namespace App\Infrastructure\Symfony\Security\Voter;

use App\Security\Voter\Task;
use App\Security\Voter\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class TaskVoter extends Voter
{
    public const EDIT = 'TASK_EDIT';
    public const VIEW = 'TASK_VIEW';

    protected function supports(string $attribute, $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::EDIT, self::VIEW])
            && $subject instanceof \App\Domain\Core\Entity\Task;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }
        /** @var User $user */

        /** @var Task $task */
        $task = $subject;
        $userProjects = $task->getEpic()->getProject()->getUserProjects();
        $role = '';
        foreach ($userProjects as $userProject) {
            if ($userProject->getUser()->getId() == $user->getId()) {
                $role = $userProject->getRole();
            }
        }
        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::EDIT:
                if ($role == 'edit') {
                    return true;
                } else {
                    return false;
                }
            case self::VIEW:
                if (in_array($role, ['edit', 'detail'])) {
                    return true;
                } else {
                    return false;
                }
        }

        return false;
    }
}
