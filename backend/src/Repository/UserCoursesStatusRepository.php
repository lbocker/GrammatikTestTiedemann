<?php

namespace App\Repository;

use App\Entity\UserCoursesStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserCoursesStatus>
 *
 * @method UserCoursesStatus|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserCoursesStatus|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserCoursesStatus[]    findAll()
 * @method UserCoursesStatus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserCoursesStatusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserCoursesStatus::class);
    }

    //    /**
    //     * @return UserCoursesStatus[] Returns an array of UserCoursesStatus objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('u.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?UserCoursesStatus
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
