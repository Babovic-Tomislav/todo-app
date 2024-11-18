<?php

namespace Shared\Domain\Repository;

use Shared\Domain\Model\AbstractEntity;

interface DomainModelRepositoryInterface
{
    public function persist(AbstractEntity $entity): void;

    /**
     * @param array<string, mixed> $criteria
     */
    public function existsWith(array $criteria): bool;

    /**
     * @param array<string, mixed> $criteria
     * @param array<string, mixed>|null $orderBy
     */
    public function findOneBy(array $criteria, ?array $orderBy = null, bool $includeSoftDeletedRecords = false): ?AbstractEntity;
}
