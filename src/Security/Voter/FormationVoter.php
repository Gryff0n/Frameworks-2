<?php

namespace App\Security\Voter;

use App\Entity\Formation;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authorization\Voter\Vote;

class FormationVoter extends Voter
{
    const EDIT = 'FORMATION_EDIT';
    const DELETE = 'FORMATION_DELETE';

    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [self::EDIT, self::DELETE])
            && $subject instanceof Formation;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token, ?Vote $vote = null): bool
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        /** @var Formation $formation */
        $formation = $subject;

        return match($attribute) {
            self::EDIT => $this->canEdit($formation, $user),
            self::DELETE => $this->canDelete($formation, $user),
            default => false,
        };
    }

    private function canEdit(Formation $formation, User $user): bool
    {
        // Le responsable de la formation peut la modifier
        return $formation->getResponsable() === $user;
    }

    private function canDelete(Formation $formation, User $user): bool
    {
        // Le responsable de la formation peut la supprimer
        return $formation->getResponsable() === $user;
    }
}