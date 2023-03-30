<?php

namespace App\Controller;

use App\Entity\Quiz;
use App\Service\QuizResultService;
use App\Service\QuizService;
use OpenAI\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuizController extends AbstractController
{
    public function __construct(
        private readonly QuizService $quizService,
        private readonly QuizResultService $quizResultService
    )
    {
    }

    #[Route('/quizzes/{id}', name: 'app_quiz_show', methods: ['GET', 'POST'])]
    public function show(?Quiz $quiz, Request $request): Response
    {
        if (!$quiz) {
            return $this->redirectToRoute('app_home');
        }

        if($request->isXmlHttpRequest() && $request->isMethod(Request::METHOD_POST)) {
            $body = json_decode($request->getContent(), true);

            if(!isset($body['quizResult'])) {
                return $this->json([
                    'error' => 'Missing quizResult'
                ]);
            }

            $quizResult = $this->quizResultService->add($quiz, $body['quizResult']);

            return $this->json([
                'quizResult' => [
                    'id' => $quizResult->getId()
                ]
            ]);
        }

        return $this->render('quiz/index.html.twig', [
            'quiz' => $quiz,
        ]);
    }

    #[Route('/quizzes', name: 'app_quiz_add', methods: ['POST'])]
    public function add(Client $client, Request $request): Response
    {
        if (!$request->isXmlHttpRequest()) {
            return $this->json([
                'error' => 'Method not allowed'
            ]);
        }

        $body = json_decode($request->getContent(), true);

        if (!isset($body['content'])) {
            return $this->json([
                'error' => 'Missing content'
            ]);
        }

        $content = "Rédige un quiz de 5 questions avec un titre et 3 réponses par questions portant sur le sujet '{$body['content']}' au format JSON.  
        Les propriétés utilisées sont 'answer', 'answers' et 'question'.";

        $content = $client->chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                [
                    'content' => $content,
                    'role' => 'user'
                ]
            ]
        ])['choices'][0]['message']['content'];

        $quizData = json_decode($content, true);

        $quiz = $this->quizService->add($quizData);

        return $this->json([
            'quiz' => [
                'id' => $quiz->getId()
            ]
        ]);
    }
}
