<?php

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

    public function getQuiz(int $quizId): ?Quiz
    {
        $quiz = $this->quizRepository->getQuiz($quizId);

        if (!$quiz) {
            throw new HttpException(404, 'No quiz found for id ' . $id);
        }

        return $quiz;
    }
}