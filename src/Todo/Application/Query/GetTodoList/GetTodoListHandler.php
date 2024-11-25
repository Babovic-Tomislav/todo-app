<?php

namespace Todo\Application\Query\GetTodoList;

use Shared\Application\Query\QueryHandlerInterface;
use Shared\Application\Result\PaginatedSet;
use Todo\Domain\Repository\TodoListRepositoryInterface;

readonly class GetTodoListHandler implements QueryHandlerInterface
{
    public function __construct(
        private TodoListRepositoryInterface $repository,
    ) {
    }

    public function __invoke(GetTodoListsQuery $query): PaginatedSet
    {
        return $this->repository->findBy(
            criteria: [
                'user' => $query->getUser()->getValue(),
            ],
            limit: $query->getPaginationData()->getLimit(),
            offset: $query->getPaginationData()->getOffset(),
        );
    }
}
