<?php

namespace App\Entity;

use App\Repository\QuizRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuizRepository::class)]
class Quiz
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, length: 65535, nullable: false)]
    private string $question;

    #[ORM\Column(type: Types::JSON, length: 65535, nullable: false)]
    private array $rightAnswer;

    #[ORM\Column(type: Types::JSON, length: 65535, nullable: false)]
    private array $wrongAnswer;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: false)]
    private string $type;

    #[ORM\ManyToOne(inversedBy: 'quizzes')]
    #[ORM\JoinColumn(nullable: false)]
    private QuizSets $quizSets;

    #[ORM\Column(type: Types::INTEGER, options: ['default' => 0])]
    private int $points = 0;

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'question' => $this->getQuestion(),
            'rightAnswer' => $this->getRightAnswer(),
            'wrongAnswer' => $this->getWrongAnswer(),
            'type' => $this->getType(),
            'points' => $this->getPoints(),
            'quizSets' => $this->quizSets->toArray()
        ];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): string
    {
        return $this->question;
    }

    public function setQuestion(string $question): void
    {
        $this->question = $question;
    }

    public function getRightAnswer(): array
    {
        return $this->rightAnswer;
    }

    public function setRightAnswer(array $rightAnswer): void
    {
        $this->rightAnswer = $rightAnswer;
    }

    public function getWrongAnswer(): array
    {
        return $this->wrongAnswer;
    }

    public function setWrongAnswer(array $wrongAnswer): void
    {
        $this->wrongAnswer = $wrongAnswer;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getQuizSets(): QuizSets
    {
        return $this->quizSets;
    }

    public function setQuizSets(QuizSets $quizSets): void
    {
        $this->quizSets = $quizSets;
    }

    public function getPoints(): int
    {
        return $this->points;
    }

    public function setPoints(int $points): void
    {
        $this->points = $points;
    }
}
