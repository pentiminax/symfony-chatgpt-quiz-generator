<?php

namespace App\Controller;

use App\Entity\QuizResult;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuizResultController extends AbstractController
{
    #[Route('/quizzes/result/{id}', name: 'app_quiz_result')]
    public function index(?QuizResult $quizResult): Response
    {
        if (!$quizResult) {
            return $this->redirectToRoute('app_home');
        }

        return $this->render('quiz_result/index.html.twig', [
            'quizResult' => $quizResult
        ]);
    }
}
