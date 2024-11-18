<?php

namespace Auth\Domain\Mapper;

use Auth\Domain\Model\AuthUser;
use Shared\Domain\Model\Email;
use User\Domain\Model\HashedPassword;
use User\Domain\Model\User;

class AuthUserMapper
{
    public function toAuthUser(User $user): AuthUser
    {
        return new AuthUser(
            new Email($user->getEmail()),
            new HashedPassword($user->getPassword()),
        );
    }
}
