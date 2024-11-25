<?php

namespace Auth\Infrastructure\UserProvider;

use Auth\Application\Query\GetAuthUserByEmail\GetAuthUserByEmailQuery;
use Auth\Domain\Model\AuthUser;
use Shared\Application\Query\QueryBusInterface;
use Shared\Application\Query\QueryHandleTrait;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * @implements UserProviderInterface<AuthUser>
 */
final readonly class AuthUserProvider implements UserProviderInterface
{
    use QueryHandleTrait;

    public function __construct(
        private QueryBusInterface $queryBus,
    ) {
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        return $this->ask(
            new GetAuthUserByEmailQuery($user->getUserIdentifier())
        );
    }

    public function supportsClass(string $class): bool
    {
        return AuthUser::class === $class;
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        return $this->ask(
            new GetAuthUserByEmailQuery($identifier)
        );
    }
}
