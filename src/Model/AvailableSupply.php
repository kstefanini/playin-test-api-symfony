<?php

namespace App\Model;

use App\Entity\DepositEntry;
use App\Entity\StockEntry;

class AvailableSupply
{
    public function __construct(
        private StockEntry|DepositEntry|null $supply,
        private int $quantity
    ) {}

    public function getSupply(): StockEntry|DepositEntry|null
    {
        return $this->supply;
    }

    public function setSupply(StockEntry|DepositEntry|null $supply): AvailableSupply
    {
        $this->supply = $supply;
        return $this;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): AvailableSupply
    {
        $this->quantity = $quantity;
        return $this;
    }
}
