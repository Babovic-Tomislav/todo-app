<?php

namespace Todo\Application\Command\CreateTodoList;

use Shared\Application\Command\CommandHandlerInterface;
use Shared\Domain\Exception\DomainModelException;
use Todo\Application\Factory\TodoListFactory;
use Todo\Domain\Repository\TodoListRepositoryInterface;

class CreateTodoListHandler implements CommandHandlerInterface
{
    public function __construct(
        private TodoListFactory $todoListFactory,
        private TodoListRepositoryInterface $todoListRepository,
    ) {
    }

    /**
     * @throws DomainModelException
     */
    public function __invoke(CreateTodoListCommand $command): void
    {
        $todoList = $this->todoListFactory->create($command->toArray());

        $this->todoListRepository->persist($todoList);
    }
}
