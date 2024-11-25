<?php

namespace Todo\Domain\Model;

use Shared\Domain\Model\AbstractEntity;
use Shared\Domain\Model\AbstractEntityId;

final class TodoListItem extends AbstractEntity
{
    /** @var TodoListItemId */
    protected AbstractEntityId $id;

    public function __construct(
        TodoListItemId $id,
        private string $description,
        private bool $completed,
    ) {
        parent::__construct($id);
    }

    public function getId(): TodoListItemId
    {
        return $this->id;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function isCompleted(): bool
    {
        return $this->completed;
    }

    public function setCompleted(bool $isCompleted): void
    {
        $this->completed = $isCompleted;
    }
}
