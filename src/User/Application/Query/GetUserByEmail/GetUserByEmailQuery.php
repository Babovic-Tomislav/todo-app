<?php

namespace User\Application\Query\GetUserByEmail;

use Shared\Application\Query\QueryInterface;
use Shared\Domain\Model\Email;

class GetUserByEmailQuery implements QueryInterface
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
