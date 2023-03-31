import React from 'react';
import {
    Button,
    Chip,
    Container,
    Paper,
    Table,
    TableBody,
    TableCell,
    TableContainer,
    TableHead,
    TableRow,
    Typography
} from "@mui/material";

export default function QuizResult(props) {
    const quizResult = JSON.parse(props.quizResult);

    const getAnswerTitle = (result) => {
        return quizResult.quiz.questions
            .find(x => x.id === result.questionId).answers
            .find(x => x.id === result.answerId).title;
    }

    const getQuestionTitle = (questionId) => {
        return quizResult.quiz.questions.find(x => x.id === questionId).title;
    }

    const isCorrect = (result) => {
        const question = quizResult.quiz.questions.find(x => x.id === result.questionId);
        const answer = question.answers.find(x => x.id === result.answerId);

        return answer.isCorrect;
    }

    return (
        <Container>
            <Typography fontWeight="bold"
                        component="div"
                        gutterBottom
                        variant="h5"
                        textAlign="center">Résultats du quiz - {quizResult.quiz.title}</Typography>
            <TableContainer component={Paper}>
                <Table>
                    <TableHead>
                        <TableRow>
                            <TableCell>Question</TableCell>
                            <TableCell>Réponse</TableCell>
                            <TableCell>État</TableCell>
                        </TableRow>
                    </TableHead>
                    <TableBody>
                        {quizResult.results.map(result => (
                            <TableRow key={result.questionId}>
                                <TableCell>{getQuestionTitle(result.questionId)}</TableCell>
                                <TableCell>{getAnswerTitle(result)}</TableCell>
                                <TableCell>
                                    <Chip color={isCorrect(result) ? "success" : "error"} label={isCorrect(result) ? 'Bonne réponse' : 'Mauvaise réponse'} />
                                </TableCell>
                            </TableRow>
                        ))}
                    </TableBody>
                </Table>
            </TableContainer>
            <div style={{ marginTop: 10, textAlign: "center" }}>
                <Button onClick={() => window.location.href = '/'} variant="contained">Retour à la page d'accueil</Button>
            </div>
        </Container>
    )
}