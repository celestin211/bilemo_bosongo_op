<?php

namespace App\Security\Voter;

use App\Entity\Product;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class ProductVoter extends Voter
{
    protected function supports(string $attribute, mixed $subject): bool
    {
        // Check if the attribute is one of 'view', 'delete', 'add' and the subject is a Product
        return in_array($attribute, ['view', 'delete', 'add']) && $subject instanceof Product;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        // If the user is anonymous, do not grant access
        if (!$user instanceof User) {
            return false;
        }

        // Determine if the user has permission based on the attribute
        switch ($attribute) {
            case 'view':
                return $this->canView($subject, $user);
            case 'delete':
                return $this->canDelete($subject, $user);
            case 'add':
                return $this->canAdd($subject, $user);
        }

        return false;
    }

    private function canView(Product $subject, User $user): bool
    {
        // Example: Assuming a Product belongs to a User (this may vary)
        // Adjust this logic based on how your system defines the "view" permission.
        return $user->getId() === $subject->getUserClient()->getId();
    }

    private function canDelete(Product $subject, User $user): bool
    {
        // Example: User can delete the Product if they own it (customize based on your logic)
        return $this->canView($subject, $user); // You can reuse canView for delete permission if applicable
    }

    private function canAdd(Product $subject, User $user): bool
    {
        // Example: User can add a product if they are authorized to add a product
        // This logic can vary, e.g., checking if the user has a specific role or permission
        // Adjust according to your application's requirements
        return in_array('ROLE_ADMIN', $user->getRoles());
    }
}
