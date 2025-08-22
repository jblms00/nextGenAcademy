<?php
session_start();
include("../database-connection.php");

$data = [];

if (isset($_GET['weekNumber']) && isset($_GET['lessonId'])) {
    $weekNumber = mysqli_real_escape_string($con, $_GET['weekNumber']);
    $lessonId = mysqli_real_escape_string($con, $_GET['lessonId']);

    $fetch_query = "
        SELECT qa.attempt_id, qa.quiz_id, qa.score, qa.total_questions, qa.datetime_created,
            ua.user_name, ua.user_email
        FROM quiz_attempts qa
        JOIN users_accounts ua ON qa.user_id = ua.user_id
        JOIN quizzes q ON qa.quiz_id = q.quiz_id
        JOIN lessons l ON q.lesson_id = l.lesson_id
        WHERE l.week_number = '$weekNumber' AND l.lesson_id = '$lessonId'
    ";

    $fetch_result = mysqli_query($con, $fetch_query);

    if ($fetch_result) {
        $quizResults = [];
        while ($row = mysqli_fetch_assoc($fetch_result)) {
            $quizResults[] = $row;
        }
        $data['status'] = 'success';
        $data['quizResults'] = $quizResults;
    } else {
        $data['status'] = 'error';
        $data['message'] = 'Failed to fetch data.';
    }
} else {
    $data['status'] = 'error';
    $data['message'] = 'Week number and lesson ID are required.';
}

echo json_encode($data);