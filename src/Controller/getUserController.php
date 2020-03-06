<?php
namespace App\Controller;

use App\Repository\UsersRepository;



class getUserController{
    
    public function __construct(UsersRepository $use){
$this->use=$use;
    }
    public function __invoke(){


        ###########################DECLARATION DES VARIABLES#####################
       ##########################################################################
            //Recupperation de l'url
            $url=$_SERVER["REQUEST_URI"];
            //explose de l'url
            $ex=explode("/",$url);
            $id=$ex[3];
            //Recupperation du user
            $data=$this->use->find($id);

        ###########################TRAITEMENT DE DONNEES#####################
       ##########################################################################
       if($data->getImage()){
        $data->setImage(base64_encode(stream_get_contents($data->getImage())));

       }
        
        return $data;


    }
}