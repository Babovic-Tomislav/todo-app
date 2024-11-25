<?php

namespace Todo\Infrastructure\Mapper;

use Shared\Domain\Mapper\AbstractModelMapper;
use Shared\Domain\Model\AbstractEntity;
use Shared\Domain\Model\StorageEntityInterface;
use Storage\Doctrine\Entity\TodoListItem as StorageTodoListItem;
use Storage\Doctrine\Repository\TodoListItemRepository;
use Todo\Domain\Model\TodoListItem;
use Todo\Domain\Model\TodoListItemId;

class DoctrineTodoListItemMapper extends AbstractModelMapper
{
    public function __construct(
        private TodoListItemRepository $todoListItemRepository,
    ) {
    }

    /**
     * @param StorageTodoListItem $entity
     *
     * @return TodoListItem
     */
    public function toDomainModel(StorageEntityInterface $entity): AbstractEntity
    {
        return new TodoListItem(
            id: new TodoListItemId($entity->getId()),
            description: $entity->getDescription(),
            completed: $entity->isCompleted(),
        );
    }

    /**
     * @param TodoListItem $entity
     *
     * @return StorageTodoListItem
     */
    public function toStorageEntity(AbstractEntity $entity): StorageEntityInterface
    {
        $storageTodoListItem = $this->todoListItemRepository->find($entity->getId()->getValue());

        if (null === $storageTodoListItem) {
            $storageTodoListItem = new StorageTodoListItem(id: $entity->getId()->getValue());
        }

        return $storageTodoListItem
            ->setDescription($entity->getDescription())
            ->setCompleted($entity->isCompleted())
        ;
    }
}
