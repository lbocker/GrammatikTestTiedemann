<?php

declare(strict_types=1);

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

    public function getAllQuizSets(): array
    {
        return $this->createQueryBuilder('quiz_sets')
            ->select('quiz_sets.id', 'quiz_sets.title', 'quiz_sets.description', 'quiz_sets.image')
            ->getQuery()
            ->getArrayResult();
    }

    public function getAllQuizSetsByCourse(int $courseId): array
    {
        return $this->findBy(['course' => $courseId]);
    }

    public function getQuizSet(int $quizSetId): ?QuizSets
    {
        return $this->find($quizSetId);
    }
}
