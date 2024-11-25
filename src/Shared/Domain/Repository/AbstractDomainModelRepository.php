<?php

namespace Shared\Domain\Repository;

use Shared\Application\Result\PaginatedSet;
use Shared\Domain\Mapper\AbstractModelMapper;
use Shared\Domain\Model\AbstractEntity;

abstract readonly class AbstractDomainModelRepository implements DomainModelRepositoryInterface
{
    public function __construct(
        protected AbstractModelMapper $mapper,
        protected StorageEntityRepositoryInterface $storageRepository,
    ) {
    }

    public function persist(AbstractEntity $entity): void
    {
        $storageEntity = $this->mapper->toStorageEntity($entity);

        $this->storageRepository->save($storageEntity);
    }

    /**
     * @param array<string, mixed> $criteria
     */
    public function existsWith(array $criteria): bool
    {
        return $this->storageRepository->existsWith($criteria);
    }

    public function findOneBy(array $criteria, ?array $orderBy = null, bool $includeSoftDeletedRecords = false): ?AbstractEntity
    {
        $storageEntity = $this->storageRepository->findOneBy($criteria);

        if (null === $storageEntity) {
            return null;
        }

        return $this->mapper->toDomainModel($storageEntity);
    }

    public function findBy(array $criteria, ?array $orderBy = null, bool $includeSoftDeletedRecords = false, ?int $limit = null, int $offset = 0): PaginatedSet
    {
        $results = $this->storageRepository->findBy(
            criteria: $criteria,
            orderBy: $orderBy,
            includeSoftDeletedRecords: $includeSoftDeletedRecords
        );

        return new PaginatedSet(
            limit: $limit,
            offset: $offset,
            totalResults: $this->storageRepository->count($criteria),
            results: array_map([$this->mapper, 'toDomainModel'], $results)
        );
    }

    public function remove(AbstractEntity $todoList): void
    {
        $storageEntity = $this->mapper->toStorageEntity($todoList);

        $this->storageRepository->remove($storageEntity);
    }
}
