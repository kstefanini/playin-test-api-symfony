<?php

namespace App\Tests\Api;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Association;

class OrderTest extends ApiTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testIdempotentValidateOrder(): void
    {
        $client = static::createClient();

        $associations = $this->entityManager
            ->getRepository(Association::class)
            ->findAll();

        self::assertCount(0, $associations, 'No association');

        $client->request('PUT', '/api/orders/2', [
            'headers' => [
                'accept' => 'application/ld+json',
                'Content-Type' => 'application/ld+json'
            ],
            'json' => [
                'validated' => true
            ]
        ]);

        self::assertResponseIsSuccessful();

        $associations = $this->entityManager
            ->getRepository(Association::class)
            ->findAll();

        self::assertCount(1, $associations, 'One association should have been created');

        $client->request('PUT', '/api/orders/2', [
            'headers' => [
                'accept' => 'application/ld+json',
                'Content-Type' => 'application/ld+json'
            ],
            'json' => [
                'validated' => true
            ]
        ]);

        self::assertResponseIsSuccessful();

        $associations = $this->entityManager
            ->getRepository(Association::class)
            ->findAll();

        self::assertCount(1, $associations, 'Still only one association');
    }
}
