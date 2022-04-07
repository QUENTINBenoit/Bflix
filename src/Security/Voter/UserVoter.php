<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Security;

class UserVoter extends Voter
{
    public function __construct(
        private Security $security
    ) {
    }
    protected function supports(string $attribute, $subject): bool
    {
        return in_array($attribute, ['USER_EDIT', 'USER_VIEW'])
            && $subject instanceof \App\Entity\User;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        // Si j'ai passé le test de la méthode supports, 
        // on ettérit dans cette méthode voteOnAttribute()


        // dd ('On est bein dea la méthode voteOnAttribute)

        // currentUser est l'utilisateur actuellement connecté
        $currentUser = $token->getUser();

        // if the user is anonymous, do not grant access
        if (!$currentUser instanceof UserInterface) {
            return false;
        }

        $userRoles = $subject->getRoles();

        switch ($attribute) {
            case 'USER_EDIT':
                // Je vérifie si je suis propiétaite de compte avec $currentUser === $subject
                // ou si j'ai un role super admin 
                // $this->security->isGranted('ROLE_SUPER_ADMIN' me retourne 
                // - Vrai : si personne connecté a role SUPER_ADMIN
                // - Faux : dans le cas contraire  
                if ($currentUser === $subject || $this->security->isGranted('ROLE_SUPER_ADMIN')) {
                    return \true;
                }

                // Si l'utilisateur  à éfditer est un simle user (ROLE_USER)
                // un Admin devrair pour l'editer

                if (count($userRoles) === 1 && $userRoles[0] == 'ROLES_USER') {
                    return \true;
                }
                break;

            case 'USER_VIEW':
                // logic to determine if the user can VIEW
                // return true or false
                break;
        }

        return false;
    }
}
