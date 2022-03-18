<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\DepositRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DepositRepository::class)]
#[ORM\Table(name: 't_depot')]
#[ApiResource]
class Deposit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id_depot', type: 'integer')]
    private int $id;

    #[ORM\Column(name: 'valide', type: 'boolean')]
    private bool $validated = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isValidated(): bool
    {
        return $this->validated;
    }

    public function setValidated(bool $validated): self
    {
        $this->validated = $validated;
        return $this;
    }
}
