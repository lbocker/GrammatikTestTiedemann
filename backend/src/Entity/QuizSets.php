<?php

namespace App\Entity;

use App\Repository\QuizSetsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuizSetsRepository::class)]
class QuizSets
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\ManyToOne(targetEntity: Course::class, inversedBy: 'quizSets')]
    private ?Course $course;

    #[ORM\OneToMany(mappedBy: 'quizSet', targetEntity: Quiz::class, cascade: ["persist"])]
    private Collection $quizzes;

    public function __construct()
    {
        $this->quizzes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCourse(): ?Course
    {
        return $this->course;
    }

    public function setCourse(?Course $course): static
    {
        $this->course = $course;

        return $this;
    }

    public function getQuizzes(): Collection
    {
        return $this->quizzes;
    }

    public function setQuiz(Quiz $quiz): static
    {
        if (!$this->quizzes->contains($quiz)) {
            $this->quizzes[] = $quiz;
            $quiz->setQuizSet($this);
        }

        return $this;
    }

    public function addQuiz(Quiz $quiz): static
    {
        if (!$this->quizzes->contains($quiz)) {
            $this->quizzes[] = $quiz;
            $quiz->setQuizSet($this);
        }

        return $this;
    }

    public function removeQuiz(Quiz $quiz): static
    {
        if ($this->quizzes->removeElement($quiz)) {
            // set the owning side to null (unless already changed)
            if ($quiz->getQuizSet() === $this) {
                $quiz->setQuizSet(null);
            }
        }

        return $this;
    }
}
