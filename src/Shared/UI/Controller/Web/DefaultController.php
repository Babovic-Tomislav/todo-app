<?php

namespace Shared\UI\Controller\Web;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/', name: 'app_home')]
#[AsController]
class DefaultController extends AbstractWebController
{
    public function __invoke(): Response
    {
        return $this->render('base.html.twig');
    }
}
