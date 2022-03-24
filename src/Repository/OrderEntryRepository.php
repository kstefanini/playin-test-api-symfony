<?php

namespace App\Repository;

use App\Entity\OrderEntry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OrderEntry|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderEntry|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderEntry[]    findAll()
 * @method OrderEntry[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderEntryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderEntry::class);
    }

    public function add(OrderEntry $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function remove(OrderEntry $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
}
