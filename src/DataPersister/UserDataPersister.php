<?php
namespace App\DataPersister;

use App\Entity\Users;
use App\Entity\Comptes;
use App\Algorithm\Algorithm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


class UserDataPersister implements DataPersisterInterface
{
    
    
    public function __construct(EntityManagerInterface $entityManager,TokenStorageInterface $tokenStorage )
    {       
        $this->entityManager = $entityManager;
        $this->tokenStorage = $tokenStorage;
       
    }
    public function supports($data): bool
    {
        return $data instanceof Users;
       
        // TODO: Implement supports() method.
    }
    public function persist($data)
    {
        
                $this->entityManager->persist($data);
                $this->entityManager->flush();
               
    }
    public function remove($data)
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }
}