<?php

namespace Todo\Domain\Model;

use Shared\Domain\Model\AbstractEntity;
use Shared\Domain\Model\AbstractEntityId;
use User\Domain\Model\User;

final class TodoList extends AbstractEntity
{
    /** @var TodoListId */
    protected AbstractEntityId $id;

    /**
     * @param TodoListItem[] $items
     */
    public function __construct(
        AbstractEntityId $id,
        private string $name,
        private string $description,
        private array $items,
        private User $user,
    ) {
        parent::__construct($id);
    }

    public function getId(): TodoListId
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return TodoListItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
