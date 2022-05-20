<?php

namespace App\Entity;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AssociationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AssociationRepository::class)]
#[ORM\Table(name: 't_assoc')]
#[ApiResource]
class Association
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id_assoc', type: 'integer')]
    private int $id;

    #[ORM\Column(name: 'vendeur', type: 'sellerenum')]
    #[Assert\NotNull]
    private string $seller;

    #[ORM\ManyToOne(targetEntity: OrderEntry::class)]
    #[ORM\JoinColumn(name: 'id_detail', referencedColumnName: 'id_detail')]
    #[Assert\NotNull]
    private OrderEntry $orderEntry;

    #[ORM\ManyToOne(targetEntity: StockEntry::class)]
    #[ORM\JoinColumn(name: 'id_detail_stock', referencedColumnName: 'id_detail', nullable: true)]
    private ?StockEntry $stockEntry = null;

    #[ORM\ManyToOne(targetEntity: DepositEntry::class)]
    #[ORM\JoinColumn(name: 'id_detail_stock', referencedColumnName: 'id_detail', nullable: true)]
    private ?DepositEntry $depositEntry = null;

    #[ORM\Column(name: 'quantite', type: 'integer')]
    #[Assert\Positive]
    private int $quantity = 1;

    #[ORM\Column(name: 'marge', type: 'float')]
    #[Assert\PositiveOrZero]
    private float $margin;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Association
    {
        $this->id = $id;
        return $this;
    }

    public function getSeller(): string
    {
        return $this->seller;
    }

    public function setSeller(string $seller): Association
    {
        $this->seller = $seller;
        return $this;
    }

    public function getOrderEntry(): OrderEntry
    {
        return $this->orderEntry;
    }

    public function setOrderEntry(OrderEntry $orderEntry): Association
    {
        $this->orderEntry = $orderEntry;
        return $this;
    }

    public function getSupplyEntry(): StockEntry|DepositEntry|null
    {
        return $this->stockEntry ?: $this->depositEntry;
    }

    public function setSupplyEntry(StockEntry|DepositEntry|null $supplyEntry): Association
    {
        if ($supplyEntry) {
            switch (get_class($supplyEntry)) {
                case StockEntry::class:
                    $this->stockEntry = $supplyEntry;
                    break;
                case DepositEntry::class:
                    $this->depositEntry = $supplyEntry;
                    break;
                default:
                    break;
            }
        }

        return $this;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): Association
    {
        $this->quantity = $quantity;
        return $this;
    }

    public function getMargin(): float
    {
        return $this->margin;
    }

    public function setMargin(float $margin): Association
    {
        $this->margin = round($margin, 3);
        return $this;
    }
}
