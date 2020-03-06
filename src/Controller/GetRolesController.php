<?php

namespace App\Controller;

use App\Repository\RolesRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;



class GetRolesController
{
   public function __construct(RolesRepository $role,TokenStorageInterface $tokenStorage){
    $this->role=$role;
    $this->tokenStorage=$tokenStorage;
   }

    public function __invoke()
    {
     
      $userRole=$this->tokenStorage->getToken()->getUser()->getRoles()[0];
     
      if($userRole==="ROLE_ADMIN_SYST")
      {
          return $this->role->roleForAS();
      }
      elseif($userRole==="ROLE_ADMIN")
      {
          return $this->role->roleForA();
      }elseif($userRole==="ROLE_PARTENAIRE")
      {
          return $this->role->roleForP();
      }elseif($userRole==="ROLE_PADMIN")
      {
          return $this->role->roleForPA();
      }



    }
}