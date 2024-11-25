<?php

namespace Storage\Doctrine\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Shared\Domain\Model\StorageEntityInterface;
use Storage\Doctrine\Entity\Traits\SoftDeletableEntityTrait;
use Storage\Doctrine\Entity\Traits\TimestampableEntityTrait;
use Storage\Doctrine\Entity\Traits\UuidPrimaryKeyEntityTrait;
use Storage\Doctrine\Repository\TodoListItemRepository;

#[ORM\Entity(repositoryClass: TodoListItemRepository::class)]
class TodoListItem implements StorageEntityInterface
{
    use SoftDeletableEntityTrait;
    use TimestampableEntityTrait;
    use UuidPrimaryKeyEntityTrait;

    #[ORM\Column(type: Types::TEXT)]
    private string $description;

    #[ORM\Column]
    private bool $completed;

    #[ORM\ManyToOne(inversedBy: 'todoListItems')]
    #[ORM\JoinColumn(nullable: false)]
    private TodoList $todoList;

    public function __construct(
        ?string $id,
    ) {
        if (null === $id) {
            $id = Uuid::uuid4()->toString();
        }

        $this->id = $id;
        $this->completed = false;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function isCompleted(): bool
    {
        return $this->completed;
    }

    public function setCompleted(bool $completed): static
    {
        $this->completed = $completed;

        return $this;
    }

    public function getTodoList(): TodoList
    {
        return $this->todoList;
    }

    public function setTodoList(TodoList $todoList): static
    {
        $this->todoList = $todoList;

        return $this;
    }
}
