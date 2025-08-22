<?php
session_start();
include("../database-connection.php");
$data = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $questions = json_decode($_POST['questions'], true);
    $quizId = $_POST['quiz_id'];

    foreach ($questions as $question) {
        $questionId = mysqli_real_escape_string($con, $question['question_id']);
        $questionText = mysqli_real_escape_string($con, $question['question_text']);
        $correctAnswer = mysqli_real_escape_string($con, $question['correct_answer']);

        $choiceA = mysqli_real_escape_string($con, $question['choices'][0] ?? '');
        $choiceB = mysqli_real_escape_string($con, $question['choices'][1] ?? '');
        $choiceC = mysqli_real_escape_string($con, $question['choices'][2] ?? '');
        $choiceD = mysqli_real_escape_string($con, $question['choices'][3] ?? '');

        $datetimeCreated = date('Y-m-d H:i:s');
        $datetimeUpdated = date('Y-m-d H:i:s');

        // Update question text
        $updateQuestionQuery = "
            UPDATE `quiz_questions` 
            SET 
                `question_id`='$questionId',
                `quiz_id`='$quizId',
                `question_text`='$questionText',
                `choice_a`='$choiceA',
                `choice_b`='$choiceB',
                `choice_c`='$choiceC',
                `choice_d`='$choiceD',
                `correct_answer`='$correctAnswer',
                `datetime_created`='$datetimeCreated',
                `datetime_updated`='$datetimeUpdated'
            WHERE `question_id`='$questionId' AND `quiz_id`='$quizId'
        ";

        if (!mysqli_query($con, $updateQuestionQuery)) {
            $data['status'] = 'error';
            $data['message'] = 'Error updating question: ' . mysqli_error($con);
            echo json_encode($data);
            exit();
        }
    }

    $data['status'] = 'success';
    $data['message'] = 'Quiz questions updated successfully.';
}

echo json_encode($data);
?>