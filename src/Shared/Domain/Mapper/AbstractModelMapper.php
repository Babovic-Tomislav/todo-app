<?php

declare(strict_types=1);

namespace Shared\Domain\Mapper;

use Shared\Domain\Model\AbstractEntity;
use Shared\Domain\Model\StorageEntityInterface;

abstract class AbstractModelMapper
{
    abstract public function toDomainModel(StorageEntityInterface $entity): AbstractEntity;

    abstract public function toStorageEntity(AbstractEntity $entity): StorageEntityInterface;
}
