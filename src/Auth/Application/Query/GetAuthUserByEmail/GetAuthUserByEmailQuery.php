<?php

namespace Auth\Application\Query\GetAuthUserByEmail;

use Shared\Application\Query\QueryInterface;
use Shared\Domain\Model\Email;

class GetAuthUserByEmailQuery implements QueryInterface
{
    private Email $email;

    public function __construct(string $email)
    {
        $this->email = new Email($email);
    }

    public function getEmail(): Email
    {
        return $this->email;
    }
}
