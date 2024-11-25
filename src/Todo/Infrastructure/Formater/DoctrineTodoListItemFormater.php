<?php

namespace Todo\Infrastructure\Formater;

use Storage\Doctrine\Entity\TodoListItem;

final readonly class DoctrineTodoListItemFormater
{
    /**
     * @return array<string, mixed>
     */
    public function format(TodoListItem $todoListItem): array
    {
        return [
            'id' => $todoListItem->getId(),
            'description' => $todoListItem->getDescription(),
            'completed' => $todoListItem->isCompleted(),
        ];
    }
}
