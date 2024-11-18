<?php

namespace Tests\Integration\User\infrastructure\Mapper;

use Auth\Domain\Mapper\AuthUserMapper;
use Ramsey\Uuid\Uuid;
use Storage\Doctrine\Entity\User as StorageUser;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use User\Application\Factory\UserFactory;
use User\Domain\Model\User;
use User\Infrastructure\Mapper\DoctrineUserMapper;

class DoctrineUserMapperTest extends KernelTestCase
{
    public function testToDomainModelConvertsStorageUserToDomainUser(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        /** @var DoctrineUserMapper $mapper */
        $mapper = $container->get(DoctrineUserMapper::class);
        $uuid = Uuid::uuid4()->toString();

        $storageUser = $this->createMock(StorageUser::class);
        $storageUser->method('getId')->willReturn($uuid);
        $storageUser->method('getName')->willReturn('John');
        $storageUser->method('getLastname')->willReturn('Doe');
        $storageUser->method('getUsername')->willReturn('johndoe');
        $storageUser->method('getEmail')->willReturn('john.doe@example.com');
        $storageUser->method('isActive')->willReturn(true);
        $storageUser->method('getPassword')->willReturn('password123');

        $domainUser = $mapper->toDomainModel($storageUser);

        $this->assertInstanceOf(User::class, $domainUser);
        $this->assertEquals($uuid, $domainUser->getId()->getValue());
        $this->assertEquals('John', $domainUser->getName());
        $this->assertEquals('Doe', $domainUser->getLastname());
        $this->assertEquals('johndoe', $domainUser->getUsername());
        $this->assertEquals('john.doe@example.com', $domainUser->getEmail());
        $this->assertTrue($domainUser->isActive());
        $this->assertEquals('password123', $domainUser->getPassword());
    }

    public function testToStorageEntityConvertsDomainUserToStorageUser(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        /** @var DoctrineUserMapper $mapper */
        $mapper = $container->get(DoctrineUserMapper::class);
        /** @var UserFactory $factory */
        $factory = $container->get(UserFactory::class);
        $uuid = Uuid::uuid4()->toString();
        /** @var User $domainUser */
        $domainUser = $factory->create([
            'id' => $uuid,
            'name' => 'John',
            'lastname' => 'Doe',
            'username' => 'johndoe',
            'email' => 'john.doe@example.com',
            'active' => true,
            'password' => 'password123',
        ]);

        $storageUser = $mapper->toStorageEntity($domainUser);

        /** @var AuthUserMapper $authMapper */
        $authMapper = $container->get(AuthUserMapper::class);
        /** @var UserPasswordHasherInterface $passwordHasher */
        $passwordHasher = $container->get(UserPasswordHasherInterface::class);

        $this->assertInstanceOf(StorageUser::class, $storageUser);
        $this->assertEquals($uuid, $storageUser->getId());
        $this->assertEquals('John', $storageUser->getName());
        $this->assertEquals('Doe', $storageUser->getLastname());
        $this->assertEquals('johndoe', $storageUser->getUsername());
        $this->assertEquals('john.doe@example.com', $storageUser->getEmail());
        $this->assertTrue($storageUser->isActive());
        $this->assertTrue($passwordHasher->isPasswordValid($authMapper->toAuthUser($domainUser), 'password123'));
    }
}
