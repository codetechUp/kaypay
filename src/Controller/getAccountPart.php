<?php  
namespace App\Controller;

use App\Repository\ComptesRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class getAccountPart{
  




    public function __invoke(ComptesRepository $co,TokenStorageInterface $to)
    {
       $partenaire=$to->getToken()->getUser()->getPartenaire();
       $userRole=$to->getToken()->getUser()->getRoles()[0];

       return $userRole=="ROLE_PARTENAIRE"? $co->getAccountParte($partenaire) : $co->findAll() ;
       


    }
}