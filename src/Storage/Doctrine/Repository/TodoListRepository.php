<?php

namespace Storage\Doctrine\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Storage\Doctrine\Entity\TodoList;

/**
 * @extends BaseRepository<TodoList>
 */
class TodoListRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TodoList::class);
    }
}
