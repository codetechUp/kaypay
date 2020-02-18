<?php

namespace App\EventListener;

use App\Repository\AffectationsRepository;
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
    public function __construct(RequestStack $requestStack,AffectationsRepository $aff)
    {
        $this->requestStack = $requestStack;
        $this->aff=$aff;
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
        if($this->aff->findCompteAffectTo($user) != []){
            $aujourd = date('Y-m-d');
        $aujourd=date('Y-m-d', strtotime($aujourd));
        //echo $paymentDate; // echos today!
        //Dernier Affectations
        $affects=$this->aff->findCompteAffectTo($user)[0];
        $debut=$affects->getDateDebut();
        $fin=$affects->getDateFin();
        $debut=date_format($debut,"Y-m-d");
        $fin=date_format($fin,"Y-m-d");
        if (!(($aujourd >= $debut) && ($aujourd <= $fin))){
           throw new Exception("Vous etes pas associé à aucun compte ");
        }
        /*else{
            throw new Exception("Votre Compte utilsateur n'est affecté à aucun compte");
         }*/
        }
      
        
        

        // merge with existing event data
        //ca permet de voir le mot de passe si on inspecte le token sur jwt.io

        $payload = array_merge(
            $event->getData(),
            [
                'id' => $user->getId()
            ]
        );

        $event->setData($payload);
    }
}