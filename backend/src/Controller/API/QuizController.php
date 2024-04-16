<?php

declare(strict_types=1);

namespace App\Controller\API;

use App\Service\QuizService;
use OpenApi\Attributes\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api', name: 'api_quiz')]
class QuizController extends AbstractController
{
    public function __construct(private readonly QuizService $quizService) {}

    #[Response(response: 200, description: 'Returns the list of quizzes, with courses and quiz sets')]
    #[Response(response: 404, description: 'No quizzes found')]
    #[Route('/api/quizzes', name: 'get_quizzes', methods: ['GET'])]
    public function getQuizzes(): JsonResponse
    {
        $quizzes = $this->quizService->getAllQuizzes();

        return new JsonResponse($quizzes);
    }

    #[Response(response: 200, description: 'Returns the list of quizzes for a quiz set')]
    #[Response(response: 404, description: 'No quizzes found for quiz set id {quizSetId}')]
    #[Route('/quizzes/{quizSetId}', name: 'get_quizzes_by_quiz_set', methods: ['GET'])]
    public function getQuizzesByQuizSet(int $quizSetId): JsonResponse
    {
        $quizzes = $this->quizService->getAllQuizzesByQuizSet($quizSetId);

        return new JsonResponse($quizzes);
    }

    #[Response(response: 200, description: 'Returns the list of quizzes for a course')]
    #[Response(response: 404, description: 'No quizzes found for course id {courseId}')]
    #[Route('/course/{courseId}/quizzes', name: 'get_quizzes_by_course', methods: ['GET'])]
    public function getQuizzesByCourse(int $courseId): JsonResponse
    {
        $quizzes = $this->quizService->getAllQuizzesByCourse($courseId);

        return new JsonResponse($quizzes);
    }

    #[Response(response: 200, description: 'Returns the quiz, with course and quiz set')]
    #[Response(response: 404, description: 'No quiz found for id {id}')]
    #[Route('/quiz/{id}', name: 'get_quiz', methods: ['GET'])]
    public function getQuiz(int $id): JsonResponse
    {
        $quiz = $this->quizService->getQuiz($id);

        return new JsonResponse($quiz->toArray());
    }
}
