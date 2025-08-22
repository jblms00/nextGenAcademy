<?php
session_start();
include("database-connection.php");

$data = [];
if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['conversation_id'])) {
    $conversation_id = mysqli_real_escape_string($con, $_GET['conversation_id']);

    $query = "SELECT m.sender_id, m.message_id, m.content, m.created_at, u.user_name, u.user_photo 
              FROM messages m
              JOIN users_accounts u ON m.sender_id = u.user_id
              WHERE m.conversation_id = '$conversation_id'
              ORDER BY m.created_at DESC";

    $result = mysqli_query($con, $query);

    if ($result) {
        $messages = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $messages[] = [
                'message_id' => $row['message_id'],
                'content' => $row['content'],
                'created_at' => $row['created_at'],
                'sender_id' => $row['sender_id'],
                'sender_name' => $row['user_name'],
                'sender_photo' => $row['user_photo'],
            ];
        }
        $data['status'] = "success";
        $data['messages'] = $messages;
    } else {
        $data['status'] = "error";
        $data['message'] = "Failed to retrieve messages.";
    }
} else {
    $data['status'] = "error";
    $data['message'] = "No conversation specified.";
}

echo json_encode($data);
?>