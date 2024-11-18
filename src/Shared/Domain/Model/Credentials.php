<?php

namespace Shared\Domain\Model;

use User\Domain\Model\HashedPassword;

final readonly class Credentials
{
    public function __construct(
        private Email $email,
        private HashedPassword $password,
    ) {
    }

    public function email(): Email
    {
        return $this->email;
    }

    public function password(): HashedPassword
    {
        return $this->password;
    }
}
