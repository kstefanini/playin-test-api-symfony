<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\PositiveOrZero;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ORM\Table(name: 't_produit')]
#[ApiResource]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id_produit', type: 'integer')]
    private int $id;

    #[ORM\Column(name: 'nom', type: 'string', length: 150)]
    #[NotBlank]
    private string $name;

    #[ORM\Column(name: 'prix_vente', type: 'float')]
    #[NotNull]
    #[PositiveOrZero]
    private float $sellPrice = 0.;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSellPrice(): ?float
    {
        return $this->sellPrice;
    }

    public function setSellPrice(float $sellPrice): self
    {
        $this->sellPrice = $sellPrice;

        return $this;
    }
}
