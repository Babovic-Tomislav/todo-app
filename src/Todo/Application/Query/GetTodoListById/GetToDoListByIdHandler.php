<?php

namespace Todo\Application\Query\GetTodoListById;

use Shared\Application\Query\QueryHandlerInterface;
use Todo\Domain\Model\TodoList;
use Todo\Domain\Repository\TodoListRepositoryInterface;

class GetToDoListByIdHandler implements QueryHandlerInterface
{
    public function __construct(
        private TodoListRepositoryInterface $repository,
    ) {
    }

    public function __invoke(GetTodoListByIdQuery $query): TodoList
    {
        /** @var TodoList $todoList */
        $todoList = $this->repository->findOneBy([
            'id' => $query->getId(),
        ]);

        return $todoList;
    }
}
