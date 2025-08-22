<?php
session_start();
include("database-connection.php");

$data = [];
$lessonId = isset($_GET['lesson_id']) ? intval($_GET['lesson_id']) : 0;
$userId = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;

if ($lessonId > 0) {
    // Fetch quizzes associated with the lesson
    $fetch_quizzes_query = "
        SELECT q.quiz_id, q.lesson_id, l.lesson_title, COUNT(qq.question_id) AS total_questions
        FROM quizzes q
        LEFT JOIN quiz_questions qq ON q.quiz_id = qq.quiz_id
        LEFT JOIN lessons l ON q.lesson_id = l.lesson_id
        WHERE q.lesson_id = $lessonId
        GROUP BY q.quiz_id
        ORDER BY q.quiz_id ASC
    ";

    $fetch_quizzes_result = mysqli_query($con, $fetch_quizzes_query);

    if ($fetch_quizzes_result) {
        if (mysqli_num_rows($fetch_quizzes_result) > 0) {
            $quizzes = [];
            while ($row = mysqli_fetch_assoc($fetch_quizzes_result)) {
                $quizId = $row['quiz_id'];

                $score_query = "SELECT score FROM quiz_attempts WHERE quiz_id = $quizId AND user_id = $userId";
                $score_result = mysqli_query($con, $score_query);
                $userScore = mysqli_fetch_assoc($score_result);

                $row['score'] = $userScore ? $userScore['score'] : null;
                $row['total_questions'] = $row['total_questions'];
                $quizzes[] = $row;
            }
            $data['status'] = 'success';
            $data['quizzes'] = $quizzes;
        } else {
            $data['status'] = 'error';
            $data['message'] = 'No quizzes found for this lesson.';
        }
    } else {
        $data['status'] = 'error';
        $data['message'] = 'Failed to execute query.';
    }
} else {
    $data['status'] = 'error';
    $data['message'] = 'Invalid lesson ID.';
}

echo json_encode($data);
?>