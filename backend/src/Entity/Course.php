<?php

namespace App\Entity;

use App\Repository\CourseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CourseRepository::class)]
class Course
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'course', targetEntity: QuizSets::class, cascade: ["persist"])]
    private Collection $quizSets;

    public function __construct()
    {
        $this->quizSets = new ArrayCollection();
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

    public function getQuizSets(): Collection
    {
        return $this->quizSets;
    }

    public function addQuizSet(QuizSets $quizSet): static
    {
        if (!$this->quizSets->contains($quizSet)) {
            $this->quizSets[] = $quizSet;
            $quizSet->setCourse($this);
        }

        return $this;
    }

    public function removeQuizSet(QuizSets $quizSet): static
    {
        if ($this->quizSets->removeElement($quizSet)) {
            // set the owning side to null (unless already changed)
            if ($quizSet->getCourse() === $this) {
                $quizSet->setCourse(null);
            }
        }

        return $this;
    }
}
