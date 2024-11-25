<?php

namespace Todo\Application\Command\UpdateTodoListItem;

use Shared\Application\Command\CommandInterface;

class UpdateTodoListItemCommand implements CommandInterface
{
    public function __construct(
        private string $todoListId,
        private string $todoListItemId,
        private bool $completed,
    ) {
    }

    public function getTodoListId(): string
    {
        return $this->todoListId;
    }

    public function getTodoListItemId(): string
    {
        return $this->todoListItemId;
    }

    public function isCompleted(): bool
    {
        return $this->completed;
    }
}
