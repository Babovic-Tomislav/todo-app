<?php

namespace Auth\Application\Query\GetAuthUserByEmail;

use Auth\Domain\Mapper\AuthUserMapper;
use Auth\Domain\Model\AuthUser;
use Shared\Application\Query\QueryHandlerInterface;
use Shared\Domain\Exception\NotFoundException;
use User\Domain\Model\User;
use User\Domain\Repository\UserRepositoryInterface;

final readonly class GetAuthUserByEmailHandler implements QueryHandlerInterface
{
    public function __construct(
        private UserRepositoryInterface $repository,
        private AuthUserMapper $mapper,
    ) {
    }

    /**
     * @throws NotFoundException
     */
    public function __invoke(GetAuthUserByEmailQuery $query): AuthUser
    {
        $user = $this->repository->findOneBy(['email' => $query->getEmail()->getValue()]);

        if (false === $user instanceof User) {
            throw NotFoundException::becauseEntityNotFound(User::class);
        }

        return $this->mapper->toAuthUser($user);
    }
}
