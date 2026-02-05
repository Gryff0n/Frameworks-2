<?php

namespace App\Security\Voter;

use App\Entity\Cours;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authorization\Voter\Vote;

class CoursVoter extends Voter
{
    const EDIT = 'COURS_EDIT';
    const EDIT_LIMITED = 'COURS_EDIT_LIMITED'; // Pour responsable de cours (description + enseignants seulement)
    const DELETE = 'COURS_DELETE';
    const REMOVE_ENSEIGNANT = 'COURS_REMOVE_ENSEIGNANT'; // Pour qu'un enseignant se retire

    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [self::EDIT, self::EDIT_LIMITED, self::DELETE, self::REMOVE_ENSEIGNANT])
            && $subject instanceof Cours;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token, ?Vote $vote = null): bool
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        /** @var Cours $cours */
        $cours = $subject;

        return match($attribute) {
            self::EDIT => $this->canEdit($cours, $user),
            self::EDIT_LIMITED => $this->canEditLimited($cours, $user),
            self::DELETE => $this->canDelete($cours, $user),
            self::REMOVE_ENSEIGNANT => $this->canRemoveEnseignant($cours, $user),
            default => false,
        };
    }

    private function canEdit(Cours $cours, User $user): bool
    {
        // Le responsable de formation peut modifier tous les cours de sa formation
        foreach ($cours->getFormations() as $formation) {
            if ($formation->getResponsable() === $user) {
                return true;
            }
        }
        return false;
    }

    private function canEditLimited(Cours $cours, User $user): bool
    {
        // Le responsable du cours peut modifier description et enseignants
        return $cours->getResponsable() === $user;
    }

    private function canDelete(Cours $cours, User $user): bool
    {
        // Seul le responsable de formation peut supprimer un cours
        foreach ($cours->getFormations() as $formation) {
            if ($formation->getResponsable() === $user) {
                return true;
            }
        }
        return false;
    }

    private function canRemoveEnseignant(Cours $cours, User $user): bool
    {
        // Un enseignant peut se retirer du cours s'il en fait partie
        return $cours->getEnseignants()->contains($user);
    }
}