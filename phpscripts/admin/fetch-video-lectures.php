<?php
session_start();

include("../database-connection.php");

$data = [];

$fetch_video_lectures_query = "SELECT * FROM video_lectures ORDER BY week_number ASC";
$fetch_video_lectures_result = mysqli_query($con, $fetch_video_lectures_query);

if ($fetch_video_lectures_result) {
    $video_lectures = [];
    while ($row = mysqli_fetch_assoc($fetch_video_lectures_result)) {
        $video_lectures[] = $row;
    }
    $data['status'] = 'success';
    $data['video_lectures'] = $video_lectures;
} else {
    $data['status'] = 'error';
    $data['message'] = 'Failed to fetch video lectures.';
}

echo json_encode($data);
?>