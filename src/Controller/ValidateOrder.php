<?php

namespace App\Controller;

use App\Entity\Order;
use App\Service\OrderValidationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class ValidateOrder extends AbstractController
{
    public function __construct(
        private OrderValidationService $orderValidationService
    ) {}

    public function __invoke(Order $data): Order
    {
        $this->orderValidationService->handle($data);

        return $data;
    }
}
