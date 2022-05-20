<?php

namespace App\Service;

use App\DBAL\SellerEnumType;
use App\Entity\Association;
use App\Entity\DepositEntry;
use App\Entity\OrderEntry;
use App\Entity\StockEntry;

class AssociationService
{
    public function create(
        OrderEntry $orderEntry,
        StockEntry|DepositEntry|null $supplyEntry,
        int $quantity,
    ): Association
    {
        $association = new Association();
        $association->setOrderEntry($orderEntry)
            ->setSupplyEntry($supplyEntry)
            ->setQuantity($quantity)
            ->setSeller(SellerEnumType::VIRTUAL)
            ->setMargin(0)
        ;

        if ($supplyEntry) {
            switch (get_class($supplyEntry)) {
                case StockEntry::class:
                    $association->setSeller(SellerEnumType::STOCK);
                    break;
                case DepositEntry::class:
                    $association->setSeller(SellerEnumType::DEPOSIT);
                    break;
                default:
                    break;
            }
        }

        self::computeMargin($association);

        return $association;
    }

    public static function computeMargin(Association $association): void
    {
        $price = $association->getOrderEntry()->getSellPrice();
        switch ($association->getSeller()) {
            case SellerEnumType::STOCK:
                $association->setMargin(
                    $association->getQuantity() *
                    ($price - $association->getSupplyEntry()->getBuyPrice())
                );
                break;
            case SellerEnumType::DEPOSIT:
                $association->setMargin(
                    $association->getQuantity() *
                    ($price - ($price * $association->getSupplyEntry()->getReimbursementPercentage() / 100))
                );
                break;
            default:
                break;
        }
    }
}
