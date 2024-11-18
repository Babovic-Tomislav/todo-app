<?php

namespace Shared\Domain\Repository;

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
}
