<?php

namespace App\Entity;

use App\Repository\UserAddressRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;

#[ORM\Entity(repositoryClass: UserAddressRepository::class)]
#[UniqueConstraint(name: 'address', columns: ['address'])]
#[ORM\Table(name: 'user_addresses')]
#[ORM\HasLifecycleCallbacks]
class UserAddress
{
    #[ORM\Id]
    #[ORM\Column(length: 255)]
    private string $address;

    #[ORM\Column(length: 20)]
    private ?string $status = null;

    #[ORM\ManyToOne(targetEntity: Tariff::class)]
    #[ORM\JoinColumn(name: 'tariff_name', referencedColumnName: 'name')]
    private Tariff $tariff;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private float $balance = 0;

    #[ORM\Column]
    private \DateTime $createdAt;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $updatedAt = null;

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getTariff(): Tariff
    {
        return $this->tariff;
    }

    public function setTariff(Tariff $tariff): self
    {
        $this->tariff = $tariff;

        return $this;
    }

    public function getBalance(): float
    {
        return $this->balance;
    }

    public function setBalance(float $balance): self
    {
        $this->balance = $balance;

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
