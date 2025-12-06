<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ClientRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['client:get']],
    denormalizationContext: ['allow_extra_attributes' => false, 'groups' => ['client:set']]
)]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
        'client:get',
    ])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    // #[Groups(['recipes.show'])]
    #[Groups([
        'client:get',
        'client:set',
    ])]
    private ?string $name = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Groups([
        'client:get',
        'client:set',
    ])]
    private ?string $email = null;

    #[ORM\ManyToOne(inversedBy: 'members', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups([
        'client:get',
        'client:set',
    ])]
    private ?Company $company = null;

    public function __toString(): string {
        return $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): static
    {
        $this->company = $company;

        return $this;
    }
}
