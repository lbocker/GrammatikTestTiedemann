<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\QuizSets;
use App\Repository\QuizSetsRepository;
use Symfony\Component\HttpKernel\Exception\HttpException;

readonly class QuizSetsService
{
    public function __construct(
        private QuizSetsRepository $quizSetsRepository
    ) {}

    public function getAllQuizSets(): array
    {
        $quizSets = $this->quizSetsRepository->getAllQuizSets();

        if (!$quizSets) {
            throw new HttpException(404, 'No quiz sets found');
        }

        return $quizSets;
    }

    public function getAllQuizSetsByCourse(int $courseId): array
    {
        $quizSets = $this->quizSetsRepository->getAllQuizSetsByCourse($courseId);

        if (!$quizSets) {
            throw new HttpException(404, 'No quiz sets found for course id ' . $courseId);
        }

        return $quizSets;
    }

    public function getQuizSet(int $quizSetId): ?QuizSets
    {
        $quizSet = $this->quizSetsRepository->getQuizSet($quizSetId);

        if (!$quizSet) {
            throw new HttpException(404, 'No quiz set found for id ' . $quizSetId);
        }

        return $quizSet;
    }
}