<?php
session_start();
include("../database-connection.php");

$data = [];

$fetch_quizzes_query = "
    SELECT 
        l.lesson_id AS lessonId, 
        l.lesson_title AS Topic, 
        l.week_number AS WeekNumber, 
        COUNT(qq.question_id) AS TotalQuestions, 
        qq.quiz_id AS quizId, 
        GROUP_CONCAT(DISTINCT qq.question_type SEPARATOR ', ') AS QuestionTypes, 
        l.datetime_created AS DateTimeCreated
    FROM lessons l
    LEFT JOIN quizzes q ON l.lesson_id = q.lesson_id
    LEFT JOIN quiz_questions qq ON q.quiz_id = qq.quiz_id
    GROUP BY l.lesson_id
    ORDER BY l.week_number ASC, l.datetime_created ASC;
";

$fetch_quizzes_result = mysqli_query($con, $fetch_quizzes_query);

if ($fetch_quizzes_result) {
    $topics = [];
    while ($row = mysqli_fetch_assoc($fetch_quizzes_result)) {
        $topics[] = $row;
    }
    $data['status'] = 'success';
    $data['topics'] = $topics;
} else {
    $data['status'] = 'error';
    $data['message'] = 'Failed to fetch data.';
}

echo json_encode($data);
?>