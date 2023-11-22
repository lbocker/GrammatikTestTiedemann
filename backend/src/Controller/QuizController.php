<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Quiz;

#[Route('/api', name: 'api_')]
class QuizController extends AbstractController
{
    #[Route('/quiz', name: 'quiz_index', methods:['get'] )]
    public function index(ManagerRegistry $doctrine): JsonResponse
    {
        $quizManager = $doctrine
            ->getRepository(Quiz::class)
            ->findAll();

        $data = [];

        foreach ($quizManager as $quiz) {
            $data[] = [
                'id' => $quiz->getId(),
                'title' => $quiz->getTitle(),
                'description' => $quiz->getDescription(),
                'category' => $quiz->getCategory(),
                'options' => $quiz->getOptions(),
            ];
        }

        return $this->json($data);
    }

    #[Route('/quiz', name: 'quiz_create', methods:['post'] )]
    public function create(ManagerRegistry $doctrine, Request $request): JsonResponse
    {
        $entityManager = $doctrine->getManager();
        $data = json_decode($request->getContent(), true);

        $quiz = new Quiz();
        $quiz->setTitle($data['title']);
        $quiz->setDescription($data['description']);
        $quiz->setCategory($data['category']);
        $quiz->setOptions($data['options']);

        $entityManager->persist($quiz);
        $entityManager->flush();


        return $this->json($data);
    }

    #[Route('/quiz/{id}', name: 'quiz_show', methods:['get'] )]
    public function show(ManagerRegistry $doctrine, int $id): JsonResponse
    {
        $quiz = $doctrine->getRepository(Quiz::class)->find($id);

        if (!$quiz) {
            return $this->json('No quiz found for id ' . $id, 404);
        }

        $data =  [
            'id' => $quiz->getId(),
            'title' => $quiz->getTitle(),
            'description' => $quiz->getDescription(),
            'category' => $quiz->getCategory(),
            'options' => $quiz->getOptions(),
        ];

        return $this->json($data);
    }

    #[Route('/quiz/{id}', name: 'quiz_update', methods:['put', 'patch'] )]
    public function update(ManagerRegistry $doctrine, Request $request, int $id): JsonResponse
    {
        $entityManager = $doctrine->getManager();
        $quiz = $entityManager->getRepository(Quiz::class)->find($id);
        $data = json_decode($request->getContent(), true);

        if (!$quiz) {
            return $this->json('No quiz found for id ' . $id, 404);
        }

        $quiz->setTitle($data['title']);
        $quiz->setDescription($data['description']);
        $quiz->setCategory($data['category']);
        $quiz->setOptions($data['options']);

        $entityManager->flush();

        return $this->json($data);
    }

    #[Route('/quiz/{id}', name: 'quiz_delete', methods:['delete'] )]
    public function delete(ManagerRegistry $doctrine, int $id): JsonResponse
    {
        $entityManager = $doctrine->getManager();
        $quiz = $entityManager->getRepository(Quiz::class)->find($id);

        if (!$quiz) {
            return $this->json('No quiz found for id ' . $id, 404);
        }

        $entityManager->remove($quiz);
        $entityManager->flush();

        return $this->json('Deleted a quiz successfully with id ' . $id);
    }
}
