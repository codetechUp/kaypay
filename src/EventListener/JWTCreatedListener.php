<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Config\Definition\Exception\Exception;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;



class JWTCreatedListener
{

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * @param JWTCreatedEvent $event
     *
     * @return void
     */
    public function onJWTCreated(JWTCreatedEvent $event)
    {
        /** @var $user \AppBundle\Entity\User */
        $user = $event->getUser();
        
        if(!$user->getIsActive())
        {
            throw new Exception('Vous etes bloqué');

        }
        if($user->getPartenaire() != null){
            if(!$user->getPartenaire()->getUsers()[0]->getIsActive()){
                throw new Exception('Votre Agence est bloquée!!!');
            }
            
            }
        
        

        // merge with existing event data
//ca permet de voir le mot de passe si on inspecte le token sur jwt.io

        /**$payload = array_merge(
            $event->getData(),
            [
                'password' => $user->getPassword()
            ]
        );

        $event->setData($payload);*/
    }
}