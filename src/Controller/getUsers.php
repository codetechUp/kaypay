<?php 
namespace App\Controller;

use App\Repository\RolesRepository;
use App\Repository\UsersRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class getUsers 

{
    private $tokenStorage;
    public function __contruct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage=$tokenStorage;
    }

    public function __invoke(UsersRepository $use,RolesRepository $repo,TokenStorageInterface $tokenStorage,RolesRepository $role)
    {
        ###########################DECLARATION DES VARIABLES#####################
       ##########################################################################
       $userRole=$tokenStorage->getToken()->getUser()->getRoles()[0];
       $user=$tokenStorage->getToken()->getUser();
       $partner=$tokenStorage->getToken()->getUser()->getPartenaire();

       if($userRole==="ROLE_ADMIN_SYST")
      {
          $role=$role->findByLibelle($userRole)[0];
         $users= $use->getUsersForAS($role);
      }elseif($userRole==="ROLE_ADMIN")
      { $role1=$role->findByLibelle("ROLE_ADMIN_SYST")[0];
         $role2=$role->findByLibelle($userRole)[0];
         $users= $use->getUsersForA($role1,$role2);
      }elseif($userRole==="ROLE_PARTENAIRE"){
          $users=$user->getPartenaire()->getUsers();
      }elseif($userRole==="ROLE_PADMIN")
      {
        $users=$use->getUsersForPA($partner,$repo->findByLibelle("ROLE_PUSER")[0]);
      }
        ###########################TRAITEMENT DES DONNEES#####################
       ##########################################################################
      foreach($users as $user){
                if($user->getImage()){
        $user->setImage(base64_encode(stream_get_contents($user->getImage())));
                }
                 }
                return $users;
            
       
    }
   

}