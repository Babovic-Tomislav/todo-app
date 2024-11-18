<?php

namespace User\Application\Factory;

use Auth\Domain\Model\AuthUser;
use Shared\Domain\Exception\DomainModelException;
use Shared\Domain\Factory\AbstractDomainModelFactory;
use Shared\Domain\Model\AbstractEntity;
use Shared\Domain\Model\Email;
use Shared\Domain\Validation\Result;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use User\Domain\Model\HashedPassword;
use User\Domain\Model\User;
use User\Domain\Model\UserId;
use User\Domain\Model\Username;
use User\Domain\Repository\UserRepositoryInterface;
use User\Domain\Validation\UserValidator;

readonly class UserFactory extends AbstractDomainModelFactory
{
    public function __construct(
        UserValidator $validator,
        UserRepositoryInterface $repository,
        private UserPasswordHasherInterface $passwordHasher,
    ) {
        parent::__construct($validator, $repository);
    }

    protected function createEntity(array $data): AbstractEntity
    {
        return new User(
            id: new UserId($data['id']),
            name: $data['name'],
            lastname: $data['lastname'],
            username: new Username($data['username']),
            email: new Email($data['email']),
            isActive: $data['active'],
            password: new HashedPassword($this->passwordHasher->hashPassword(new AuthUser(new Email($data['email']), new HashedPassword($data['password'])), $data['password'])),
        );
    }

    protected function throwValidationException(Result $validationResult): void
    {
        throw DomainModelException::becauseInvalidData(\sprintf('Invalid data while creating: %s. %s', User::class, $validationResult->getErrors()[array_key_first($validationResult->getErrors())]));
    }
}
