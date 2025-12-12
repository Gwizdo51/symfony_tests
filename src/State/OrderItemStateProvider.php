<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Entity\OrderItem;
use Doctrine\ORM\EntityManagerInterface;

class OrderItemStateProvider implements ProviderInterface {
    public function __construct(
        private EntityManagerInterface $em,
    ) {}

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null {
        // Only handle the OrderItem entity
        if ($operation->getClass() !== OrderItem::class) {
            return null;
        }

        // Check if both composite keys are present in the URL
        if (!isset($uriVariables['orderId'], $uriVariables['productId'])) {
            return null; // Let other providers or the default logic handle errors
        }

        // Use the EntityManager to find the entity by its composite keys
        // Doctrine's find() method can handle composite keys by accepting an array
        // where the keys are the property names of the composite ID.
        // It automatically handles the underlying ManyToOne relationships.
        return $this->em->getRepository(OrderItem::class)->findOneBy([
            'order' => $uriVariables['orderId'],
            'product' => $uriVariables['productId'],
        ]);
    }
}
