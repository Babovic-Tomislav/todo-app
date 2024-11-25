<?php

declare(strict_types=1);

namespace Auth\UI\Controller\Web;

use Shared\UI\Controller\Web\AbstractWebController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

#[Route(path: '{_locale}/login', name: 'app_login')]
#[AsController]
class LoginController extends AbstractWebController
{
    public function __invoke(AuthenticationUtils $authUtils, Request $request): Response
    {
        return $this->render('auth/login.html.twig', [
            'last_username' => $authUtils->getLastUsername(),
            'error' => $authUtils->getLastAuthenticationError(),
        ]);
    }
}
