<?php

namespace User\Application\Factory;

use Auth\Domain\Model\AuthUser;
use Shared\Domain\Factory\AbstractDomainModelFactory;
use Shared\Domain\Model\AbstractEntity;
use Shared\Domain\Model\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use User\Domain\Model\HashedPassword;
use User\Domain\Model\User;
use User\Domain\Model\UserId;
use User\Domain\Model\Username;
use User\Domain\Validation\UserValidator;

readonly class UserFactory extends AbstractDomainModelFactory
{
    public function __construct(
        UserValidator $validator,
        private UserPasswordHasherInterface $passwordHasher,
    ) {
        parent::__construct($validator);
    }

    protected function createEntity(array $data): AbstractEntity
    {
        $hashedPassword = new HashedPassword(
            $this->passwordHasher->hashPassword(
                new AuthUser(
                    id: new UserId($data['id']),
                    email: new Email($data['email']),
                    password: new HashedPassword($data['password']),
                    username: new Username($data['username']),
                ),
                $data['password']));

        return new User(
            id: new UserId($data['id']),
            name: $data['name'],
            lastname: $data['lastname'],
            username: new Username($data['username']),
            email: new Email($data['email']),
            isActive: $data['active'],
            password: $hashedPassword,
        );
    }

    protected function getClass(): string
    {
        return User::class;
    }
}
