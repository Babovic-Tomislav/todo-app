<?php

namespace Storage\Doctrine\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Shared\Domain\Model\StorageEntityInterface;
use Storage\Doctrine\Entity\Traits\SoftDeletableEntityTrait;
use Storage\Doctrine\Entity\Traits\TimestampableEntityTrait;
use Storage\Doctrine\Entity\Traits\UuidPrimaryKeyEntityTrait;
use Storage\Doctrine\Repository\TodoListRepository;

#[ORM\Entity(repositoryClass: TodoListRepository::class)]
class TodoList implements StorageEntityInterface
{
    use SoftDeletableEntityTrait;
    use TimestampableEntityTrait;
    use UuidPrimaryKeyEntityTrait;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column(type: Types::TEXT)]
    private string $description;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private User $user;

    /**
     * @var Collection<int, TodoListItem>
     */
    #[ORM\OneToMany(targetEntity: TodoListItem::class, mappedBy: 'todoList', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $todoListItems;

    public function __construct(
        ?string $id,
    ) {
        if (null === $id) {
            $id = Uuid::uuid4()->toString();
        }

        $this->id = $id;
        $this->todoListItems = new ArrayCollection();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
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

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, TodoListItem>
     */
    public function getTodoListItems(): Collection
    {
        return $this->todoListItems;
    }

    public function addTodoListItem(TodoListItem $todoListItem): static
    {
        if (!$this->todoListItems->contains($todoListItem)) {
            $this->todoListItems->add($todoListItem);
        }

        return $this;
    }
}
