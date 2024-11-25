<?php

namespace Todo\Application\Query\GetTodoListById;

use Shared\Application\Query\QueryInterface;

class GetTodoListByIdQuery implements QueryInterface
{
    public function __construct(
        private string $id,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }
}
