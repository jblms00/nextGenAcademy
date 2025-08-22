<?php
session_start();
include("../database-connection.php");

$data = [];

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $lesson_id = mysqli_real_escape_string($con, $_POST['lesson_id']);

    if (empty($lesson_id)) {
        $data['status'] = "error";
        $data['message'] = "Invalid lesson ID";
    } else {

        $delete_lesson_query = "DELETE FROM lessons WHERE lesson_id = '$lesson_id'";
        $delete_lesson_result = mysqli_query($con, $delete_lesson_query);

        if ($delete_lesson_result) {
            $data['status'] = "success";
            $data['message'] = "Lesson deleted successfully";
        } else {
            $data['status'] = "error";
            $data['message'] = "Failed to delete the lesson. Please try again later.";
        }
    }
} else {
    $data['status'] = "error";
    $data['message'] = "Invalid request method. Please try again later.";
}

echo json_encode($data);
?>