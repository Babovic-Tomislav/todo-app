<?php

namespace Todo\Application\Factory;

use Shared\Domain\Factory\AbstractDomainModelFactory;
use Todo\Domain\Model\TodoListItem;
use Todo\Domain\Model\TodoListItemId;
use Todo\Domain\Validation\TodoListItemValidator;

readonly class TodoListItemFactory extends AbstractDomainModelFactory
{
    public function __construct(TodoListItemValidator $validator)
    {
        parent::__construct($validator);
    }

    protected function createEntity(array $data): TodoListItem
    {
        return new TodoListItem(
            id: new TodoListItemId($data['id']),
            description: $data['description'],
            completed: $data['completed'],
        );
    }

    protected function getClass(): string
    {
        return TodoListItem::class;
    }
}
