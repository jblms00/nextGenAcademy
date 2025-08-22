<?php
session_start();
include '../database-connection.php';

$data = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve quiz title and questions from the POST request
    $lessonId = mysqli_real_escape_string($con, $_POST['quiz_title']);
    $questions = json_decode($_POST['questions'], true);

    if (empty($lessonId) || empty($questions)) {
        $data['message'] = 'Quiz title and questions are required.';
        echo json_encode($data);
        exit;
    }

    $get_quiz_id_query = "SELECT quiz_id FROM quizzes WHERE lesson_id = '$lessonId'";
    if ($get_quiz_id_result = mysqli_query($con, $get_quiz_id_query)) {
        $fetchId = mysqli_fetch_assoc($get_quiz_id_result);
        $quizId = $fetchId['quiz_id'];

        foreach ($questions as $question) {
            $questionText = mysqli_real_escape_string($con, $question['question_text']);
            $correctAnswer = mysqli_real_escape_string($con, $question['correct_answer']);
            $choices = $question['choices'];

            if (count($choices) !== 4) {
                $data['message'] = 'Each question must have exactly 4 choices.';
                echo json_encode($data);
                exit;
            }

            $choiceA = mysqli_real_escape_string($con, $choices[0]);
            $choiceB = mysqli_real_escape_string($con, $choices[1]);
            $choiceC = mysqli_real_escape_string($con, $choices[2]);
            $choiceD = mysqli_real_escape_string($con, $choices[3]);

            $insertQuestionQuery = "INSERT INTO quiz_questions (quiz_id, question_text, choice_a, choice_b, choice_c, choice_d, correct_answer, datetime_created)
                                    VALUES ('$quizId', '$questionText', '$choiceA', '$choiceB', '$choiceC', '$choiceD', '$correctAnswer', NOW())";

            if (!mysqli_query($con, $insertQuestionQuery)) {
                $data['message'] = 'Error inserting questions: ' . mysqli_error($con);
                echo json_encode($data);
                exit;
            }
        }

        $data['status'] = 'success';
        $data['message'] = 'Quiz created successfully.';
    } else {
        $data['status'] = "error";
        $data['message'] = "Lesson Id is missing.";
    }
} else {
    $data['status'] = "error";
    $data['message'] = "Invalid request method. Please try again later.";
}

echo json_encode($data);
