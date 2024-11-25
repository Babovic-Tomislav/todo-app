<?php

namespace User\Application\Query\GetUserByEmail;

use Shared\Application\Query\QueryHandlerInterface;
use Shared\Domain\Exception\NotFoundException;
use User\Domain\Model\User;
use User\Domain\Repository\UserRepositoryInterface;

final readonly class GetUserByEmailHandler implements QueryHandlerInterface
{
    public function __construct(
        private UserRepositoryInterface $repository,
    ) {
    }

    /**
     * @throws NotFoundException
     */
    public function __invoke(GetUserByEmailQuery $query): User
    {
        $user = $this->repository->findOneBy(['email' => $query->getEmail()->getValue()]);

        if (false === $user instanceof User) {
            throw NotFoundException::becauseEntityNotFound(User::class);
        }

        return $user;
    }
}
