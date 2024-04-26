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
        return $this->createQueryBuilder('quizzes')
            ->select('quizzes.id', 'quizzes.title', 'quizzes.description', 'quizzes.image')
            ->getQuery()
            ->getArrayResult();
    }

    public function getAllQuizzesByQuizSet(int $quizSetId): array
    {
        return $this->createQueryBuilder('quiz')
            ->select('quiz.id', 'quiz.question', 'quiz.rightAnswer', 'quiz.wrongAnswer', 'quiz.type', 'quiz.points')
            ->where('quiz.quizSets = :quizSetId')
            ->setParameter('quizSetId', $quizSetId)
            ->getQuery()
            ->getArrayResult();
    }

    public function getAllQuizzesByCourse(int $courseId): array
    {
        return $this->createQueryBuilder('quiz')
            ->select('quiz.id', 'quiz.question', 'quiz.rightAnswer', 'quiz.wrongAnswer', 'quiz.type', 'quiz.points')
            ->join('quiz.quizSets', 'quizSets')
            ->where('quizSets.courses = :courseId')
            ->setParameter('courseId', $courseId)
            ->getQuery()
            ->getArrayResult();
    }

    public function getQuiz(int $quizId): ?Quiz
    {
        return $this->find($quizId);
    }
}
