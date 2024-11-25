<?php

namespace Todo\Application\Command\DeleteTodoList;

use Shared\Application\Command\CommandHandlerInterface;
use Shared\Domain\Exception\DomainModelException;
use Todo\Domain\Model\TodoList;
use Todo\Domain\Repository\TodoListRepositoryInterface;

class DeleteTodoListHandler implements CommandHandlerInterface
{
    public function __construct(
        private TodoListRepositoryInterface $todoListRepository,
    ) {
    }

    /**
     * @throws DomainModelException
     */
    public function __invoke(DeleteTodoListCommand $command): void
    {
        /** @var TodoList $todoList */
        $todoList = $this->todoListRepository->findOneBy(['id' => $command->getId()]);
        $this->todoListRepository->remove($todoList);
    }
}
