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
      if($urlUse == "partenaire"){
        if(empty($_GET)){
          $id=$ex[4];
        $data=$this->compte->getAccountPart($id);
        $donnees=array();
        for($i=0;$i<count($data);$i++){
          foreach ($data as  $data) {
            $id=$data["id"];
          $data=$this->trans->getPartPart($id);
          $donnees=array_merge($donnees,$data);
          }
          return $donnees;
        }
        
        
        }else{
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
            dd($donnees);
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