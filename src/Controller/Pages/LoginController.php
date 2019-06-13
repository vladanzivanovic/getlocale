<?php

namespace App\Controller\Pages;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class LoginController
 */
class LoginController extends AbstractController
{

    /**
     * @Template("pages/login.html.twig")
     * @param AuthenticationUtils $authenticationUtils
     *
     * @return array
     */
    public function loginAction(AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();

        return [
            'error' => $error
        ];
    }
}