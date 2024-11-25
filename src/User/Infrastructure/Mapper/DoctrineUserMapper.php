<?php

namespace User\Infrastructure\Mapper;

use Shared\Domain\Mapper\AbstractModelMapper;
use Shared\Domain\Model\AbstractEntity;
use Shared\Domain\Model\Email;
use Shared\Domain\Model\StorageEntityInterface;
use Storage\Doctrine\Entity\User as StorageUser;
use Storage\Doctrine\Repository\UserRepository as StorageUserRepository;
use User\Domain\Model\HashedPassword;
use User\Domain\Model\User;
use User\Domain\Model\UserId;
use User\Domain\Model\Username;

class DoctrineUserMapper extends AbstractModelMapper
{
    public function __construct(
        private StorageUserRepository $storageUserRepository,
    ) {
    }

    /**
     * @param StorageUser $entity
     *
     * @return User
     */
    public function toDomainModel(StorageEntityInterface $entity): AbstractEntity
    {
        return new User(
            id: new UserId($entity->getId()),
            name: $entity->getName(),
            lastname: $entity->getLastname(),
            username: new Username($entity->getUsername()),
            email: new Email($entity->getEmail()),
            isActive: $entity->isActive(),
            password: new HashedPassword($entity->getPassword())
        );
    }

    /**
     * @param User $entity
     *
     * @return StorageUser
     */
    public function toStorageEntity(AbstractEntity $entity): StorageEntityInterface
    {
        $user = $this->storageUserRepository->find($entity->getId()->getValue());

        if (null === $user) {
            $user = new StorageUser(id: $entity->getId()->getValue());
        }

        $user->setName($entity->getName())
            ->setActive($entity->isActive())
            ->setEmail($entity->getEmail())
            ->setLastname($entity->getLastname())
            ->setUsername($entity->getUsername())
            ->setPassword($entity->getPassword())
        ;

        return $user;
    }
}
