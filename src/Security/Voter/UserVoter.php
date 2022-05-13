<?php

namespace App\Security\Voter;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class  UserVoter extends Voter
{
    protected function supports($attribute, $subject)
    {

        return in_array($attribute, ['view', 'delete', 'add'])
            && $subject instanceof User;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case 'view':
                // logic to determine if the user can VIEW
                return $this->canView($subject, $user);
                break;
            case 'delete':
                return $this->canDelete($subject, $user);
                break;
        }

        return false;
    }

    private function canView(User $subject, User $user)
    {
        return $user->getId() === $subject->getId();
    }

    private function canDelete(User $subject, User $user)
    {
        if ($this->canView($subject, $user)) {
            return true;
        }
    }
}
