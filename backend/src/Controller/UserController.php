<?php

namespace App\Controller;

use App\Entity\Course;
use App\Entity\QuizSets;
use App\Entity\UserQuizSetProgress;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'api_')]
class UserController extends AbstractController
{
    #[Route('/user/score', name: 'user_score', methods: ['GET'])]
    public function getUserScore(EntityManagerInterface $entityManager): JsonResponse
    {
        $user = $this->getUser();

        // Ensure the user is authenticated
        if (!$user) {
            return $this->json(['message' => 'User not authenticated'], 401);
        }

        // Retrieve all completed course progresses for the user
        $courseProgresses = $entityManager->getRepository(UserQuizSetProgress::class)
            ->findBy(['user' => $user, 'status' => 'completed']);

        $totalScore = 0;

        foreach ($courseProgresses as $progress) {
            $totalScore += $progress->getScore();
        }

        $data = [
            'userId' => $user->getId(),
            'username' => $user->getUsername(),
            'totalScore' => $totalScore,
        ];

        return $this->json($data);
    }

    #[Route('/user/courses/{courseId}/progress', name: 'user_course_progress', methods: ['GET'])]
    public function getUserCourseProgress(EntityManagerInterface $entityManager, int $courseId): JsonResponse
    {
        $user = $this->getUser();

        // Ensure the user is authenticated
        if (!$user) {
            return $this->json(['message' => 'User not authenticated'], 401);
        }

        $course = $entityManager->getRepository(Course::class)->find($courseId);

        if (!$course) {
            return $this->json(['message' => 'Course not found'], 404);
        }

        $progress = $entityManager->getRepository(UserQuizSetProgress::class)
            ->findOneBy(['user' => $user, 'course' => $course]);

        if (!$progress) {
            return $this->json(['message' => 'No progress found for user and course'], 404);
        }

        $data = [
            'id' => $progress->getId(),
            'status' => $progress->getStatus(),
            'score' => $progress->getScore(),
        ];

        return $this->json($data);
    }

    #[Route('/user/courses/{courseId}/start', name: 'user_start_course', methods: ['POST'])]
    public function startCourse(EntityManagerInterface $entityManager, int $courseId): JsonResponse
    {
        $user = $this->getUser();

        // Ensure the user is authenticated
        if (!$user) {
            return $this->json(['message' => 'User not authenticated'], 401);
        }

        $course = $entityManager->getRepository(Course::class)->find($courseId);

        if (!$course) {
            return $this->json(['message' => 'Course not found'], 404);
        }

        $progress = new UserQuizSetProgress();
        $progress->setUser($user);
        $progress->setCourse($course);
        $progress->setStatus('started');
        $progress->setScore(0);

        $entityManager->persist($progress);
        $entityManager->flush();

        return $this->json('Course started successfully');
    }

    #[Route('/user/courses/{courseId}/complete', name: 'user_complete_course', methods: ['POST'])]
    public function completeCourse(EntityManagerInterface $entityManager, int $courseId, Request $request): JsonResponse
    {
        $user = $this->getUser();

        // Ensure the user is authenticated
        if (!$user) {
            return $this->json(['message' => 'User not authenticated'], 401);
        }

        $course = $entityManager->getRepository(Course::class)->find($courseId);

        if (!$course) {
            return $this->json(['message' => 'Course not found'], 404);
        }

        $quizSets = $course->getQuizSets();

        foreach ($quizSets as $quizSet) {
            $progress = $entityManager->getRepository(UserQuizSetProgress::class)
                ->findOneBy(['user' => $user, 'quizSet' => $quizSet]);

            if (!$progress || $progress->getStatus() !== 'completed') {
                // If any quiz set is not completed, mark the course as started and exit
                $progress = $entityManager->getRepository(UserQuizSetProgress::class)
                    ->findOneBy(['user' => $user, 'course' => $course]);

                $progress->setStatus('started');
                $progress->setScore($request->get('score'));

                $entityManager->flush();

                return $this->json('Course marked as started because not all quiz sets are completed');
            }
        }

        // If all quiz sets are completed, mark the course as completed
        $progress = $entityManager->getRepository(UserQuizSetProgress::class)
            ->findOneBy(['user' => $user, 'course' => $course]);

        $progress->setStatus('completed');
        $progress->setScore($request->get('score'));

        $entityManager->flush();

        return $this->json('Course completed successfully');
    }

