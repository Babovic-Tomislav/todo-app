<?php

namespace Auth\Infrastructure\UserProvider;

use Auth\Application\Query\GetAuthUserByEmail\GetAuthUserByEmailQuery;
use Auth\Domain\Mapper\AuthUserMapper;
use Auth\Domain\Model\AuthUser;
use Shared\Application\Query\QueryBusInterface;
use Shared\Application\Query\QueryHandleTrait;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use User\Domain\Model\User;

/**
 * @implements UserProviderInterface<AuthUser>
 */
final readonly class AuthUserProvider implements UserProviderInterface
{
    use QueryHandleTrait;

    public function __construct(
        private AuthUserMapper $mapper,
        private QueryBusInterface $queryBus,
    ) {
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        /** @var User $user */
        $user = $this->ask(
            new GetAuthUserByEmailQuery($user->getUserIdentifier())
        );

        return $this->mapper->toAuthUser(
            $user
        );
    }

    public function supportsClass(string $class): bool
    {
        return AuthUser::class === $class;
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        /** @var User $user */
        $user = $this->ask(
            new GetAuthUserByEmailQuery($identifier)
        );

        return $this->mapper->toAuthUser(
            $user
        );
    }
}
