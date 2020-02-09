<?php

namespace App\Controller;

use App\Entity\Depots;
use App\Entity\Comptes;
use App\Algorithm\Algorithm;
use App\Repository\RolesRepository;
use App\Repository\UsersRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


class CompteController 
{
    public function __construct(RolesRepository $repo,TokenStorageInterface $tokenStorage,Algorithm $algo,UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->tokenStorage = $tokenStorage;
        $this->algo=$algo;
        $this->userPasswordEncoder = $userPasswordEncoder;
        $this->repo=$repo;
    }
    public function __invoke(Comptes $data,UsersRepository $use,TokenStorageInterface $tokenStorage):Comptes
    {
      //  dd($data);
       // dd($this->algo->random());
        //usercreator
        $userCreator=$this->tokenStorage->getToken()->getUser();
        //password du user partenaire
        $userPass=$data->getPartenaire()->getUsers()[0]->getPassword();
        //le user partenaire
        $user=$data->getPartenaire()->getUsers()[0];
        //id  partenaire (on a id partenaire si le partenaire existe)
        $iduser=$data->getPartenaire()->getId();
        //montant depot
        $montant=($data->getDepots()[count($data->getDepots())-1]->getMontant());
        //date creation
        $date=date_format($data->getCreatAt(),"Yms");
        $id=$use->getLast()[0]->getId()+1;
        //si  iduser n'existe pas c-a-d c'est un nouveau partenaire
      
      
        if($iduser == null){
        $user->setPassword($this->userPasswordEncoder->encodePassword($user, $userPass));
        $user->setRole($this->repo->findByLibelle("ROLE_PARTENAIRE")[0]);
        
       }
        if($this->algo->validMontant($montant)){
            $data->setSolde($montant);
            $data->setUserCreator($userCreator);
            $data->setNumero($date.$id);
            return $data;
        }else{
            throw new Exception("Le montant doit etre superieur ou égale à 500.000");
        }
            
        
      
    }
}
