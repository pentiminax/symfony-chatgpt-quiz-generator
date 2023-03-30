<?php

namespace App\Service;

use App\Entity\Quiz;
use App\Entity\QuizResult;
use App\Repository\QuizResultRepository;

class QuizResultService
{
    public function __construct(
        private readonly QuizResultRepository $quizResultRepo
    )
    {
    }

    public function add(Quiz $quiz, array $quizResultData): QuizResult
    {
        $quizResult = new QuizResult($quiz, $quizResultData);

        $this->quizResultRepo->save($quizResult, true);

        return $quizResult;
    }
}