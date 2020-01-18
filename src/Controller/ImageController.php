<?php
// api/src/Controller/CreateMediaObjectAction.php
namespace App\Controller;

use App\Entity\Images;
use App\Algorithm\Algorithm;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;


final class ImageController extends AbstractController
{

    
    public function __invoke(Request $request,Algorithm $algo): Images
    {
        $file = $request->files->get('file');
        if (!$file) {
            throw new BadRequestHttpException('"file" is required');
        }else{
            $Image = new Images();
            $Image->file = $file;
           if ($algo->isImage($file)){
               
            $newFilename=md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter("images_directory"),$newFilename);
            $Image->setImage($newFilename);
    
            return $Image;
            }else{
                throw new BadRequestHttpException("Les images doivent être au format JPG, GIF ou PNG");
            }

       
       }
            
    }
}