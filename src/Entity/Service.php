<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ServiceRepository;
use Doctrine\Common\Collections\{ArrayCollection, Collection};
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServiceRepository::class)]
#[ORM\Table(name: 'services', uniqueConstraints: [
    new ORM\UniqueConstraint(name: 'unique_type_name', columns: ['type', 'name']),
])]
#[ORM\HasLifecycleCallbacks]
class Service
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\ManyToMany(targetEntity: Tariff::class, inversedBy: 'services')]
    #[ORM\JoinTable(
        name: 'tariff_services',
        joinColumns: [new ORM\JoinColumn(name: 'service_id', referencedColumnName: 'id')],
        inverseJoinColumns: [new ORM\JoinColumn(name: 'tariff_name', referencedColumnName: 'name')],
    )]
    private Collection $tariffs;

    #[ORM\Column(type: Types::SMALLINT)]
    private int $type;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private \DateTime $createdAt;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $updatedAt = null;

    public function __construct()
    {
        $this->tariffs = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTariffs(): Collection
    {
        return $this->tariffs;
    }

    public function addTariff(Tariff $tariff): self
    {
        if (!$this->tariffs->contains($tariff)) {
            $this->tariffs->add($tariff);
        }

        return $this;
    }

    public function removeTariff(Tariff $tariff): self
    {
        $this->tariffs->removeElement($tariff);

        return $this;
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    #[ORM\PrePersist]
    public function onPrePersist(): void
    {
        $this->createdAt = new \DateTime('now');
    }

    #[ORM\PreUpdate]
    public function onPreUpdate(): void
    {
        $this->updatedAt = new \DateTime('now');
    }
}
