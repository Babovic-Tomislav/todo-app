<?php

namespace Shared\Domain\Repository;

use Shared\Domain\Model\StorageEntityInterface;

interface StorageEntityRepositoryInterface
{
    public function save(StorageEntityInterface $entity): void;

    /**
     * @param array<string, mixed> $criteria
     */
    public function existsWith(array $criteria): bool;
}
