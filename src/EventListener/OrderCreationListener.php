<?php

namespace App\EventListener;

use App\Entity\Order;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Events;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

#[AsEntityListener(
    event: Events::prePersist,
    method: 'setOrderUser',
    entity: Order::class,
)]
final class OrderCreationListener {
    public function __construct(
        private Security $security,
        private LoggerInterface $logger,
    ) {}

    public function setOrderUser(Order $order, PrePersistEventArgs $event): void {
        $this->logger->debug('OrderCreationListener::preCreate called');
        // get the user that made the request
        $currentUser = $this->security->getUser();
        $this->logger->debug("current user : {$currentUser->getUserIdentifier()}");
        // unauthenticated check
        if ($currentUser === null) {
            throw new AccessDeniedHttpException('Authentication required to create a order.');
        }
        $order->setUser($currentUser);
    }
}
