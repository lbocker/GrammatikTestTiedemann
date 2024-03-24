<?php

declare(strict_types=1);

namespace App\Controller\API;

use App\Service\QuizSetsService;
use OpenApi\Attributes\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'api_quiz_sets')]
class QuizSetsController extends AbstractController
{
    public function __construct(private readonly QuizSetsService $quizSetsService) {}

    #[Response(response: 200, description: 'Returns the list of quiz sets')]
    #[Response(response: 404, description: 'No quiz sets found')]
    #[Route('/quiz-sets', name: 'get_quiz_sets', methods: ['GET'])]
    public function getQuizSets(): JsonResponse
    {
        $quizSets = $this->quizSetsService->getAllQuizSets();

        return $this->json($quizSets);
    }

    /* Create a function that get All quizset that have the same course id */
    #[Response(response: 200, description: 'Returns the list of quiz sets')]
    #[Response(response: 404, description: 'No quiz sets found')]
    #[Route('/quiz-sets/course/{id}', name: 'get_quiz_sets_by_course', methods: ['GET'])]
    public function getQuizSetsByCourse(int $id): JsonResponse
    {
        $quizSets = $this->quizSetsService->getAllQuizSetsByCourse($id);

        return $this->json($quizSets);
    }

    #[Response(response: 200, description: 'Returns the quiz set')]
    #[Response(response: 404, description: 'No quiz set found for id {id}')]
    #[Route('/quiz-sets/{id}', name: 'get_quiz_set', methods: ['GET'])]
    public function getQuizSet(int $id): JsonResponse
    {
        $quizSet = $this->quizSetsService->getQuizSet($id);

        return $this->json($quizSet->toArray());
    }
}