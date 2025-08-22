<?php
session_start();
include("database-connection.php");

$data = [];
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['conversation_id'], $_POST['sender_id'], $_POST['content'])) {
    $conversation_id = mysqli_real_escape_string($con, $_POST['conversation_id']);
    $sender_id = mysqli_real_escape_string($con, $_POST['sender_id']);
    $content = trim($_POST['content']);

    if (empty($content)) {
        $data['status'] = "error";
        $data['message'] = "Message content cannot be empty.";
        echo json_encode($data);
        exit;
    }

    $conversation_query = "SELECT conversation_id FROM conversations WHERE conversation_id = '$conversation_id'";
    $conversation_result = mysqli_query($con, $conversation_query);

    if (mysqli_num_rows($conversation_result) === 0) {
        $data['status'] = "error";
        $data['message'] = "Conversation not found.";
        echo json_encode($data);
        exit;
    }

    $user_query = "SELECT user_id FROM users_accounts WHERE user_id = '$sender_id'";
    $user_result = mysqli_query($con, $user_query);

    if (mysqli_num_rows($user_result) === 0) {
        $data['status'] = "error";
        $data['message'] = "Sender not found.";
        echo json_encode($data);
        exit;
    }

    $query = "INSERT INTO messages (conversation_id, sender_id, content, created_at, is_read)
              VALUES ('$conversation_id', '$sender_id', '$content', NOW(), 0)";

    if (mysqli_query($con, $query)) {
        $data['status'] = "success";
        $data['message'] = "Message sent successfully.";
    } else {
        $data['status'] = "error";
        $data['message'] = "Failed to send message.";
    }
} else {
    $data['status'] = "error";
    $data['message'] = "Incomplete message data.";
}

echo json_encode($data);
?>