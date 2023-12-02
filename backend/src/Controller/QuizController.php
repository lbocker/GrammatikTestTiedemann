<?php

namespace App\Controller;

use App\Entity\Quiz;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'api_')]
class QuizController extends AbstractController
{
    #[Route('/quizzes', name: 'quiz_index', methods: ['GET'])]
    public function indexQuizzes(EntityManagerInterface $entityManager): JsonResponse
    {
        $quizzes = $entityManager->getRepository(Quiz::class)->findAll();

        $data = [];

        foreach ($quizzes as $quiz) {
            $data[] = [
                'id' => $quiz->getId(),
                'type' => $quiz->getType(),
                'question' => $quiz->getQuestion(),
                'rightAnswer' => $quiz->getRightAnswer(),
                'wrongAnswer' => $quiz->getWrongAnswer(),
            ];
        }

        return $this->json($data);
    }

    #[Route('/quizzes', name: 'quiz_create', methods: ['POST'])]
    public function createQuiz(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);

        if (!isset($requestData['type']) || !isset($requestData['question']) || !isset($requestData['rightAnswer']) || !isset($requestData['wrongAnswer'])) {
            return $this->json('Invalid request. Type, question, rightAnswer, and wrongAnswer are required.', 400);
        }

        $quiz = new Quiz();
        $quiz->setType($requestData['type']);
        $quiz->setQuestion($requestData['question']);
        $quiz->setRightAnswer($requestData['rightAnswer']);
        $quiz->setWrongAnswer($requestData['wrongAnswer']);

        $entityManager->persist($quiz);
        $entityManager->flush();

        return $this->json($quiz, 201);
    }

    #[Route('/quizzes/{id}', name: 'quiz_show', methods: ['GET'])]
    public function showQuiz(EntityManagerInterface $entityManager, int $id): JsonResponse
    {
        $quiz = $entityManager->getRepository(Quiz::class)->find($id);

        if (!$quiz) {
            return $this->json('No quiz found for id ' . $id, 404);
        }

        $data = [
            'id' => $quiz->getId(),
            'type' => $quiz->getType(),
            'question' => $quiz->getQuestion(),
            'rightAnswer' => $quiz->getRightAnswer(),
            'wrongAnswer' => $quiz->getWrongAnswer(),
        ];

        return $this->json($data);
    }

    #[Route('/quizzes/{id}', name: 'quiz_update', methods: ['PUT', 'PATCH'])]
    public function updateQuiz(Request $request, EntityManagerInterface $entityManager, int $id): JsonResponse
    {
        $quiz = $entityManager->getRepository(Quiz::class)->find($id);

        if (!$quiz) {
            return $this->json('No quiz found for id ' . $id, 404);
        }

        $requestData = json_decode($request->getContent(), true);

        if (!isset($requestData['type']) || !isset($requestData['question']) || !isset($requestData['rightAnswer']) || !isset($requestData['wrongAnswer'])) {
            return $this->json('Invalid request. Type, question, rightAnswer, and wrongAnswer are required.', 400);
        }

        $quiz->setType($requestData['type']);
        $quiz->setQuestion($requestData['question']);
        $quiz->setRightAnswer($requestData['rightAnswer']);
        $quiz->setWrongAnswer($requestData['wrongAnswer']);

        $entityManager->flush();

        return $this->json($quiz);
    }

    #[Route('/quizzes/{id}', name: 'quiz_delete', methods: ['DELETE'])]
    public function deleteQuiz(EntityManagerInterface $entityManager, int $id): JsonResponse
    {
        $quiz = $entityManager->getRepository(Quiz::class)->find($id);

        if (!$quiz) {
            return $this->json('No quiz found for id ' . $id, 404);
        }

        $entityManager->remove($quiz);
        $entityManager->flush();

        return $this->json('Deleted a quiz successfully with id ' . $id);
    }
}
