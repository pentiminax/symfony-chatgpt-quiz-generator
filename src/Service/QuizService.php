<?php

namespace App\Service;

use App\Entity\Answer;
use App\Entity\Question;
use App\Entity\Quiz;
use App\Repository\QuizRepository;
use Doctrine\ORM\EntityManagerInterface;

class QuizService
{
    public function __construct(
        private EntityManagerInterface $em,
        private QuizRepository $quizRepo
    )
    {
    }

    public function add(array $quizData): Quiz
    {
        $quiz = new Quiz($quizData['title']);

        foreach ($quizData['questions'] as $questionData) {
            $answers = $questionData['answers'];
            $correctAnswer = $questionData['answer'];

            $question = new Question($questionData['question']);

            $quiz->addQuestion($question);

            $this->em->persist($question);

            foreach ($answers as $key => $answerData) {
                $answer = new Answer($answerData);
                $answer->setIsCorrect($key === array_search($correctAnswer, $answers));

                $question->addAnswer($answer);

                $this->em->persist($answer);
            }
        }

        $this->quizRepo->save($quiz, true);

        return $quiz;
    }
}