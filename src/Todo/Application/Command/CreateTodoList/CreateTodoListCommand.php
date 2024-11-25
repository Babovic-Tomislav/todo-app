<?php

declare(strict_types=1);

namespace Todo\Application\Command\CreateTodoList;

use Shared\Application\Command\CommandInterface;

final readonly class CreateTodoListCommand implements CommandInterface
{
    /**
     * @param array<int, array<string, mixed>> $items
     */
    public function __construct(
        private ?string $id,
        private string $name,
        private string $user,
        private array $items,
        private string $description,
    ) {
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUser(): string
    {
        return $this->user;
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'user' => $this->user,
            'items' => $this->items,
            'description' => $this->description,
        ];
    }
}
