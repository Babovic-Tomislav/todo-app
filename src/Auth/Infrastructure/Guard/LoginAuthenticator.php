<?php

declare(strict_types=1);

namespace Auth\Infrastructure\Guard;

use Auth\Application\Command\SignIn\SignInCommand;
use Auth\Domain\Exception\InvalidCredentialsException;
use JetBrains\PhpStorm\ArrayShape;
use Shared\Application\Command\CommandBusInterface;
use Shared\Application\Command\CommandHandleTrait;
use Shared\Application\Query\QueryBusInterface;
use Shared\Application\Query\QueryHandleTrait;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;

final class LoginAuthenticator extends AbstractLoginFormAuthenticator
{
    use CommandHandleTrait;
    use QueryHandleTrait;

    private const LOGIN = 'web.app_login';

    private const SUCCESS_REDIRECT = 'profile';

    public function __construct(
        private readonly CommandBusInterface $commandBus,
        private readonly QueryBusInterface $queryBus,
        private readonly UrlGeneratorInterface $router,
    ) {
    }

    /**
     * @return array<string, string>
     *
     * @throws AuthenticationException
     */
    #[ArrayShape(['email' => 'string', 'password' => 'string'])]
    private function getCredentials(Request $request): array
    {
        return [
            'email' => (string) $request->request->get('_email'),
            'password' => (string) $request->request->get('_password'),
        ];
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): Response
    {
        return new RedirectResponse($this->router->generate(self::SUCCESS_REDIRECT));
    }

    protected function getLoginUrl(Request $request): string
    {
        return $this->router->generate(self::LOGIN);
    }

    /**
     * @throws AuthenticationException
     */
    public function authenticate(Request $request): Passport
    {
        $credentials = $this->getCredentials($request);

        try {
            $email = $credentials['email'];
            $plainPassword = $credentials['password'];

            $signInCommand = new SignInCommand($email, $plainPassword);

            $this->commandBus->handle($signInCommand);

            return new Passport(
                new UserBadge($email),
                new PasswordCredentials($plainPassword)
            );
        } catch (InvalidCredentialsException|\InvalidArgumentException $e) {
            throw new AuthenticationException($e->getMessage());
        }
    }
}
