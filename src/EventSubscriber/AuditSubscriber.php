<?php

namespace App\EventSubscriber;

use App\Entity\AuditableInterface;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Bundle\SecurityBundle\Security;

class AuditSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private Security $security,
    ) {
    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::prePersist,
        ];
    }

    public function prePersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        /** @var User $user */
        $user = $this->security->getUser();

        if ($entity instanceof AuditableInterface && null !== $user) {
            $entity->setCreatedAt(new DateTimeImmutable());
            $entity->setCreatedBy($user);
        }
    }
}
