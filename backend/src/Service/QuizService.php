<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Quiz;
use App\Repository\QuizRepository;
use Symfony\Component\HttpKernel\Exception\HttpException;

readonly class QuizService
{

    public function __construct(
        private QuizRepository $quizRepository
    ) {}

    public function getAllQuizzes(): array
    {
        $quizzes = $this->quizRepository->getAllQuizzes();

        if (!$quizzes) {
            throw new HttpException(404, 'No quizzes found');
        }

        return $quizzes;
    }

    public function getAllQuizzesByQuizSet(int $quizSetId): array
    {
        $quizzes = $this->quizRepository->getAllQuizzesByQuizSet($quizSetId);

        if (!$quizzes) {
            throw new HttpException(404, 'No quizzes found for quiz set id ' . $quizSetId);
        }

        return $quizzes;
    }

    public function getAllQuizzesByCourse(int $courseId): array
    {
        $quizzes = $this->quizRepository->getAllQuizzesByCourse($courseId);

        if (!$quizzes) {
            throw new HttpException(404, 'No quizzes found for course id ' . $courseId);
        }

        return $quizzes;
    }

    public function getQuiz(int $quizId): ?Quiz
    {
        $quiz = $this->quizRepository->getQuiz($quizId);

        if (!$quiz) {
            throw new HttpException(404, 'No quiz found for id ' . $id);
        }

        return $quiz;
    }
}