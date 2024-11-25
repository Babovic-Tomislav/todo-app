<?php

namespace Todo\Infrastructure\Mapper;

use Shared\Domain\Mapper\AbstractModelMapper;
use Shared\Domain\Model\AbstractEntity;
use Shared\Domain\Model\StorageEntityInterface;
use Storage\Doctrine\Entity\TodoList as StorageTodoList;
use Storage\Doctrine\Repository\TodoListRepository as StorageTodoListRepository;
use Todo\Domain\Model\TodoList;
use Todo\Domain\Model\TodoListId;
use User\Infrastructure\Mapper\DoctrineUserMapper;

class DoctrineTodoListMapper extends AbstractModelMapper
{
    public function __construct(
        private DoctrineUserMapper $userMapper,
        private DoctrineTodoListItemMapper $todoListItemMapper,
        private StorageTodoListRepository $storageTodoListRepository,
    ) {
    }

    /**
     * @param StorageTodoList $entity
     *
     * @return TodoList
     */
    public function toDomainModel(StorageEntityInterface $entity): AbstractEntity
    {
        return new TodoList(
            id: new TodoListId($entity->getId()),
            name: $entity->getName(),
            description: $entity->getDescription(),
            items: array_map([$this->todoListItemMapper, 'toDomainModel'], $entity->getTodoListItems()->toArray()),
            user: $this->userMapper->toDomainModel($entity->getUser()),
        );
    }

    /**
     * @param TodoList $entity
     *
     * @return StorageTodoList
     */
    public function toStorageEntity(AbstractEntity $entity): StorageEntityInterface
    {
        $storageTodoList = $this->storageTodoListRepository->find($entity->getId()->getValue());

        if (null === $storageTodoList) {
            $storageTodoList = new StorageTodoList(id: $entity->getId()->getValue());
        }

        $storageTodoList
            ->setName($entity->getName())
            ->setDescription($entity->getDescription())
            ->setUser($this->userMapper->toStorageEntity($entity->getUser()))
        ;

        $storageTodoList->getTodoListItems()->clear();
        foreach ($entity->getItems() as $item) {
            $storageTodoListItem = $this->todoListItemMapper->toStorageEntity($item);
            $storageTodoListItem->setTodoList($storageTodoList);
            $storageTodoList->addTodoListItem($storageTodoListItem);
        }

        return $storageTodoList;
    }
}
