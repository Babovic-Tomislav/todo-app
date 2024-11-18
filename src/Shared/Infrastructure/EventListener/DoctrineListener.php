<?php

namespace Shared\Infrastructure\EventListener;

use Carbon\Carbon;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreRemoveEventArgs;
use Doctrine\ORM\Events;

#[AsDoctrineListener(event: Events::prePersist, priority: 0, connection: 'default')]
#[AsDoctrineListener(event: Events::preRemove, priority: 0, connection: 'default')]
class DoctrineListener
{
    public function prePersist(PrePersistEventArgs $event): void
    {
        $entity = $event->getObject();

        if (method_exists($entity, 'setCreatedAt')) {
            $entity->setCreatedAt(Carbon::now());
        }

        if (method_exists($entity, 'setUpdatedAt')) {
            $entity->setUpdatedAt(Carbon::now());
        }
    }

    public function preRemove(PreRemoveEventArgs $event): void
    {
        $entity = $event->getObject();

        if (method_exists($entity, 'setDeletedAt')) {
            $entity->setDeletedAt(Carbon::now());
        }
    }
}
