<?php

namespace App\Entity;

use App\Repository\QuizRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: QuizRepository::class)]
class Quiz
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['quiz:list', 'quiz:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['quiz:list', 'quiz:read', 'quizResult:read'])]
    private ?string $title = null;

    #[ORM\OneToMany(mappedBy: 'quiz', targetEntity: Question::class)]
    #[Groups(['quiz:read', 'quizResult:read'])]
    private Collection $questions;

    #[ORM\OneToMany(mappedBy: 'quiz', targetEntity: QuizResult::class)]
    private Collection $quizResults;

    public function __construct(string $title)
    {
        $this->questions = new ArrayCollection();
        $this->title = $title;
        $this->quizResults = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection<int, Question>
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(Question $question): self
    {
        if (!$this->questions->contains($question)) {
            $this->questions->add($question);
            $question->setQuiz($this);
        }

        return $this;
    }

    public function removeQuestion(Question $question): self
    {
        if ($this->questions->removeElement($question)) {
            // set the owning side to null (unless already changed)
            if ($question->getQuiz() === $this) {
                $question->setQuiz(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, QuizResult>
     */
    public function getQuizResults(): Collection
    {
        return $this->quizResults;
    }

    public function addQuizResult(QuizResult $quizResult): self
    {
        if (!$this->quizResults->contains($quizResult)) {
            $this->quizResults->add($quizResult);
            $quizResult->setQuiz($this);
        }

        return $this;
    }

    public function removeQuizResult(QuizResult $quizResult): self
    {
        if ($this->quizResults->removeElement($quizResult)) {
            // set the owning side to null (unless already changed)
            if ($quizResult->getQuiz() === $this) {
                $quizResult->setQuiz(null);
            }
        }

        return $this;
    }
}
