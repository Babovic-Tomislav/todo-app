<?php

namespace User\Domain\Specification;

use Shared\Domain\Specification\SpecificationInterface;
use User\Domain\Repository\UserRepositoryInterface;

final readonly class UserWithEmailExistsSpecification implements SpecificationInterface
{
    public function __construct(private UserRepositoryInterface $userRepository)
    {
    }

    /**
     * @param string $value
     */
    public function isSatisfiedBy($value): bool
    {
        return $this->userRepository->existsWith(['email' => $value]);
    }
}
