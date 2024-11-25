<?php

namespace Auth\Domain\Mapper;

use Auth\Domain\Model\AuthUser;
use Shared\Domain\Model\Email;
use User\Domain\Model\HashedPassword;
use User\Domain\Model\User;
use User\Domain\Model\UserId;
use User\Domain\Model\Username;

class AuthUserMapper
{
    public function toAuthUser(User $user): AuthUser
    {
        return new AuthUser(
            id: new UserId($user->getId()),
            email: new Email($user->getEmail()),
            password: new HashedPassword($user->getPassword()),
            username: new Username($user->getUsername())
        );
    }
}
