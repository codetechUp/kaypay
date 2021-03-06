<?php
namespace App\DataPersister;

use DateTime;
use App\Entity\Users;
use App\Entity\Comptes;
use App\Entity\Contrats;
use App\Algorithm\Algorithm;
use App\Entity\Transactions;
use App\Repository\TermesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


class ComptePersister implements DataPersisterInterface
{
    
    
    public function __construct(TermesRepository $terme,EntityManagerInterface $entityManager,TokenStorageInterface $tokenStorage)
    {       
        $this->entityManager = $entityManager;
        $this->tokenStorage = $tokenStorage;
        $this->terme=$terme;
       
    }
    public function supports($data): bool
    {
        return $data instanceof Comptes;
       
        // TODO: Implement supports() method.
    }
    public function persist($data)
    {
        //Je declare v pour v ne soit pas nul
               $v=2;
                if($data->getPartenaire()->getId() == null){
                        $v=1;
                    }
                $this->entityManager->persist($data);
                $this->entityManager->flush();
                //si v=1 c-a-d Nouveau Partenaire
              if($v == 1){
                $contrats= new Contrats();
                $contrats->setPartenaire($data->getPartenaire());
                $contrats->setDate(new DateTime());
                $termes=$this->terme->findAll()[0]->getTermes();
                $contrats->setTermes($termes);
                $this->entityManager->persist($contrats);
                $this->entityManager->flush();
                $data=$data->getPartenaire();
               return $contrats->genContrat($data,$termes);
              }
                
    }
    public function remove($data)
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }
}