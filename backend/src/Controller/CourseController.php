<?php

namespace App\Controller;

use App\Entity\Course;
use App\Entity\QuizSets;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'api_')]
class CourseController extends AbstractController
{
    #[Route('/courses', name: 'course_index', methods: ['GET'])]
    public function indexCourses(EntityManagerInterface $entityManager): JsonResponse
    {
        $courses = $entityManager->getRepository(Course::class)->findAll();

        $data = [];

        foreach ($courses as $course) {
            $data[] = [
                'id' => $course->getId(),
                'title' => $course->getTitle(),
                'description' => $course->getDescription(),
                'quizSets' => $this->serializeQuizSets($course->getQuizSets()),
            ];
        }

        return $this->json($data);
    }

    #[Route('/courses', name: 'course_create', methods: ['POST'])]
    public function createCourse(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);

        if (!isset($requestData['title']) || !isset($requestData['description'])) {
            return $this->json('Invalid request. Title and description are required.', 400);
        }

        $course = new Course();
        $course->setTitle($requestData['title']);
        $course->setDescription($requestData['description']);

        $entityManager->persist($course);
        $entityManager->flush();

        return $this->json($course, 201);
    }

    #[Route('/courses/{id}', name: 'course_show', methods: ['GET'])]
    public function showCourse(EntityManagerInterface $entityManager, int $id): JsonResponse
    {
        $course = $entityManager->getRepository(Course::class)->find($id);

        if (!$course) {
            return $this->json('No course found for id ' . $id, 404);
        }

        $data = [
            'id' => $course->getId(),
            'title' => $course->getTitle(),
            'description' => $course->getDescription(),
            'quizSets' => $this->serializeQuizSets($course->getQuizSets()),
        ];

        return $this->json($data);
    }

    #[Route('/courses/{id}', name: 'course_update', methods: ['PUT', 'PATCH'])]
    public function updateCourse(Request $request, EntityManagerInterface $entityManager, int $id): JsonResponse
    {
        $course = $entityManager->getRepository(Course::class)->find($id);

        if (!$course) {
            return $this->json('No course found for id ' . $id, 404);
        }

        $requestData = json_decode($request->getContent(), true);

        if (!isset($requestData['title']) || !isset($requestData['description'])) {
            return $this->json('Invalid request. Title and description are required.', 400);
        }

        $course->setTitle($requestData['title']);
        $course->setDescription($requestData['description']);

        $entityManager->flush();

        return $this->json($course);
    }

    #[Route('/courses/{id}', name: 'course_delete', methods: ['DELETE'])]
    public function deleteCourse(EntityManagerInterface $entityManager, int $id): JsonResponse
    {
        $course = $entityManager->getRepository(Course::class)->find($id);

        if (!$course) {
            return $this->json('No course found for id ' . $id, 404);
        }

        $entityManager->remove($course);
        $entityManager->flush();

        return $this->json('Deleted a course successfully with id ' . $id);
    }

    #[Route('/courses/{id}/quizsets', name: 'course_quizsets', methods: ['GET'])]
    public function getQuizSetsForCourse(EntityManagerInterface $entityManager, int $id): JsonResponse
    {
        $course = $entityManager->getRepository(Course::class)->find($id);

        if (!$course) {
            return $this->json('No course found for id ' . $id, 404);
        }

        $quizSets = $this->serializeQuizSets($course->getQuizSets());

        return $this->json($quizSets);
    }

    #[Route('/courses/{courseId}/quizsets', name: 'course_add_quizset', methods: ['POST'])]
    public function addQuizSetToCourse(Request $request, EntityManagerInterface $entityManager, int $courseId): JsonResponse
    {
        $course = $entityManager->getRepository(Course::class)->find($courseId);

        if (!$course) {
            return $this->json('No course found for id ' . $courseId, 404);
        }

        $requestData = json_decode($request->getContent(), true);

        if (!isset($requestData['title']) || !isset($requestData['description'])) {
            return $this->json('Invalid request. Title and description are required.', 400);
        }

        $quizSet = new QuizSets();
        $quizSet->setTitle($requestData['title']);
        $quizSet->setDescription($requestData['description']);
        $quizSet->setCourse($course);

        $entityManager->persist($quizSet);
        $entityManager->flush();

        return $this->json($quizSet, 201);
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
