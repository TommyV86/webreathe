<?php

namespace App\Repository;

use App\Entity\History;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<History>
 *
 * @method History|null find($id, $lockMode = null, $lockVersion = null)
 * @method History|null findOneBy(array $criteria, array $orderBy = null)
 * @method History[]    findAll()
 * @method History[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HistoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, History::class);
    }

       /**
        * @return History[] Returns an array of History objects
        */
       public function findLastFive(): array
       {
           return $this->createQueryBuilder('h')
               ->orderBy('h.id', 'DESC')
               ->setMaxResults(5)
               ->getQuery()
               ->getResult()
           ;
       }
 
       /**
        * @return History[] Returns an array of Histories objects from Module id
        */
       public function findHistoriesModuleById(int $value): ?array
       {
           return $this->createQueryBuilder('h')
               ->andWhere('h.module = :val')
               ->orderBy('h.id', 'DESC')
               ->setParameter('val', $value)
               ->getQuery()
               ->getResult()
           ;
       }

    //    public function findOneBySomeField($value): ?History
    //    {
    //        return $this->createQueryBuilder('h')
    //            ->andWhere('h.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
