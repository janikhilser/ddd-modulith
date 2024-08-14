<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Event;

use App\Common\Application\Event\IDomainEventBus;
use App\Common\Domain\Aggregate\Aggregate;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Doctrine\ORM\Events;

#[AsDoctrineListener(event: Events::postFlush)]
#[AsDoctrineListener(event: Events::onFlush)]
class DoctrineEventSubscriber
{
    /**
     * @var Aggregate[]
     */
    private array $entities = [];

    public function __construct(private readonly IDomainEventBus $eventBus)
    {
    }

    public function onFlush(OnFlushEventArgs $eventArgs): void
    {
        $em = $eventArgs->getObjectManager();
        $uow = $em->getUnitOfWork();

        foreach ($uow->getIdentityMap() as $entityTypes) {
            foreach ($entityTypes as $entity) {
                $this->keepAggregateRoots($entity);
            }
        }
    }

    public function postFlush(PostFlushEventArgs $args): void
    {
        foreach ($this->entities as $entity) {
            foreach ($entity->popEvents() as $event) {
                $this->eventBus->publish($event);
            }
        }
    }

    private function keepAggregateRoots(object $entity): void
    {
        if (!($entity instanceof Aggregate)) {
            return;
        }

        $this->entities[] = $entity;
    }
}
