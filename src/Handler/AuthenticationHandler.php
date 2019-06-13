<?php

namespace App\Handler;

use App\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

/**
 * Class AuthenticationHandler
 */
class AuthenticationHandler implements AuthenticationSuccessHandlerInterface, AuthenticationFailureHandlerInterface
{
    private $tokeStorage;
    private $session;

    /**
     * @param TokenStorage $tokenStorage
     * @param Session      $session
     */
    public function __construct(
        TokenStorage $tokenStorage,
        Session $session
    ) {
        $this->tokeStorage = $tokenStorage;
        $this->session = $session;
    }

    /**
     * @SuppressWarnings(PHPMD)
     * @param Request        $request
     * @param TokenInterface $token
     *
     * @return JsonResponse|RedirectResponse|Response
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        /** @var User $user */
        $user = $token->getUser();

        if (true === $user->hasRole('ROLE_USER')) {
            return new RedirectResponse('/dashboard');
        }

        return new RedirectResponse('/');
    }

    /**
     * @param Request                 $request
     * @param AuthenticationException $exception
     *
     * @return JsonResponse|RedirectResponse|Response
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        return new RedirectResponse('/');
    }
}
