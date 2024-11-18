<?php

namespace Shared\UI\Controller\Web;

use Shared\Application\Command\CommandBusInterface;
use Shared\Application\Command\CommandHandleTrait;
use Shared\Application\Query\QueryBusInterface;
use Shared\Application\Query\QueryHandleTrait;
use Shared\UI\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

abstract class AbstractWebController extends AbstractController
{
    use CommandHandleTrait;
    use QueryHandleTrait;

    public function __construct(
        private readonly \Twig\Environment $template,
        private readonly FormFactoryInterface $formFactory,
        private readonly UrlGeneratorInterface $urlGenerator,
        private readonly CommandBusInterface $commandBus,
        private readonly QueryBusInterface $queryBus,
    ) {
        parent::__construct($this->formFactory);
    }

    /**
     * @param array<mixed> $parameters
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    protected function render(string $view, array $parameters = [], ?Response $response = null): Response
    {
        return $this->doRender($view, $parameters, $response);
    }

    /**
     * @param array<mixed> $parameters
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    private function doRender(string $view, array $parameters, ?Response $response): Response
    {
        $content = $this->doRenderView($view, $parameters);
        $response ??= new Response();

        if (200 === $response->getStatusCode()) {
            foreach ($parameters as $v) {
                if ($v instanceof FormInterface && $v->isSubmitted() && !$v->isValid()) {
                    $response->setStatusCode(422);
                    break;
                }
            }
        }

        $response->setContent($content);

        return $response;
    }

    /**
     * @param array<mixed> $parameters
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    private function doRenderView(string $view, array $parameters): string
    {
        foreach ($parameters as $k => $v) {
            if ($v instanceof FormInterface) {
                $parameters[$k] = $v->createView();
            }
        }

        return $this->template->render($view, $parameters);
    }

    /**
     * Returns a RedirectResponse to the given URL.
     *
     * @param int $status The HTTP status code (302 "Found" by default)
     */
    protected function redirect(string $url, int $status = 302): RedirectResponse
    {
        return new RedirectResponse($url, $status);
    }

    /**
     * @param array<mixed> $parameters
     * @param int $status The HTTP status code (302 "Found" by default)
     */
    protected function redirectToRoute(string $route, array $parameters = [], int $status = 302): RedirectResponse
    {
        return $this->redirect($this->generateUrl($route, $parameters), $status);
    }

    /**
     * @param array<mixed> $parameters
     *
     * @see UrlGeneratorInterface
     */
    protected function generateUrl(string $route, array $parameters = [], int $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH): string
    {
        return $this->urlGenerator->generate($route, $parameters, $referenceType);
    }
}
