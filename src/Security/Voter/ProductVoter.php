<?php

namespace App\Security\Voter;

use App\Entity\Product;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class ProductVoter extends Voter
{
    protected function supports($attribute, $subject)
    {

        return in_array($attribute, ['view', 'delete',  'add'])
            && $subject instanceof Product;
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
                return $this->canView($subject, $product);
                break;
            case 'delete':
                return $this->canDelete($subject, $product);
                break;

            case 'add':
                return $this->canAdd($subject, $product);
                break;
        }

        return false;
    }

    private function canView(Product $subject, User $user)
    {
        return $user->getId() === $subject->getProduit()->getId();
    }

    private function canDelete(Product $subject, User $user)
    {
        if ($this->canView($subject, $user)) {
            return true;
        }
      }
       

    private function canAdd(Product $subject, User $user)
    {
        if ($this->canView($subject, $user)) {
            return true;
        }
      }
}
