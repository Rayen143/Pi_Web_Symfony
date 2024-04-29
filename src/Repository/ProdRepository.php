<?php

namespace App\Repository;

use App\Entity\Prod;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ProdRepository extends ServiceEntityRepository
{
   
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Prod::class);
    }
    public function findBySearchQuery(string $query)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.des LIKE :query')
            ->setParameter('query', '%'.$query.'%')
            ->getQuery()
            ->getResult();
    }
    public function getCategoryCounts(): array
    {
        $qb = $this->createQueryBuilder('p')
            ->select('p.cat, COUNT(p) AS count')
            ->groupBy('p.cat');

        $query = $qb->getQuery();
        $results = $query->getResult();

        $categoryCounts = [];
        foreach ($results as $result) {
            $categoryCounts[$result['cat']] = $result['count'];
        }

        return $categoryCounts;
    }
}
