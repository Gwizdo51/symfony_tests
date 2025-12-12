<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use App\Repository\OrderItemRepository;
use App\State\OrderItemStateProvider;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: OrderItemRepository::class)]
#[ApiResource(
    operations: [
        // new GetCollection(),
        new Get(
            uriTemplate: '/order_items/{orderId}/{productId}',
            uriVariables: [
                'orderId' => new Link(
                    fromClass: Order::class,
                    fromProperty: 'id',
                    // toClass: OrderItem::class,
                    toProperty: 'order',
                ),
                'productId' => new Link(
                    fromClass: Product::class,
                    fromProperty: 'id',
                    // toClass: OrderItem::class,
                    toProperty: 'product',
                ),
            ],
            provider: OrderItemStateProvider::class,
            normalizationContext: ['groups' => ['orderItem:read']],
        ),
    ],
)]
class OrderItem
{
    // #[ORM\Id]
    // #[ORM\GeneratedValue]
    // #[ORM\Column]
    // private ?int $id = null;

    #[ORM\Column]
    #[Groups([
        'orderItem:read',
        'order:read',
        'order:create',
    ])]
    private ?int $quantity = null;

    #[ORM\Id]
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups([
        'orderItem:read',
        'order:read',
        'order:create',
    ])]
    private ?Product $product = null;

    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'items')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups([
        'orderItem:read',
    ])]
    private ?Order $order = null;

    // public function getId(): ?int
    // {
    //     return $this->id;
    // }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): static
    {
        $this->product = $product;

        return $this;
    }

    public function getOrder(): ?Order
    {
        return $this->order;
    }

    public function setOrder(?Order $order): static
    {
        $this->order = $order;

        return $this;
    }
}
