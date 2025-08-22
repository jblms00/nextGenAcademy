<?php
session_start();
include("database-connection.php");

$data = [];
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $quiz_id = mysqli_real_escape_string($con, $_GET['quiz_id']);

    $quiz_query = "SELECT quiz_id, lesson_id FROM quizzes WHERE quiz_id = '$quiz_id'";
    $quiz_result = mysqli_query($con, $quiz_query);

    if (mysqli_num_rows($quiz_result) > 0) {
        $questions_query = "SELECT question_id, quiz_id, question_text, question_type, 
                                   choice_a, choice_b, choice_c, choice_d, correct_answer 
                            FROM quiz_questions 
                            WHERE quiz_id = '$quiz_id'";
        $questions_result = mysqli_query($con, $questions_query);

        if (mysqli_num_rows($questions_result) > 0) {
            $questions = [];
            while ($question = mysqli_fetch_assoc($questions_result)) {
                $questions[] = $question;
            }
            $data['status'] = "success";
            $data['data'] = $questions;
        } else {
            $data['status'] = "error";
            $data['message'] = "No questions found for this quiz.";
        }
    } else {
        $data['status'] = "error";
        $data['message'] = "Quiz not found.";
    }
}

echo json_encode($data);
?>