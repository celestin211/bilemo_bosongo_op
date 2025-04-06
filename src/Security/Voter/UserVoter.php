<?php

namespace App\Security\Voter;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;


class UserVoter extends Voter
{
    protected function supports(string $attribute, mixed $subject): bool
    {
        // Check if the attribute is one of 'view', 'delete', 'add' and the subject is a User
        return in_array($attribute, ['view', 'delete', 'add'])
            && $subject instanceof User;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        // If the user is anonymous, do not grant access
        if (!$user instanceof User) {
            return false;
        }

        // Logic to handle the different actions
        switch ($attribute) {
            case 'view':
                // logic to determine if the user can VIEW
                return $this->canView($subject, $user);
            case 'delete':
                return $this->canDelete($subject, $user);
            case 'add':
                return $this->canAdd($subject, $user); // You can add additional logic for 'add' if needed
            default:
                return false; // Default case for unsupported attributes
        }
    }

    private function canView(User $subject, User $user): bool
    {
        // A user can view their own data, or if they are an admin (you can add roles check)
        return $user->getId() === $subject->getId() || in_array('ROLE_ADMIN', $user->getRoles());
    }

    private function canDelete(User $subject, User $user): bool
    {
        // A user can delete their own data, or if they are an admin (you can add roles check)
        return $user->getId() === $subject->getId() || in_array('ROLE_ADMIN', $user->getRoles());
    }

    private function canAdd(User $subject, User $user): bool
    {
        // You can customize this logic based on your business requirements, for instance:
        // Only admin users can add new users (you can add more conditions here)
        return in_array('ROLE_ADMIN', $user->getRoles());
    }
}
