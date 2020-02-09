<?php
namespace App\Controller;

use DateTime;
use Exception;
use App\Entity\Transactions;
use App\Repository\AffectationsRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class  RetraitController{


    public function __construct(TokenStorageInterface $tokenStorage){
     
    }
    public function __invoke(Transactions $data,TokenStorageInterface $tokenStorage,AffectationsRepository $repo){
   if($data->getIsActive()){
       //user emetteur
     $userRecept=$tokenStorage->getToken()->getUser();
     //user Recept Role
     $role=$userRecept->getRoles()[0];
     if($role= "ROLE_PUSER"){
         $compteRecept=$repo->findCompteAffectTo($userRecept)[0]->getComptes();
         $data->setCompteRecept($compteRecept);
     }
     $data->setUserRecep($userRecept);
     $data->setDateRetrait(new DateTime());
     $solde=$compteRecept->getSolde();
     //montant
     $montant=$data->getMontant();
     $newSolde=$compteRecept->setSolde($solde+$montant);
     $data->setIsActive(false);
     return $data; 
   }
   else{
       throw new Exception("L'argent est déja retiré");
   }
        
    }
}