    #[Route('/user/quizsets/{quizSetId}/progress', name: 'user_quizset_progress', methods: ['GET'])]
    public function getUserQuizSetProgress(EntityManagerInterface $entityManager, int $quizSetId): JsonResponse
    {
        $user = $this->getUser();

        // Ensure the user is authenticated
        if (!$user) {
            return $this->json(['message' => 'User not authenticated'], 401);
        }

        $quizSet = $entityManager->getRepository(QuizSets::class)->find($quizSetId);

        if (!$quizSet) {
            return $this->json(['message' => 'Quiz set not found'], 404);
        }

        $progress = $entityManager->getRepository(UserQuizSetProgress::class)
            ->findOneBy(['user' => $user, 'quizSet' => $quizSet]);

        if (!$progress) {
            return $this->json(['message' => 'No progress found for user and quiz set'], 404);
        }

        $data = [
            'id' => $progress->getId(),
            'status' => $progress->getStatus(),
            'score' => $progress->getScore(),
        ];

        return $this->json($data);
    }

    #[Route('/user/quizsets/{quizSetId}/start', name: 'user_start_quizset', methods: ['POST'])]
    public function startQuizSet(EntityManagerInterface $entityManager, int $quizSetId): JsonResponse
    {
        $user = $this->getUser();

        // Ensure the user is authenticated
        if (!$user) {
            return $this->json(['message' => 'User not authenticated'], 401);
        }

        $quizSet = $entityManager->getRepository(QuizSets::class)->find($quizSetId);

        if (!$quizSet) {
            return $this->json(['message' => 'Quiz set not found'], 404);
        }

        $progress = new UserQuizSetProgress();
        $progress->setUser($user);
        $progress->setQuizSet($quizSet);
        $progress->setStatus('started');
        $progress->setScore(0);

        $entityManager->persist($progress);
        $entityManager->flush();

        return $this->json('Quiz set started successfully');
    }

    #[Route('/user/quizsets/{quizSetId}/complete', name: 'user_complete_quizset', methods: ['POST'])]
    public function completeQuizSet(EntityManagerInterface $entityManager, int $quizSetId, Request $request): JsonResponse
    {
        $user = $this->getUser();

        // Ensure the user is authenticated
        if (!$user) {
            return $this->json(['message' => 'User not authenticated'], 401);
        }

        $quizSet = $entityManager->getRepository(QuizSets::class)->find($quizSetId);

        if (!$quizSet) {
            return $this->json(['message' => 'Quiz set not found'], 404);
        }

        $progress = $entityManager->getRepository(UserQuizSetProgress::class)
            ->findOneBy(['user' => $user, 'quizSet' => $quizSet]);

        if (!$progress) {
            return $this->json(['message' => 'Quiz set not started by the user'], 400);
        }

        $requestData = json_decode($request->getContent(), true);

        // Update the progress with completed status and score
        $progress->setStatus('completed');
        $progress->setScore($requestData['score']);

        $entityManager->flush();

        // Check if all quiz sets for the course are completed
        $course = $quizSet->getCourse();
        $quizSets = $course->getQuizSets();
        $totalScore = 0;

        foreach ($quizSets as $qs) {
            $progress = $entityManager->getRepository(UserQuizSetProgress::class)
                ->findOneBy(['user' => $user, 'quizSet' => $qs]);

            if (!$progress || $progress->getStatus() !== 'completed') {
                // If any quiz set is not completed, break out of the loop
                break;
            }

            // Accumulate the scores of completed quiz sets
            $totalScore += $progress->getScore();
        }

        // If all quiz sets are completed, update the course progress with total score
        if (count($quizSets) > 0 && count($quizSets) == $totalScore) {
            $courseProgress = $entityManager->getRepository(UserQuizSetProgress::class)
                ->findOneBy(['user' => $user, 'course' => $course]);

            $courseProgress->setStatus('completed');
            $courseProgress->setScore($totalScore);

            $entityManager->flush();
        }

        return $this->json('Quiz set completed successfully');
    }
}
