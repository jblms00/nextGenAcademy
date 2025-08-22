<?php
session_start();
include("../database-connection.php");


$data = [];

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['quizId'])) {
    $quizId = mysqli_real_escape_string($con, $_GET['quizId']);

    $fetch_questions_query = "SELECT * FROM quiz_questions WHERE quiz_id = '$quizId'";
    $fetch_questions_result = mysqli_query($con, $fetch_questions_query);

    if ($fetch_questions_result) {
        $questions = [];
        while ($row = mysqli_fetch_assoc($fetch_questions_result)) {
            $questions[] = $row;
        }
        $data['status'] = 'success';
        $data['questions'] = $questions;
    } else {
        $data['status'] = 'error';
        $data['message'] = 'Failed to fetch quiz questions.';
    }
} else {
    $data['status'] = "error";
    $data['message'] = "Invalid request. Please try again later";
}

echo json_encode($data);
?>