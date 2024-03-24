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

    #[ORM\ManyToOne(targetEntity: QuizSets::class, inversedBy: 'quizzes')]
    private ?QuizSets $quizSets = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true, enumType: QuizTypes::class)]
    private QuizTypes $type;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getRightAnswer(): ?string
    {
        return $this->rightAnswer;
    }

    public function setRightAnswer(?string $rightAnswer): static
    {
        $this->rightAnswer = $rightAnswer;

        return $this;
    }

    public function getWrongAnswer(): ?string
    {
        return $this->wrongAnswer;
    }

    public function setWrongAnswer(?string $wrongAnswer): static
    {
        $this->wrongAnswer = $wrongAnswer;

        return $this;
    }

    public function getQuizSets(): QuizSets
    {
        return $this->quizSets;
    }

    public function setQuizSets(QuizSets $quizSets): static
    {
        $this->quizSets = $quizSets;

        return $this;
    }

    public function getType(): QuizTypes
    {
        return $this->type;
    }

    public function setType(QuizTypes $type): static
    {
        $this->type = $type;

        return $this;
    }
}
