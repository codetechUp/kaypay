<?php
namespace App\DataPersister;

use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


class UserDataPersister implements DataPersisterInterface
{
    
    
    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $userPasswordEncoder, TokenStorageInterface $tokenStorage)
    {
        $this->userPasswordEncoder = $userPasswordEncoder;
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
        //variable role user connecté
        $userRoles=$this->tokenStorage->getToken()->getUser()->getRoles()[0];
        //variable role user à modifié
        $usersModi=$data->getRoles()[0];
        if($userRoles=="ROLE_ADMIN_SYST"){
            if($usersModi ==  "ROLE_ADMIN_SYST"){
                throw new HttpException("401","Acces non Autorisé");
    
            }else{
                $data->setPassword($this->userPasswordEncoder->encodePassword($data, $data->getPassword()));
                
                $data->eraseCredentials();
                
                $this->entityManager->persist($data);
                $this->entityManager->flush();
            }
        }if($userRoles=="ROLE_ADMIN")
            if($usersModi ==  "ROLE_ADMIN_SYST" || $usersModi ==  "ROLE_ADMIN" ){
                throw new HttpException("401","Acces non Autorisé");

            }else{
                $data->setPassword($this->userPasswordEncoder->encodePassword($data, $data->getPassword()));
                
                $data->eraseCredentials();
                
                $this->entityManager->persist($data);
                $this->entityManager->flush();
            }
    }
    public function remove($data)
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }
}