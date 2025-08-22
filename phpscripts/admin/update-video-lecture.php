<?php
session_start();
include("../database-connection.php");

$data = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $videoLectureId = mysqli_real_escape_string($con, $_POST['video_lecture_id']);
    $weekNumber = mysqli_real_escape_string($con, $_POST['week_number']);
    $videoUrl = mysqli_real_escape_string($con, $_POST['video_url']);

    if (empty($videoLectureId) || empty($weekNumber) || empty($videoUrl)) {
        $data['status'] = 'error';
        $data['message'] = 'All fields are required';
    } else {
        $query = "UPDATE video_lectures SET week_number = '$weekNumber', video_url = '$videoUrl' WHERE video_lectures_id = '$videoLectureId'";
        $result = mysqli_query($con, $query);

        if ($result) {
            $data['status'] = "success";
            $data['message'] = "Video lecture updated successfully.";
        } else {
            $data['status'] = "error";
            $data['message'] = "Failed to update video lecture. Please try again later.";
        }
    }

} else {
    $data['status'] = "error";
    $data['message'] = "Invalid request. Please try again later.";
}

echo json_encode($data);
?>