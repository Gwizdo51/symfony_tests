<?php

namespace App\Entity;

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
class Company
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['recipes.index'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    #[BanWord()]
    #[Groups(['recipes.index'])]
    private ?string $name = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\Length(min: 2, max: 20)]
    #[Assert\Regex('/^\D+$/', message: 'This value cannot have numbers.')]
    #[BanWord()]
    #[Groups(['recipes.show'])]
    private ?string $address = null;

    /**
     * @var Collection<int, Client>
     */
    #[ORM\OneToMany(targetEntity: Client::class, mappedBy: 'company')]
    #[Groups(['recipes.show'])]
    private Collection $members;

    public function __construct()
    {
        $this->members = new ArrayCollection();
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

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

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
        }

        return $this;
    }
}
