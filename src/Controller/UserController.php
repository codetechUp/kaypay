<?php

namespace App\Controller;

use App\Entity\Users;
use App\Algorithm\Algorithm;
use App\Repository\RolesRepository;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


class UserController 
{
   
    public function __construct(RolesRepository $repo,TokenStorageInterface $tokenStorage,Algorithm $algo,UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->tokenStorage = $tokenStorage;
        $this->algo=$algo;
        $this->repo=$repo;
        $this->userPasswordEncoder = $userPasswordEncoder;
    }
    public function __invoke(Users $data):Users
    {
        
        $userConect=$this->tokenStorage->getToken()->getUser();
        $userPartenaire=$userConect->getPartenaire();
        ///variable role user connecté
        $userRoles=$userConect->getRoles()[0];
        if($userRoles == "ROLE_PARTENAIRE")
        {
            $data->setPartenaire($userPartenaire);
            $data->setRole($this->repo->findByLibelle("ROLE_PUSER")[0]);
        }
        //variable role user à modifier
        $usersModi=$data->getRoles()[0];
        if($this->algo->isAuthorised($userRoles,$usersModi) == true){
            $data->setPassword($this->userPasswordEncoder->encodePassword($data, $data->getPassword()));
            return $data;
        }else{
            throw new HttpException("401","Access non Authorisé");
        }
    }
}
