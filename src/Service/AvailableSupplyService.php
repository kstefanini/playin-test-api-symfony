<?php

namespace App\Service;

use App\Entity\OrderEntry;
use App\Model\AvailableSupply;
use App\Repository\DepositEntryRepository;
use App\Repository\StockEntryRepository;

class AvailableSupplyService
{
    public function __construct(
        private DepositEntryRepository $depositEntryRepository,
        private StockEntryRepository $stockEntryRepository,
    ) {}

    /**
     * @return AvailableSupply[]
     */
    public function get(OrderEntry $entry): array
    {
        $availableSupplies = [];
        $product = $entry->getProduct();
        $goalQuantity = $entry->getQuantity();

        $deposits = $this->depositEntryRepository->findBy([
            'product' => $product
        ], [
            'deposit' => 'asc'
        ]);

        // stocks are queued behind deposits
        $deposits += $this->stockEntryRepository->findBy([
            'product' => $product
        ], [
            'stock' => 'asc'
        ]);

        foreach ($deposits as $deposit) {
            $quantity = min($deposit->getQuantity(), $goalQuantity);
            $availableSupplies[] = new AvailableSupply($deposit, $quantity);
            $goalQuantity -= $quantity;

            if (0 === $goalQuantity) {
                break;
            }
        }

        // rest is going to virtual stock
        if ($goalQuantity) {
            $availableSupplies[] = new AvailableSupply(null, $goalQuantity);
        }

        return $availableSupplies;
    }
}
