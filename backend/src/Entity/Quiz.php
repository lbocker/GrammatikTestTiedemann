<?php

namespace App\Entity;

use App\Repository\QuizRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuizRepository::class)]
class Quiz
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $type = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $question = null;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private mixed $rightAnswer = null;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private mixed $wrongAnswer = null;

    #[ORM\ManyToOne(inversedBy: 'quizzes', targetEntity: QuizSets::class)]
    private ?QuizSets $quizSet;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(?string $question): static
    {
        $this->question = $question;

        return $this;
    }

    public function getRightAnswer(): mixed
    {
        return $this->rightAnswer;
    }

    public function setRightAnswer(mixed $rightAnswer): static
    {
        $this->rightAnswer = $rightAnswer;

        return $this;
    }

    public function getWrongAnswer(): mixed
    {
        return $this->wrongAnswer;
    }

    public function setWrongAnswer(mixed $wrongAnswer): static
    {
        $this->wrongAnswer = $wrongAnswer;

        return $this;
    }

    public function getQuizSet(): ?QuizSets
    {
        return $this->quizSet;
    }

    public function setQuizSet(?QuizSets $quizSet): static
    {
        $this->quizSet = $quizSet;

        return $this;
    }
}
