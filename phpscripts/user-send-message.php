<?php
session_start();
include("database-connection.php");

$data = [];

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $videoLecturesId = mysqli_real_escape_string($con, $_POST['video_lectures_id']);
    $messageContent = mysqli_real_escape_string($con, $_POST['message_content']);
    $userId = mysqli_real_escape_string($con, $_POST['user_id']);

    $insert_message_query = "
        INSERT INTO lecture_messages (video_lectures_id, user_id, message_content, datetime_created)
        VALUES ('$videoLecturesId', '$userId', '$messageContent', NOW())
    ";

    if (mysqli_query($con, $insert_message_query)) {
        $data['status'] = "success";
    } else {
        $data['status'] = "error";
        $data['message'] = "Error sending message: " . mysqli_error($con);
    }
} else {
    $data['status'] = "error";
    $data['message'] = "Invalid request.";
}

echo json_encode($data);
?>