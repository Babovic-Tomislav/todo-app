<?php

namespace Todo\Infrastructure\Repository;

use Shared\Domain\Repository\AbstractDomainModelRepository;
use Storage\Doctrine\Repository\TodoListRepository as StorageTodoListRepository;
use Todo\Domain\Repository\TodoListRepositoryInterface;
use Todo\Infrastructure\Mapper\DoctrineTodoListMapper;

readonly class DoctrineTodoListRepository extends AbstractDomainModelRepository implements TodoListRepositoryInterface
{
    public function __construct(DoctrineTodoListMapper $mapper, StorageTodoListRepository $storageRepository)
    {
        parent::__construct($mapper, $storageRepository);
    }
}
