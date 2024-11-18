<?php

namespace User\Application\Command\UserCreated;

use Shared\Application\Command\CommandHandlerInterface;
use Shared\Domain\Exception\DomainModelException;
use User\Application\Factory\UserFactory;
use User\Domain\Repository\UserRepositoryInterface;

readonly class UserCreatedHandler implements CommandHandlerInterface
{
    public function __construct(
        private UserFactory $userFactory,
        private UserRepositoryInterface $userRepository,
    ) {
    }

    /**
     * @throws DomainModelException
     */
    public function __invoke(UserCreatedCommand $command): void
    {
        $user = $this->userFactory->create($command->toArray());

        $this->userRepository->persist($user);
    }
}
