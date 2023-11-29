<?php

namespace App\Controller;

use App\Entity\Course;
use App\Entity\QuizSets;
use App\Entity\Quiz;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'api_')]
class ApiController extends AbstractController
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

        // Ensure required fields are present in the request data
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

        // Ensure required fields are present in the request data
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

        // Ensure required fields are present in the request data
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

        // Ensure required fields are present in the request data
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

        // Ensure required fields are present in the request data
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

        // Ensure required fields are present in the request data
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

        // Ensure required fields are present in the request data
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
