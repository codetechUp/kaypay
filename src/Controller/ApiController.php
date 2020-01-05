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
use Symfony\Component\HttpKernel\Exception\HttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

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
     * @Route("/register", name="register", methods={"POST"})
     */
    public function register(Request $request,RolesRepository $reporoles,UserPasswordEncoderInterface $encode)
{
    $manager = $this->getDoctrine()->getManager();
    $user = new Users();
    if($request->get('role') !=1)
    {
        $role=$reporoles->find($request->get('role'));
        $user->setEmail($request->get('email'))
        ->setPassword($encode->encodePassword($user,$request->get('password')))
        ->setRole($role)
        ->setPrenom($request->get('prenom'))
        ->setUsername($request->get('username'))
        ->setNom($request->get('nom'));
        $manager->persist($user);
        $manager->flush();
        return $this->json([
            'status' => 201,
            'message' => 'L\'utilisateur a été créé'
        ]);
    }
    if($request->get('role')==1){
        throw new HttpException(401,'Vous ne pouvez pas creer un admin system');
    }
}

    /**
     * @Route("/login", name="login", methods={"POST"})
     */
    public function login(Request $request,TokenStorageInterface $tokenStorage)
    {
        $user=$tokenStorage->getToken()->getUser();
        return $this->json([
            'username' => $user
            
        ]);
    }
}
