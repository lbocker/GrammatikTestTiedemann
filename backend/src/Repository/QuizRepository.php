<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Quiz;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Quiz>
 *
 * @method Quiz|null find($id, $lockMode = null, $lockVersion = null)
 * @method Quiz|null findOneBy(array $criteria, array $orderBy = null)
 * @method Quiz[]    findAll()
 * @method Quiz[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuizRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Quiz::class);
    }

    public function getAllQuizzes(): array
    {
        return $this->findAll();
    }

    public function getAllQuizzesByQuizSet(int $quizSetId): array
    {
        return $this->findBy(['quizSetId' => $quizSetId]);
    }

    public function getQuiz(int $quizId): ?Quiz
    {
        return $this->find($quizId);
    }
}
