<?php
// api/src/Controller/CreateMediaObjectAction.php
namespace App\Controller;

use App\Entity\Users;
use App\Repository\UsersRepository;;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;


final class ImageController 
{

    
    public function __invoke(UsersRepository $use,Request $request)
{
  header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Methods:  POST");


  ###########################DECLARATION DES VARIABLES#####################
       ##########################################################################*
       //Je recuppere l'image
       if(isset($_FILES['image'])){
        $image=file_get_contents($_FILES['image']['tmp_name']);
        //url
        $url=$_SERVER["REQUEST_URI"]; 
        $ex=explode("/",$url);
        $id=$ex[4];
        $data=$use->find($id);
      //explose de l'url
        
        ###########################TRAITEMENT DES DONNEES#####################
         ##########################################################################
        $data->setImage(($image));
        return $data;
     
      
    }else{
      return new JsonResponse($_FILES);
    }
       
      
      
    
    
}

}