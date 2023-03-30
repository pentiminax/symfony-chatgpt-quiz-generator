import React from 'react';
import {Card, CardContent, FormControl, FormControlLabel, Radio, RadioGroup, Typography} from "@mui/material";

export default function Question(props) {
    return (
        <Card variant="outlined" sx={{ minWidth: 275 }}>
            <CardContent>
                <Typography fontWeight="bold"
                            component="div"
                            gutterBottom
                            variant="h5"
                            textAlign="center">{props.question.title}</Typography>

                <FormControl>
                    <RadioGroup name="answer">
                        {props.question.answers.map(answer => (
                            <FormControlLabel control={<Radio/>} key={answer.id} label={answer.title} value={answer.id} />
                        ))}
                    </RadioGroup>
                </FormControl>
            </CardContent>
        </Card>
    );
}