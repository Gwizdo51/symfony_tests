<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\CompanyRepository;
use App\Validator\BanWord;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
#[UniqueEntity('name')] // doesn't prevent race conditions
#[ApiResource(
    operations: [
        new GetCollection(),
        new Get(),
        new Post(),
        new Patch(),
        new Delete(),
    ],
)]
class Company
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
        'client:get',
    ])]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    #[BanWord()]
    #[Groups([
        'client:get',
        'client:set',
    ])]
    private ?string $name = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\Length(min: 2, max: 20)]
    #[Assert\Regex('/^\D+$/', message: 'This value cannot have numbers.')]
    #[BanWord()]
    #[Groups([
        'client:set',
    ])]
    private ?string $address = null;

    /**
     * @var Collection<int, Client>
     */
    #[ORM\OneToMany(targetEntity: Client::class, mappedBy: 'company')]
    // #[Groups(['recipes.show'])]
    private Collection $members;

    #[ORM\Column(options: ['default' => 'CURRENT_TIMESTAMP'])]
    // private ?\DateTimeImmutable $createdAt = null;
    private ?\DateTimeImmutable $createdAt;

    #[ORM\Column(options: ['default' => 'CURRENT_TIMESTAMP'])]
    // private ?\DateTimeImmutable $updatedAt = null;
    private ?\DateTimeImmutable $updatedAt;

    public function __construct()
    {
        $this->members = new ArrayCollection();
        $this->createdAt = $this->updatedAt = new \DateTimeImmutable();
        // $this->updateTimestamp();
    }

    private function updateTimestamp() {
        $this->updatedAt = new \DateTimeImmutable();
    }

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
        $this->updateTimestamp();

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;
        $this->updateTimestamp();

        return $this;
    }

    /**
     * @return Collection<int, Client>
     */
    public function getMembers(): Collection
    {
        return $this->members;
    }

    public function addMember(Client $member): static
    {
        if (!$this->members->contains($member)) {
            $this->members->add($member);
            $member->setCompany($this);
            $this->updateTimestamp();
        }

        return $this;
    }

    public function removeMember(Client $member): static
    {
        if ($this->members->removeElement($member)) {
            // set the owning side to null (unless already changed)
            if ($member->getCompany() === $this) {
                $member->setCompany(null);
            }
            $this->updateTimestamp();
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    // public function setCreatedAt(\DateTimeImmutable $createdAt): static
    // {
    //     $this->createdAt = $createdAt;

    //     return $this;
    // }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    // public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    // {
    //     $this->updatedAt = $updatedAt;

    //     return $this;
    // }
}
