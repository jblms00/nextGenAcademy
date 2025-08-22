<?php
session_start();

include("database-connection.php");

$data = [];

if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['video_lectures_id'])) {
    $videoLecturesId = mysqli_real_escape_string($con, $_GET['video_lectures_id']);


    $get_messages_query = "
        SELECT lm.lecture_message_id, lm.user_id, lm.message_content, lm.datetime_created,
               ua.user_name, ua.user_photo 
        FROM lecture_messages lm
        LEFT JOIN users_accounts ua ON lm.user_id = ua.user_id
        WHERE lm.video_lectures_id = '$videoLecturesId'
        ORDER BY lm.datetime_created ASC
    ";

    $get_messages_result = mysqli_query($con, $get_messages_query);

    if ($get_messages_result) {
        $messages = [];

        while ($message = mysqli_fetch_assoc($get_messages_result)) {
            $messages[] = [
                'lecture_message_id' => $message['lecture_message_id'],
                'user_id' => $message['user_id'],
                'message_content' => $message['message_content'],
                'user_name' => $message['user_name'],
                'user_photo' => $message['user_photo'],
                'datetime_created' => $message['datetime_created']
            ];
        }

        $data['status'] = "success";
        $data['messages'] = $messages;
    } else {
        $data['status'] = "error";
        $data['message'] = "Error fetching messages: " . mysqli_error($con);
    }
} else {
    $data['status'] = "error";
    $data['message'] = "Invalid request.";
}

echo json_encode($data);
