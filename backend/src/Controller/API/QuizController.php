<?php

declare(strict_types=1);

namespace App\Controller\API;

use App\Service\QuizService;
use OpenApi\Attributes\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class QuizController extends AbstractController
{
    public function __construct(private readonly QuizService $quizService) {}

    #[Response(response: 200, description: 'Returns the list of quizzes')]
    #[Response(response: 404, description: 'No quizzes found')]
    #[Route('/api/quizzes', name: 'get_quizzes', methods: ['GET'])]
    public function getQuizzes(): JsonResponse
    {
        $quizzes = $this->quizService->getAllQuizzes();

        return $this->json($quizzes);
    }

    #[Response(response: 200, description: 'Returns the list of quizzes for a quiz set')]
    #[Response(response: 404, description: 'No quizzes found for quiz set id {quizSetId}')]
    #[Route('/api/quizzes/{quizSetId}', name: 'get_quizzes_by_quiz_set', methods: ['GET'])]
    public function getQuizzesByQuizSet(int $quizSetId): JsonResponse
    {
        $quizzes = $this->quizService->getAllQuizzesByQuizSet($quizSetId);

        return $this->json($quizzes);
    }

    #[Response(response: 200, description: 'Returns the quiz')]
    #[Response(response: 404, description: 'No quiz found for id {id}')]
    #[Route('/api/quiz/{id}', name: 'get_quiz', methods: ['GET'])]
    public function getQuiz(int $id): JsonResponse
    {
        $quiz = $this->quizService->getQuiz($id);

        return $this->json($quiz->toArray());
    }
}
