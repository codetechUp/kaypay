<?php

namespace App\Jwt;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationFailureEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Events;
use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationFailureResponse;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Http\Authentication\AuthenticationFailureHandler;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface as ContractsEventDispatcherInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class TranslatedAuthenticationFailureHandler extends AuthenticationFailureHandler
{
    private $translator;

    public function __construct(EventDispatcherInterface $dispatcher, TranslatorInterface $translator)
    {
        parent::__construct($dispatcher);

        $this->translator = $translator;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {

//        $event = new AuthenticationFailureEvent(
//            $exception,
//            new JWTAuthenticationFailureResponse($exception->getMessage())
//        );

        $event = new AuthenticationFailureEvent(
            $exception,
            new JWTAuthenticationFailureResponse(
                $this->translator->trans('Invalid credentials.')
            )
        );
        if ($this->dispatcher instanceof ContractsEventDispatcherInterface) {
            $this->dispatcher->dispatch($event, Events::AUTHENTICATION_FAILURE);
        } else {
            $this->dispatcher->dispatch(Events::AUTHENTICATION_FAILURE, $event);
        }

        return $event->getResponse();
    }
}