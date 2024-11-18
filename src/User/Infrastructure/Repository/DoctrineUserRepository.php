<?php

namespace User\Infrastructure\Repository;

use Shared\Domain\Repository\AbstractDomainModelRepository;
use Storage\Doctrine\Repository\UserRepository as StorageUserRepository;
use User\Domain\Repository\UserRepositoryInterface;
use User\Infrastructure\Mapper\DoctrineUserMapper;

final readonly class DoctrineUserRepository extends AbstractDomainModelRepository implements UserRepositoryInterface
{
    public function __construct(DoctrineUserMapper $mapper, StorageUserRepository $storageRepository)
    {
        parent::__construct($mapper, $storageRepository);
    }
}
