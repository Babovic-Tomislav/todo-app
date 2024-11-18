<?php

namespace User\UI\Controller\Web;

use Auth\Infrastructure\Guard\LoginAuthenticator;
use Storage\Doctrine\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TestController extends AbstractController
{
    #[Route('/test', name: 'bla')]
    public function number(UserRepository $repository, LoginAuthenticator $authenticator): Response
    {
        //        dd($mapper);
        //        dd($this->container->get('twig'));
        //        dd(1);
        return new Response(
            '<html><body>Lucky number: </body></html>'
        );
    }
}
