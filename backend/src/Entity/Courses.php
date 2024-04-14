<?php

namespace App\Entity;

use App\Repository\CoursesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CoursesRepository::class)]
class Courses
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: TYPES::STRING, length: 255, nullable: false)]
    private string $title;

    #[ORM\Column(type: Types::TEXT, length: 65535, nullable: true)]
    private ?string $description;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $image;

    #[ORM\OneToMany(targetEntity: QuizSets::class, mappedBy: 'courses', cascade: ['persist', 'remove', 'merge', 'detach', 'refresh', 'all', 'delete'], orphanRemoval: true)]
    private Collection $quizSets;

    #[ORM\OneToMany(targetEntity: UserCoursesStatus::class, mappedBy: 'courses_id', cascade: ['persist', 'remove', 'merge', 'detach', 'refresh', 'all'], orphanRemoval: true)]
    private Collection $userCoursesStatuses;

    public function __construct() {
        $this->quizSets = new ArrayCollection();
        $this->userCoursesStatuses = new ArrayCollection();
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'image' => $this->getImage(),
            'coursesStatus' => $this->getUserCoursesStatuses()?->toArray(),
        ];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    /**
     * @return Collection<int, QuizSets>
     */
    public function getQuizSets(): Collection
    {
        return $this->quizSets;
    }

    public function addQuizSet(QuizSets $quizSet): static
    {
        if (!$this->quizSets->contains($quizSet)) {
            $this->quizSets->add($quizSet);
            $quizSet->setCourses($this);
        }

        return $this;
    }

    public function removeQuizSet(QuizSets $quizSet): static
    {
        if ($this->quizSets->removeElement($quizSet)) {
            // set the owning side to null (unless already changed)
            if ($quizSet->getCourses() === $this) {
                $quizSet->setCourses(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UserCoursesStatus>
     */
    public function getUserCoursesStatuses(): Collection
    {
        return $this->userCoursesStatuses;
    }

    public function addUserCoursesStatus(UserCoursesStatus $userCoursesStatus): static
    {
        if (!$this->userCoursesStatuses->contains($userCoursesStatus)) {
            $this->userCoursesStatuses->add($userCoursesStatus);
            $userCoursesStatus->setCoursesId($this);
        }

        return $this;
    }

    public function removeUserCoursesStatus(UserCoursesStatus $userCoursesStatus): static
    {
        if ($this->userCoursesStatuses->removeElement($userCoursesStatus)) {
            // set the owning side to null (unless already changed)
            if ($userCoursesStatus->getCoursesId() === $this) {
                $userCoursesStatus->setCoursesId(null);
            }
        }

        return $this;
    }
}
