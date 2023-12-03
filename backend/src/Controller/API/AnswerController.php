<?php

namespace App\Controller\API;

use App\Entity\Quiz;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/answer', name: 'api_')]
class AnswerController extends AbstractController
{
    #[Route('/quiz/{quizId}', name: 'check_quiz_answer', methods: ['POST'])]
    public function checkQuizAnswer(Request $request, EntityManagerInterface $entityManager, int $quizId): JsonResponse
    {
        $quiz = $entityManager->getRepository(Quiz::class)->find($quizId);

        if (!$quiz) {
            return $this->json(['message' => 'Quiz not found'], 404);
        }

        $requestData = json_decode($request->getContent(), true);

        if ($requestData['answer'] === $quiz->getRightAnswer()) {
            // TODO: handle correct answer logic (update user score, progress, etc.)
            return $this->json(['result' => 'correct']);
        } else {
            // TODO: handle incorrect answer logic
            return $this->json(['result' => 'incorrect']);
        }
    }
}
