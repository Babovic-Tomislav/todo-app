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
}
