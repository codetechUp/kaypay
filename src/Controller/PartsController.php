<?php

namespace App\Controller;

use App\Entity\Depots;
use App\Algorithm\Algorithm;
use App\Entity\Affectations;
use App\Repository\ComptesRepository;
use App\Repository\PartenaireRepository;
use App\Repository\TransactionsRepository;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Config\Definition\Exception\Exception;



class PartsController
{
   public function __construct(TransactionsRepository $trans,ComptesRepository $compte)
   {
     $this->trans=$trans;
     $this->compte=$compte;
   }

    public function __invoke()
    {
      
      
      //Recupperation de l'url
      $url=$_SERVER["REQUEST_URI"];
      //explose de l'url
      $ex=explode("/",$url);
      //recupperation part agence ou etat 
      $urlUse=$ex[3];

      ###########################TRAITEMENT DES DONNEES#####################
       ##########################################################################

       //si l utilistateur vas sur /partenaire/{id}
      if($urlUse == "partenaire"){
        //si y'a des parametres dans url
        if(empty($_GET)){
          //je recuppere l'id
          $id=$ex[4];          
          //je les comptes du partenaire
        $data=$this->compte->getAccountPart($id);
        //j'initialise un tableau vide pour y mettre les donnees
        $donnees=array();
        //Je parcours les Comptes du partenaire
        for($i=0;$i<count($data);$i++){
          //Pour Chaque comptes
          foreach ($data as  $data) {
            //je recuppere l'id du compte
            $id=$data["id"];
            //je recuppere les part du partenaire pour ce compte
          $data=$this->trans->getPartPart($id);
          //J'ajoute le part de cette compte dans mon tableau initialisé
          //Et pour tout part du partenaire par compte seront assemblés dans un seul tableau
          $donnees=array_merge($donnees,$data);
          }
          //Je Renvoie les donnees
          
          return $donnees;
        }
        
        
        }else{
          //si y a des parametres dans url
          $a=$ex[4];
          $id=explode("?",$a)[0];
          $urlUse=explode("?",$urlUse)[0];
          $debut=$_GET["debut"];
          $fin=$_GET["fin"];
          $data=$this->compte->getAccountPart($id);
          $donnees=array();
          for($i=0;$i<count($data);$i++){
            foreach ($data as  $data) {
              $id=$data["id"];
            $data=$this->trans->getPartPart($id,$debut,$fin);
            $donnees=array_merge($donnees,$data);
            }
            return $donnees;
           
          }
          
        }
        
      }else{
        if(empty($_GET)){
          $data=$this->trans->findPart($urlUse);
        return $data;
        }else{
          $urlUse=explode("?",$urlUse)[0];
          $debut=$_GET["debut"];
          $fin=$_GET["fin"];
          $data=$this->trans->findPart($urlUse,$debut,$fin);
          return $data;
        }
      }

         
    }
}