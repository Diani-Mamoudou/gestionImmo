<?php

namespace App\Repository;

use App\Entity\BienImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BienImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method BienImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method BienImage[]    findAll()
 * @method BienImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BienImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BienImage::class);
    }

    // /**
    //  * @return BienImage[] Returns an array of BienImage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BienImage
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
