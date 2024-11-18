<?php

namespace Storage\Doctrine\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Storage\Doctrine\Entity\User;

/**
 * @extends BaseRepository<User>
 */
class UserRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }
}
