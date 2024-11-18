<?php

namespace Auth\Application\Command\SignIn;

use Auth\Application\Query\GetAuthUserByEmail\GetAuthUserByEmailQuery;
use Auth\Domain\Exception\InvalidCredentialsException;
use Auth\Domain\Mapper\AuthUserMapper;
use Shared\Application\Command\CommandHandlerInterface;
use Shared\Application\Query\QueryBusInterface;
use Shared\Application\Query\QueryHandleTrait;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use User\Domain\Model\User;

final readonly class SingInHandler implements CommandHandlerInterface
{
    use QueryHandleTrait;

    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
        private AuthUserMapper $authUserMapper,
        private QueryBusInterface $queryBus,
    ) {
    }

    public function __invoke(SignInCommand $command): void
    {
        $user = $this->ask(
            new GetAuthUserByEmailQuery($command->getEmail())
        );

        if (false === $user instanceof User) {
            throw new InvalidCredentialsException();
        }

        $authUser = $this->authUserMapper->toAuthUser($user);

        if (!$this->passwordHasher->isPasswordValid($authUser, $command->getPassword())) {
            throw new InvalidCredentialsException();
        }
    }
}
