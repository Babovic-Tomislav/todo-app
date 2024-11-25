<?php

namespace Todo\Application\Query\GetTodoList;

use Shared\Application\Query\QueryInterface;
use Shared\Domain\Pagination\PaginationData;
use User\Domain\Model\UserId;

readonly class GetTodoListsQuery implements QueryInterface
{
    public function __construct(
        private UserId $user,
        private PaginationData $paginationData,
    ) {
    }

    public function getUser(): UserId
    {
        return $this->user;
    }

    public function getPaginationData(): PaginationData
    {
        return $this->paginationData;
    }
}
