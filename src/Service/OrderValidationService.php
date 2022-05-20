<?php

namespace App\Service;

use App\Entity\Order;
use App\Repository\AssociationRepository;
use App\Repository\OrderEntryRepository;
use Doctrine\ORM\EntityManagerInterface;

class OrderValidationService
{
    public function __construct(
        private OrderEntryRepository $orderEntryRepository,
        private AssociationRepository $associationRepository,
        private AvailableSupplyService $availableSupplyService,
        private AssociationService $associationService,
        private EntityManagerInterface $em,
    ) {}

    public function handle(Order $order): void
    {
        $orderEntries = $this->orderEntryRepository->findBy([
            'order' => $order,
        ]);

        foreach ($orderEntries as $orderEntry) {
            $association = $this->associationRepository->findOneBy([
                'orderEntry' => $orderEntry
            ]);
            if ($association) {
                // entry already handled
                continue;
            }

            $availableSupplies = $this->availableSupplyService->get($orderEntry);

            foreach ($availableSupplies as $availableSupply) {
                $supply = $availableSupply->getSupply();
                $quantity = $availableSupply->getQuantity();

                if ($supply) {
                    $supply->setQuantity($supply->getQuantity() - $quantity);
                    $supply->setSoldQuantity($supply->getSoldQuantity() + $quantity);
                }

                $association = $this->associationService->create(
                    $orderEntry,
                    $supply,
                    $quantity
                );

                $this->em->persist($association);
            }
        }
    }
}
