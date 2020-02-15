<?php
namespace App\Algorithm;

use App\Repository\TarifsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class Algorithm{

    public function __construct(TarifsRepository $tRepo){
        $this->tRepo=$tRepo;

    }
    public function getDate($data){
        $a=explode("/",$data);
        return $data[2]."-".$data[1]."-".$data[0];

    }
    public function getFrais($montant){
        $tarifs=$this->tRepo->findAll();
        foreach ($tarifs as $tarif) {
            $frais=$tarif->getFrais();
            $borneInf=$tarif->getBorneInf();
            $borneSup=$tarif->getBorneSup();
            if(( $borneInf <= $montant ) && ($montant<= $borneSup) ){
               return  $frais ;
            }
        }
    }
   
    public function isAuthorised($userRoles,$usersModi){
        if($userRoles=="ROLE_ADMIN_SYST"){
            if($usersModi ==  "ROLE_ADMIN_SYST"){
                return false;
    
            }else{
                return true;
            }
        }
        if($userRoles=="ROLE_ADMIN"){  
            if($usersModi ==  "ROLE_ADMIN_SYST" || $usersModi ==  "ROLE_ADMIN" ){
                return false;

            }else{
                return true;
            }
       
        }


        if($userRoles=="ROLE_PARTENAIRE"){  
            if($usersModi ==  "ROLE_ADMIN_SYST" || $usersModi ==  "ROLE_ADMIN" || $usersModi ==  "ROLE_PARTENAIRE" ){
                return false;

            }else{
                return true;
            }
       
        }
    }


    public function validMontant($m){
        
        if($m>=500000){
            return true;
        }else{
            return false;
        }
    }
    public function isImage($file)
    {
        $extension=$file->guessExtension();
        if( ($extension === "png") ||( $extension === "jpeg") || ($extension === "pjpeg")  || ( $extension === "jpg") )
        {
            return true;
        }else{
            return false;
        }
    }
    public function genereNum($date,$id){
        return   date_format($date,"Ymd").$id;

    }
    public function PartExist($id){
    }
    function random() {
        return strval(rand(1,1999099999));
           }
}