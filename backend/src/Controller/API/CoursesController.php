<?php

declare(strict_types=1);

namespace App\Controller\API;

use App\Service\CoursesService;
use OpenApi\Attributes\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'api_courses')]
class CoursesController extends AbstractController
{
    public function __construct(private readonly CoursesService $coursesService) {}

    #[Response(response: 200, description: 'Returns the list of courses')]
    #[Response(response: 404, description: 'No courses found')]
    #[Route('/courses', name: 'get_courses', methods: ['GET'])]
    public function getCourses(): JsonResponse
    {
        $courses = $this->coursesService->getAllCourses();

        return new JsonResponse($courses);
    }

    #[Response(response: 200, description: 'Returns the course')]
    #[Response(response: 404, description: 'No course found for id {id}')]
    #[Route('/courses/{id}', name: 'get_course', methods: ['GET'])]
    public function getCourse(int $id): JsonResponse
    {
        $course = $this->coursesService->getCourse($id);

        return new JsonResponse($course->toArray());
    }
}