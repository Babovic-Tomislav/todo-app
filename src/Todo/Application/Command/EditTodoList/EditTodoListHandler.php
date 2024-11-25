<?php

namespace Todo\Application\Command\EditTodoList;

use Shared\Application\Command\CommandHandlerInterface;
use Shared\Domain\Exception\DomainModelException;
use Todo\Application\Factory\TodoListFactory;
use Todo\Domain\Repository\TodoListRepositoryInterface;

class EditTodoListHandler implements CommandHandlerInterface
{
    public function __construct(
        private TodoListFactory $todoListFactory,
        private TodoListRepositoryInterface $todoListRepository,
    ) {
    }

    /**
     * @throws DomainModelException
     */
    public function __invoke(EditTodoListCommand $command): void
    {
        $todoList = $this->todoListFactory->create($command->toArray());

        $this->todoListRepository->persist($todoList);
    }
}
