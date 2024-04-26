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

    #[ORM\Column(type: Types::STRING, length: 255, nullable: false)]
    private string $title;

    #[ORM\Column(type: Types::TEXT, length: 65535, nullable: true)]
    private ?string $description = null;

    #[ORM\OneToMany(targetEntity: Quiz::class, mappedBy: 'quizSets', cascade: ['persist', 'remove', 'merge', 'detach', 'refresh', 'all'], orphanRemoval: true)]
    private Collection $quizzes;

    #[ORM\ManyToOne(cascade: ['persist', 'remove', 'merge', 'detach', 'refresh', 'all'], inversedBy: 'quizSets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Courses $courses = null;

    public function __construct() {
        $this->quizzes = new ArrayCollection();
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'courses' => $this->getCourses()->toArray(),
            'quizzes' => $this->getQuizzes()->toArray()
        ];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
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

    /**
     * @return Collection<int, Quiz>
     */
    public function getQuizzes(): Collection
    {
        return $this->quizzes;
    }

    public function addQuiz(Quiz $quiz): static
    {
        if (!$this->quizzes->contains($quiz)) {
            $this->quizzes->add($quiz);
            $quiz->setQuizSets($this);
        }

        return $this;
    }

    public function removeQuiz(Quiz $quiz): static
    {
        if ($this->quizzes->removeElement($quiz)) {
            // set the owning side to null (unless already changed)
            if ($quiz->getQuizSets() === $this) {
                $quiz->setQuizSets(null);
            }
        }

        return $this;
    }

    public function getCourses(): ?Courses
    {
        return $this->courses;
    }

    public function setCourses(?Courses $courses): void
    {
        $this->courses = $courses;
    }
}
