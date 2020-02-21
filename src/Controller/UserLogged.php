<?php 
namespace App\Controller;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserLogged 

{
    private $tokenStorage;
    public function __contruct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage=$tokenStorage;
    }

    public function __invoke()
    {
        
        return $this->tokenStorage->getToken()->getUser();
       

    }

}