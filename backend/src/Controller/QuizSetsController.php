<?php

namespace App\Controller;

use App\Entity\Quiz;
use App\Entity\QuizSets;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'api_')]
class QuizSetsController extends AbstractController
{
    #[Route('/quizsets/{id}', name: 'quizset_show', methods: ['GET'])]
    public function showQuizSet(EntityManagerInterface $entityManager, int $id): JsonResponse
    {
        $quizSet = $entityManager->getRepository(QuizSets::class)->find($id);

        if (!$quizSet) {
            return $this->json('No quiz set found for id ' . $id, 404);
        }

        $data = [
            'id' => $quizSet->getId(),
            'title' => $quizSet->getTitle(),
            'description' => $quizSet->getDescription(),
            'course' => $quizSet->getCourse()->getTitle(),
            'quizzes' => $this->serializeQuizzes($quizSet->getQuizzes()),
        ];

        return $this->json($data);
    }

    #[Route('/quizsets/{id}', name: 'quizset_update', methods: ['PUT', 'PATCH'])]
    public function updateQuizSet(Request $request, EntityManagerInterface $entityManager, int $id): JsonResponse
    {
        $quizSet = $entityManager->getRepository(QuizSets::class)->find($id);

        if (!$quizSet) {
            return $this->json('No quiz set found for id ' . $id, 404);
        }

        $requestData = json_decode($request->getContent(), true);

        if (!isset($requestData['title']) || !isset($requestData['description'])) {
            return $this->json('Invalid request. Title and description are required.', 400);
        }

        $quizSet->setTitle($requestData['title']);
        $quizSet->setDescription($requestData['description']);

        $entityManager->flush();

        return $this->json($quizSet);
    }

    #[Route('/quizsets/{id}', name: 'quizset_delete', methods: ['DELETE'])]
    public function deleteQuizSet(EntityManagerInterface $entityManager, int $id): JsonResponse
    {
        $quizSet = $entityManager->getRepository(QuizSets::class)->find($id);

        if (!$quizSet) {
            return $this->json('No quiz set found for id ' . $id, 404);
        }

        $entityManager->remove($quizSet);
        $entityManager->flush();

        return $this->json('Deleted a quiz set successfully with id ' . $id);
    }

    #[Route('/quizsets/{id}/quizzes', name: 'quizset_quizzes', methods: ['GET'])]
    public function getQuizzesForQuizSet(EntityManagerInterface $entityManager, int $id): JsonResponse
    {
        $quizSet = $entityManager->getRepository(QuizSets::class)->find($id);

        if (!$quizSet) {
            return $this->json('No quiz set found for id ' . $id, 404);
        }

        $quizzes = $this->serializeQuizzes($quizSet->getQuizzes());

        return $this->json($quizzes);
    }

    #[Route('/quizsets/{id}/add-quiz', name: 'quizset_add_quiz', methods: ['POST'])]
    public function addQuizToQuizSet(Request $request, EntityManagerInterface $entityManager, int $id): JsonResponse
    {
        $quizSet = $entityManager->getRepository(QuizSets::class)->find($id);

        if (!$quizSet) {
            return $this->json('No quiz set found for id ' . $id, 404);
        }

        $requestData = json_decode($request->getContent(), true);

        if (!isset($requestData['type']) || !isset($requestData['question']) || !isset($requestData['rightAnswer']) || !isset($requestData['wrongAnswer'])) {
            return $this->json('Invalid request. Type, question, rightAnswer, and wrongAnswer are required.', 400);
        }

        $quiz = new Quiz();
        $quiz->setType($requestData['type']);
        $quiz->setQuestion($requestData['question']);
        $quiz->setRightAnswer($requestData['rightAnswer']);
        $quiz->setWrongAnswer($requestData['wrongAnswer']);
        $quiz->setQuizSet($quizSet);

        $entityManager->persist($quiz);
        $entityManager->flush();

        return $this->json($quiz, 201);
    }

    private function serializeQuizSets($quizSets)
    {
        $serializedQuizSets = [];

        foreach ($quizSets as $quizSet) {
            $serializedQuizSets[] = [
                'id' => $quizSet->getId(),
                'title' => $quizSet->getTitle(),
                'description' => $quizSet->getDescription(),
                'quizzes' => $this->serializeQuizzes($quizSet->getQuizzes()),
            ];
        }

        return $serializedQuizSets;
    }

    private function serializeQuizzes($quizzes)
    {
        $serializedQuizzes = [];

        foreach ($quizzes as $quiz) {
            $serializedQuizzes[] = [
                'id' => $quiz->getId(),
                'type' => $quiz->getType(),
                'question' => $quiz->getQuestion(),
                'rightAnswer' => $quiz->getRightAnswer(),
                'wrongAnswer' => $quiz->getWrongAnswer(),
            ];
        }

        return $serializedQuizzes;
    }
}
