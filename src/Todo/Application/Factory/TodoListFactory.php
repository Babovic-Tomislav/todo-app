<?php

namespace Todo\Application\Factory;

use Shared\Application\Query\QueryBusInterface;
use Shared\Application\Query\QueryHandleTrait;
use Shared\Domain\Factory\AbstractDomainModelFactory;
use Todo\Domain\Model\TodoList;
use Todo\Domain\Model\TodoListId;
use Todo\Domain\Model\TodoListItem;
use Todo\Domain\Model\TodoListItemId;
use Todo\Domain\Validation\TodoListValidator;
use User\Application\Query\GetUserByEmail\GetUserByEmailQuery;

readonly class TodoListFactory extends AbstractDomainModelFactory
{
    use QueryHandleTrait;

    public function __construct(
        TodoListValidator $validator,
        private QueryBusInterface $queryBus,
    ) {
        parent::__construct($validator);
    }

    protected function createEntity(array $data): TodoList
    {
        return new TodoList(
            id: new TodoListId($data['id']),
            name: $data['name'],
            description: $data['description'],
            items: array_map(
                fn ($item) => new TodoListItem(id: new TodoListItemId($item['id']), description: $item['description'], completed: $item['completed']),
                $data['items']),
            user: $this->queryBus->ask(new GetUserByEmailQuery($data['user'])),
        );
    }

    protected function getClass(): string
    {
        return TodoList::class;
    }
}
