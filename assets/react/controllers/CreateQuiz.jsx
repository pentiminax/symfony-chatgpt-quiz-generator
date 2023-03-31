import React from 'react';
import {Button, Card, CircularProgress, Container, Grid, TextField, Typography} from "@mui/material";

export default function CreateQuiz () {
    const [generating, setGenerating] = React.useState(false);

    const handleSubmit = async (e) => {
        e.preventDefault();

        const formData = new FormData(e.target);
        const content = formData.get('content');

        if(0 === content.trim().length) {
            return;
        }

        setGenerating(true);

        const response = await fetch('/quizzes', {
            body: JSON.stringify({ content: content }),
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const json = await response.json();

        setGenerating(false);

        window.location.href = `/quizzes/${json.quiz.id}`;
    }

    return (
        <Container maxWidth="sm">
            <Grid container
                  direction="row"
                  justifyContent="center"
                  alignItems="center">
                <Grid item>
                    <Typography fontWeight="bold" component="h2" variant="h2" textAlign="center" marginY={5}>
                        Make My Quiz
                    </Typography>
                </Grid>
                <Grid item>
                    <Card style={{ padding: 15 }} variant="outlined">
                        <form onSubmit={handleSubmit}>
                            <TextField fullWidth label="Générer un quiz"  name="content" />
                            <Button disabled={generating} fullWidth style={{ marginTop: 20 }} type="submit" variant="contained">
                                { generating
                                    ? <CircularProgress color="secondary" />
                                    : 'Générer'
                                }
                            </Button>
                        </form>
                    </Card>
                </Grid>
            </Grid>
        </Container>
    );
}