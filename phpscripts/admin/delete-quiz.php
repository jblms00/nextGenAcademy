<?php
session_start();
include("../database-connection.php");

$data = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['quiz_id'])) {
    $quizId = mysqli_real_escape_string($con, $_POST['quiz_id']);

    $query = "DELETE FROM quizzes WHERE quiz_id = '$quizId'";
    $result = mysqli_query($con, $query);

    if ($result) {
        if (mysqli_affected_rows($con) > 0) {
            $data['status'] = "success";
            $data['message'] = "Quiz deleted successfully.";
        } else {
            $data['status'] = "error";
            $data['message'] = "No quiz found with the provided ID.";
        }
    } else {
        $data['status'] = "error";
        $data['message'] = "Failed to delete. Please try again later.";
    }
} else {
    $data['status'] = "error";
    $data['message'] = "Invalid request. Please try again later.";
}

echo json_encode($data);
?>