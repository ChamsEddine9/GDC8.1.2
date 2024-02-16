<?php

namespace App\Repository;

use App\Entity\PrimeSalarie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Primesalarie>
 *
 * @method Primesalarie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Primesalarie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Primesalarie[]    findAll()
 * @method Primesalarie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PrimesalarieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Primesalarie::class);
    }

//    /**
//     * @return Primesalarie[] Returns an array of Primesalarie objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Primesalarie
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
