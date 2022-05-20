<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\ValidateOrder;
use App\Repository\OrderRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: 't_panier')]
#[ApiResource(itemOperations: [
    'get',
    'put' => [
        'controller' => ValidateOrder::class,
    ],
    'patch' => [
        'controller' => ValidateOrder::class,
    ],
])]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id_panier', type: 'integer')]
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
