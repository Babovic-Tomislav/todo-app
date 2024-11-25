<?php

declare(strict_types=1);

namespace Todo\Application\Command\DeleteTodoList;

use Shared\Application\Command\CommandInterface;

final readonly class DeleteTodoListCommand implements CommandInterface
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
