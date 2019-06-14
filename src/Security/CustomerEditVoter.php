<?php


namespace App\Security;


use App\Entity\Reservation;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class CustomerEditVoter extends Voter
{
    const CUSTOMER_EDIT_PRIVILEGE = 'CUSTOMER_EDIT_PRIVILEGE';

    protected function supports($attribute, $subject)
    {
        if ($attribute !== self::CUSTOMER_EDIT_PRIVILEGE) {
            return false;
        }

        if (!$subject instanceof Reservation) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        /** @var Reservation $reservation */
        $reservation = $subject;

        if ($reservation->getUser() !== $user) {
            return false;
        }

        return true;
    }
}