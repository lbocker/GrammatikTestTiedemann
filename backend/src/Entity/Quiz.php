<?php

namespace App\Entity;

use App\Repository\QuizRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuizRepository::class)]
class Quiz
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $question = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $rightAnswer = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $wrongAnswer = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $type = null;

    #[ORM\ManyToOne(inversedBy: 'quizzes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?QuizSets $quizSets = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(?string $question): void
    {
        $this->question = $question;
    }

    public function getRightAnswer(): ?string
    {
        return $this->rightAnswer;
    }

    public function setRightAnswer(?string $rightAnswer): void
    {
        $this->rightAnswer = $rightAnswer;
    }

    public function getWrongAnswer(): ?string
    {
        return $this->wrongAnswer;
    }

    public function setWrongAnswer(?string $wrongAnswer): void
    {
        $this->wrongAnswer = $wrongAnswer;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    public function getQuizSets(): ?QuizSets
    {
        return $this->quizSets;
    }

    public function setQuizSets(?QuizSets $quizSets): void
    {
        $this->quizSets = $quizSets;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'question' => $this->question,
            'rightAnswer' => $this->rightAnswer,
            'wrongAnswer' => $this->wrongAnswer,
            'type' => $this->type,
            'quizSets' => $this->quizSets?->toArray()
        ];
    }
}
