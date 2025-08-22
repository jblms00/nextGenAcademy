<?php
session_start();

include("../database-connection.php");

$data = [];

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $week_number = mysqli_real_escape_string($con, $_POST['week_number']);
    $video_url = mysqli_real_escape_string($con, $_POST['video_url']);

    if (empty($week_number) || empty($video_url)) {
        $data['status'] = "error";
        $data['message'] = "All fields are required";
    } else {
        $video_lectures_id = random_int(100000, 999999);

        $insert_query = "INSERT INTO video_lectures (video_lectures_id, lesson_id, week_number, video_url, datetime_created) 
                            VALUES ('$video_lectures_id', '$week_number', '$week_number', '$video_url', NOW())";
        $insert_result = mysqli_query($con, $insert_query);

        if ($insert_result) {
            $data['status'] = "success";
            $data['message'] = "Video Lecture created successfully";
        } else {
            $data['status'] = "error";
            $data['message'] = "Database error: " . mysqli_error($con);
        }
    }
} else {
    $data['status'] = "error";
    $data['message'] = "Invalid request method. Please try again later.";
}

echo json_encode($data);
?>