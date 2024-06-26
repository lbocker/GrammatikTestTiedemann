<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Courses;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Courses>
 *
 * @method Courses|null find($id, $lockMode = null, $lockVersion = null)
 * @method Courses|null findOneBy(array $criteria, array $orderBy = null)
 * @method Courses[]    findAll()
 * @method Courses[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CoursesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Courses::class);
    }

    public function getAllCourses(): array
    {
        return $this->createQueryBuilder('courses')
            ->select('courses.id', 'courses.title', 'courses.description', 'courses.image')
            ->getQuery()
            ->getArrayResult();
    }

    public function getCourse(int $courseId): ?Courses
    {
        return $this->find($courseId);
    }
}
