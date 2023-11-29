<?php

namespace App\Repository;

use App\Entity\QuizSets;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<QuizSets>
 *
 * @method QuizSets|null find($id, $lockMode = null, $lockVersion = null)
 * @method QuizSets|null findOneBy(array $criteria, array $orderBy = null)
 * @method QuizSets[]    findAll()
 * @method QuizSets[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuizSetsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QuizSets::class);
    }

//    /**
//     * @return QuizSets[] Returns an array of QuizSets objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('q')
//            ->andWhere('q.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('q.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?QuizSets
//    {
//        return $this->createQueryBuilder('q')
//            ->andWhere('q.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
