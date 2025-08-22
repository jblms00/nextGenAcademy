<?php
session_start();
include("database-connection.php");

$data = [];

$userId = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
$quizId = isset($_POST['quiz_id']) ? intval($_POST['quiz_id']) : 0;

$data['userId'] = $userId;

$score = 0;
$totalQuestions = 0;

if ($quizId > 0) {
    $questions_query = "SELECT question_id, correct_answer FROM quiz_questions WHERE quiz_id = $quizId";
    $questions_result = mysqli_query($con, $questions_query);

    if ($questions_result) {
        $totalQuestions = mysqli_num_rows($questions_result);

        while ($row = mysqli_fetch_assoc($questions_result)) {
            $questionId = $row['question_id'];
            $correctAnswer = $row['correct_answer'];
            $userAnswer = isset($_POST["question_$questionId"]) ? $_POST["question_$questionId"] : null;

            if ($userAnswer === $correctAnswer) {
                $score++;
            }
        }

        $insert_query = "INSERT INTO quiz_attempts (quiz_id, user_id, score, total_questions, datetime_created)
                         VALUES ($quizId, $userId, $score, $totalQuestions, NOW())
                         ON DUPLICATE KEY UPDATE score = $score, total_questions = $totalQuestions, datetime_updated = NOW()";

        if (mysqli_query($con, $insert_query)) {
            $data['status'] = 'success';
            $data['score'] = $score;
            $data['total_questions'] = $totalQuestions;
        } else {
            $data['status'] = 'error';
            $data['message'] = 'Failed to save the quiz results.';
        }
    } else {
        $data['status'] = 'error';
        $data['message'] = 'Failed to fetch quiz questions.';
    }
} else {
    $data['status'] = 'error';
    $data['message'] = 'Invalid quiz ID.';
}

echo json_encode($data);
?>