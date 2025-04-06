<?php

namespace App\Security\Voter;

use App\Entity\Person;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class PersonVoter extends Voter
{
    protected function supports(string $attribute, mixed $subject): bool
    {
        // Check if the attribute is 'view' or 'delete' and the subject is an instance of Person
        return in_array($attribute, ['view', 'delete']) && $subject instanceof Person;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        // If the user is anonymous, do not grant access
        if (!$user instanceof User) {
            return false;
        }

        // Logic based on the attribute
        switch ($attribute) {
            case 'view':
                return $this->canView($subject, $user);
            case 'delete':
                return $this->canDelete($subject, $user);
        }

        return false;
    }

    private function canView(Person $subject, User $user): bool
    {
        // Only allow viewing if the user is the owner of the Person entity
        return $user->getId() === $subject->getUserClient()->getId();
    }

    private function canDelete(Person $subject, User $user): bool
    {
        // Allow deletion if the user can view the entity
        return $this->canView($subject, $user);
    }
}
