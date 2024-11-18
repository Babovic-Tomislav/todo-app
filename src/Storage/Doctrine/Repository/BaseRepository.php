<?php

namespace Storage\Doctrine\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Shared\Domain\Model\StorageEntityInterface;
use Shared\Domain\Repository\StorageEntityRepositoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @extends ServiceEntityRepository<StorageEntityInterface>
 *
 * @template T of object
 *
 * @template-extends ServiceEntityRepository<T>
 */
abstract class BaseRepository extends ServiceEntityRepository implements StorageEntityRepositoryInterface
{
    /**
     * @return StorageEntityInterface[]
     */
    public function findAll(bool $includeSoftDeletedRecords = false): array
    {
        $isSoftDeletedFilterEnabled = $this->isSoftDeletedFilterEnabled();
        if ($includeSoftDeletedRecords) {
            $this->disableSoftDeletedFilter();
        }

        /** @var StorageEntityInterface[] $results */
        $results = parent::findAll();

        $isSoftDeletedFilterEnabled ? $this->enableSoftDeletedFilter() : $this->disableSoftDeletedFilter();

        return $results;
    }

    /**
     * @param int|string $id
     */
    public function findById($id, bool $includeSoftDeletedRecords = false): ?StorageEntityInterface
    {
        $isSoftDeletedFilterEnabled = $this->isSoftDeletedFilterEnabled();

        if ($includeSoftDeletedRecords) {
            $this->disableSoftDeletedFilter();
        }

        /** @var StorageEntityInterface|null $entity */
        $entity = $this->find($id);

        $isSoftDeletedFilterEnabled ? $this->enableSoftDeletedFilter() : $this->disableSoftDeletedFilter();

        return $entity;
    }

    /**
     * @param array<string, mixed>      $criteria
     * @param array<string, mixed>|null $orderBy
     *
     * @return StorageEntityInterface[]
     */
    public function findBy(array $criteria, ?array $orderBy = null, ?int $limit = null, ?int $offset = null, bool $includeSoftDeletedRecords = false): array
    {
        $isSoftDeletedFilterEnabled = $this->isSoftDeletedFilterEnabled();

        if ($includeSoftDeletedRecords) {
            $this->disableSoftDeletedFilter();
        }

        /** @var StorageEntityInterface[] $entity */
        $entity = parent::findBy($criteria, $orderBy, $limit, $offset);

        $isSoftDeletedFilterEnabled ? $this->enableSoftDeletedFilter() : $this->disableSoftDeletedFilter();

        return $entity;
    }

    /**
     * @param array<string, mixed>      $criteria
     * @param array<string, mixed>|null $orderBy
     */
    public function findOneBy(array $criteria, ?array $orderBy = null, bool $includeSoftDeletedRecords = false): ?StorageEntityInterface
    {
        $isSoftDeletedFilterEnabled = $this->isSoftDeletedFilterEnabled();

        if ($includeSoftDeletedRecords) {
            $this->disableSoftDeletedFilter();
        }

        /** @var StorageEntityInterface|null $entity */
        $entity = parent::findOneBy($criteria, $orderBy);

        $isSoftDeletedFilterEnabled ? $this->enableSoftDeletedFilter() : $this->disableSoftDeletedFilter();

        return $entity;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(StorageEntityInterface $entity, bool $flush = true): void
    {
        $this->getEntityManager()->persist($entity);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function flush(): void
    {
        $this->getEntityManager()->flush();
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(StorageEntityInterface $entity, bool $flush = true): void
    {
        $this->getEntityManager()->remove($entity);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findOr404(int $id, bool $includeSoftDeletedRecords = false): StorageEntityInterface
    {
        $isSoftDeletedFilterEnabled = $this->isSoftDeletedFilterEnabled();

        if ($includeSoftDeletedRecords) {
            $this->disableSoftDeletedFilter();
        }

        /** @var StorageEntityInterface|null $entity */
        $entity = $this->findById($id);

        $isSoftDeletedFilterEnabled ? $this->disableSoftDeletedFilter() : $this->enableSoftDeletedFilter();

        if (null === $entity) {
            $message = sprintf('Resource of type %s and ID %s could not be found!', $this->getEntityName(), $id);
            throw new NotFoundHttpException($message, null, Response::HTTP_NOT_FOUND);
        }

        return $entity;
    }

    private function isSoftDeletedFilterEnabled(): bool
    {
        if ($this->isSoftDeletedFilterEnabled()) {
            return true;
        }

        return false;
    }

    public function enableSoftDeletedFilter(): void
    {
        if (!$this->isSoftDeletedFilterEnabled()) {
            $this->getEntityManager()->getFilters()->enable('soft_deletable');
        }
    }

    public function disableSoftDeletedFilter(): void
    {
        if ($this->isSoftDeletedFilterEnabled()) {
            $this->getEntityManager()->getFilters()->disable('soft_deletable');
        }
    }

    /**
     * @param array<string, mixed> $criteria
     */
    public function existsWith(array $criteria): bool
    {
        $qb = $this->createQueryBuilder('e')
            ->select('COUNT(e.id)');

        foreach ($criteria as $key => $value) {
            $qb->andWhere("e.$key = :$key")
                ->setParameter($key, $value);
        }

        return (int) $qb->getQuery()->getSingleScalarResult() > 0;
    }
}
