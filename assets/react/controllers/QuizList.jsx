import React from "react";
import {Chip, Container, Stack} from "@mui/material";

export default function QuizList(props) {
    const quizzes = JSON.parse(props.quizzes);

    const handleClick = (id) => {
        window.location.href = `/quizzes/${id}`;
    }

    return (
        <Container maxWidth="sm">
            <Stack direction="row" spacing={2} style={{ justifyContent: 'center' }}>
                {quizzes.map((quiz) =>
                    <Chip color="primary" key={quiz.id} label={quiz.title} onClick={() => handleClick(quiz.id)} />
                )}
            </Stack>
        </Container>
    )
}