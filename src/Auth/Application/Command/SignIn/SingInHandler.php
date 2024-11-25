<?php

namespace Auth\Application\Command\SignIn;

use Auth\Application\Query\GetAuthUserByEmail\GetAuthUserByEmailQuery;
use Auth\Domain\Exception\InvalidCredentialsException;
use Auth\Domain\Model\AuthUser;
use Shared\Application\Command\CommandHandlerInterface;
use Shared\Application\Query\QueryBusInterface;
use Shared\Application\Query\QueryHandleTrait;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final readonly class SingInHandler implements CommandHandlerInterface
{
    use QueryHandleTrait;

    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
        private QueryBusInterface $queryBus,
    ) {
    }

    public function __invoke(SignInCommand $command): void
    {
        $authUser = $this->ask(
            new GetAuthUserByEmailQuery($command->getEmail())
        );

        if (false === $authUser instanceof AuthUser) {
            throw new InvalidCredentialsException();
        }

        if (!$this->passwordHasher->isPasswordValid($authUser, $command->getPassword())) {
            throw new InvalidCredentialsException();
        }
    }
}
