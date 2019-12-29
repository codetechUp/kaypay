<?php

namespace App\Controller;

use App\Entity\Roles;
use App\Entity\Users;
use App\Repository\RolesRepository;
use App\Repository\UsersRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
     * @Route("/api", name="api")
     */
class ApiController extends AbstractController
{
    
    public function __construct(UsersRepository $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }
    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request,RolesRepository $reporoles,UserPasswordEncoderInterface $encode)
{
   
    $manager = $this->getDoctrine()->getManager();
    $user = new Users();
    $role=$reporoles->find($request->get('role'));
    $user->setEmail($request->get('email'))
        ->setPassword($encode->encodePassword($user,$request->get('password')))
       ->setRole($role)
        ->setPrenom($request->get('prenom'))
        ->setNom($request->get('nom'));
        $manager->persist($user);
        $manager->flush();
    return new Response(sprintf('User %s successfully created', $user->getUsername()));
}

    /**
     * @Route("/login", name="login")
     */
    public function login():JsonResponse
    {
        $user=$this->getUser();
        return $this->json(array(
            "username"=>$user->getEmail(),
            "roles"=>$user->getRoles()
        ));
       
    }
}
