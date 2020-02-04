<?php

namespace App\Security\Voter;

use App\Entity\Users;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserVoter extends Voter
{
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage =$tokenStorage;

    }
    protected function supports($attribute, $subject)
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['EDIT', 'VIEW','ADD'])
            && $subject instanceof \App\Entity\Users;
    }
    

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getToken()->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof Users) {
            return false;
        }
         $userRoles=$token->getToken()->getUser()->getRoles()[0];
        $usersModi = $subject->getRoles()[0];
        if($userRoles=="ROLE_ADMIN_SYST"){
            if($usersModi ==  "ROLE_ADMIN_SYST"){
                return false;
    
            }else{
                return true;
            }
        }
        elseif($userRoles=="ROLE_ADMIN"){  
            if($usersModi ==  "ROLE_ADMIN_SYST" || $usersModi ==  "ROLE_ADMIN" ){
                return false;

            }else{
                return true;
            }
        }
        else{
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        /**switch ($attribute) {
            case 'EDIT':
               if($security->isGranted($userRoles)){
                   return true;
               }
                break;
            case 'VIEW':
                // logic to determine if the user can VIEW
                // return true or false
                break;
        }*/

        return false;
    }
}
