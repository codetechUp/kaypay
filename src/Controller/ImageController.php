<?php
// api/src/Controller/CreateMediaObjectAction.php
namespace App\Controller;

use App\Entity\Users;
use App\Repository\UsersRepository;;


final class ImageController 
{

    
    public function __invoke(UsersRepository $use)
{
      $image=file_get_contents($_FILES['image']['tmp_name']);
      $url=$_SERVER["REQUEST_URI"];
    //explose de l'url
      $ex=explode("/",$url);
      $id=$ex[4];
      $data=$use->find($id);
      $data->setImage(($image));
      
      return $data;
    
    
}

}