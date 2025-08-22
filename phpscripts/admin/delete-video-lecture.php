<?php
session_start();
include("../database-connection.php");

$data = [];

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $video_lecture_id = mysqli_real_escape_string($con, $_POST['video_lecture_id']);

    if (empty($video_lecture_id)) {
        $data['status'] = "error";
        $data['message'] = "Invalid video lecture ID";
    } else {
        $delete_video_lecture_query = "DELETE FROM video_lectures WHERE video_lectures_id = '$video_lecture_id'";
        $delete_video_lecture_result = mysqli_query($con, $delete_video_lecture_query);

        if ($delete_video_lecture_result) {
            $data['status'] = "success";
            $data['message'] = "Video lecture deleted successfully";
        } else {
            $data['status'] = "error";
            $data['message'] = "Failed to delete the video lecture. Please try again later.";
        }
    }
} else {
    $data['status'] = "error";
    $data['message'] = "Invalid request method. Please try again later.";
}

echo json_encode($data);
?>