<?php

namespace App\Repository;

use App\Entity\NewUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NewUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method NewUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method NewUser[]    findAll()
 * @method NewUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NewUser::class);
    }

    // /**
    //  * @return NewUser[] Returns an array of NewUser objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?NewUser
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
