<?php
namespace App\Controller;

use Exception;
use App\Algorithm\Algorithm;
use App\Entity\Transactions;
use App\Repository\AffectationsRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class  TransactionController{


    public function __construct(TokenStorageInterface $tokenStorage,Algorithm $algo){
     $this->algo=$algo;
    }
    public function __invoke(Transactions $data,TokenStorageInterface $tokenStorage,AffectationsRepository $repo){
 
   //montant
    $montant=$data->getMontant();
    //les frais
    $frais=$this->algo->getFrais($montant);
   //user emetteur
     $userEmetteur=$tokenStorage->getToken()->getUser();
    //user emetteur Role
    $role=$userEmetteur->getRoles()[0];
    if($role == "ROLE_PUSER"){
        $compteEmetteur=$repo->findCompteAffectTo($userEmetteur)[0]->getComptes();
        $data->setCompteEmetteur($compteEmetteur);
    }
    $data->setUserEmetteur($userEmetteur);
    $data->setCode($data->genCode());
    //Gestion des Frais
    $etat=$frais*0.4;
    $agence=$frais*0.3;
    $Pdepot=$frais*0.10;
    $Pretrait=$frais*0.20;
    $data->setPartEtat($etat);
    $data->setPartAgence($agence);
    $data->setPartPdepot($Pdepot);
    $data->setPRetrait($Pretrait);
    $solde=$compteEmetteur->getSolde();
    if(($solde-$montant)>0){
        $newSolde=$compteEmetteur->setSolde($solde-$montant);
        return $data;
    }else{
        throw new Exception("Le Solde de votre compte ne vous permet pas d'envoyer cette somme");
    }
    }
}