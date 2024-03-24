<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Courses;
use App\Repository\CoursesRepository;
use Symfony\Component\HttpKernel\Exception\HttpException;

readonly class CoursesService
{

    public function __construct(
        private CoursesRepository $coursesRepository
    ) {}

    public function getAllCourses(): array
    {
        $courses = $this->coursesRepository->getAllCourses();

        if (!$courses) {
            throw new HttpException(404, 'No courses found');
        }

        return $courses;
    }

    public function getCourse(int $courseId): ?Courses
    {
        $course = $this->coursesRepository->getCourse($courseId);

        if (!$course) {
            throw new HttpException(404, 'No course found for id ' . $courseId);
        }

        return $course;

    }
}