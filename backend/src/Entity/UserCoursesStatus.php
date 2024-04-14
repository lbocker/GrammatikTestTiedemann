<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\UserCoursesStatusRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserCoursesStatusRepository::class)]
class UserCoursesStatus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(cascade: ['persist', 'remove', 'merge', 'detach', 'refresh', 'all'], inversedBy: 'userCoursesStatuses')]
    #[ORM\JoinColumn(name: 'courses_id', referencedColumnName: 'id')]
    private Courses $courses_id;

    #[ORM\ManyToOne(cascade: ['persist', 'remove', 'merge', 'detach', 'refresh', 'all'], inversedBy: 'userCoursesStatuses')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    private User $user_id;

    #[ORM\Column(length: 255, nullable: false, enumType: CoursesStatus::class)]
    private CoursesStatus $status;

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'courses_id' => $this->getCoursesId()->toArray(),
            'user_id' => $this->getUserId()->toArray(),
            'status' => $this->getStatus()->toArray(),
        ];
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCoursesId(): Courses
    {
        return $this->courses_id;
    }

    public function setCoursesId(Courses $courses_id): void
    {
        $this->courses_id = $courses_id;
    }

    public function getUserId(): User
    {
        return $this->user_id;
    }

    public function setUserId(User $user_id): void
    {
        $this->user_id = $user_id;
    }

    public function getStatus(): CoursesStatus
    {
        return $this->status;
    }

    public function setStatus(CoursesStatus $status): void
    {
        $this->status = $status;
    }
}
