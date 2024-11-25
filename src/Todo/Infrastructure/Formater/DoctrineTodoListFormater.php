<?php

namespace Todo\Infrastructure\Formater;

use Storage\Doctrine\Entity\TodoList;

final readonly class DoctrineTodoListFormater
{
    /**
     * @return array<string, mixed>
     */
    public function format(TodoList $todoList): array
    {
        return [
            'id' => $todoList->getId(),
            'name' => $todoList->getName(),
            'description' => $todoList->getDescription(),
            'items' => array_map(fn ($item) => [
                'id' => $item->getId(),
                'description' => $item->getDescription(),
                'completed' => $item->isCompleted(),
            ], $todoList->getTodoListItems()->toArray()),
        ];
    }
}
