<?php

namespace Todo\Application\Command\UpdateTodoListItem;

use Shared\Application\Command\CommandHandlerInterface;
use Shared\Application\Query\QueryBusInterface;
use Shared\Application\Query\QueryHandleTrait;
use Todo\Application\Query\GetTodoListById\GetTodoListByIdQuery;
use Todo\Domain\Model\TodoList;
use Todo\Domain\Repository\TodoListRepositoryInterface;

class UpdateTodoListItemHandler implements CommandHandlerInterface
{
    use QueryHandleTrait;

    public function __construct(
        QueryBusInterface $queryBus,
        private TodoListRepositoryInterface $todoListRepository,
    ) {
        $this->queryBus = $queryBus;
    }

    public function __invoke(UpdateTodoListItemCommand $command): void
    {
        /** @var TodoList $todolist */
        $todolist = $this->ask(new GetTodoListByIdQuery($command->getTodoListId()));

        foreach ($todolist->getItems() as $item) {
            if ($item->getId() == $command->getTodoListItemId()) {
                $item->setCompleted($command->isCompleted());
            }
        }

        $this->todoListRepository->persist($todolist);
    }
}
