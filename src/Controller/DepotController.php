<?php

namespace App\Controller;

use App\Entity\Users;
use App\Entity\Depots;
use App\Algorithm\Algorithm;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


class DepotController
{
   
    public function __construct(TokenStorageInterface $tokenStorage,Algorithm $algo,UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->tokenStorage = $tokenStorage;
        $this->algo=$algo;
        $this->userPasswordEncoder = $userPasswordEncoder;
    }
    public function __invoke(Depots $data):Depots
    {
        $montant=$data->getMontant();
        $compte=$data->getCompte();
        $solde=$compte->getSolde();
        if($montant != 0){
            $compte->setSolde($solde + $montant);
            return $data;
        }else{
            throw new Exception("Le montant doit etre superieur à 0");
        }
    }
}