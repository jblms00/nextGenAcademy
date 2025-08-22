<?php
session_start();
include("database-connection.php");

$data = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['comment_id']) && isset($_POST['comment_text']) && isset($_POST['logged_in_user_id'])) {
        $loggedInUserId = mysqli_real_escape_string($con, $_POST['logged_in_user_id']);
        $commentId = mysqli_real_escape_string($con, $_POST['comment_id']);
        $newCommentText = mysqli_real_escape_string($con, $_POST['comment_text']);

        $edit_comment_query = "UPDATE forum_comments SET comment = '$newCommentText' WHERE comment_id = '$commentId' AND user_id = '$loggedInUserId'";
        $edit_comment_result = mysqli_query($con, $edit_comment_query);

        if ($edit_comment_result) {
            $data['status'] = 'success';
            $data['message'] = 'Comment updated successfully.';
        } else {
            $data['status'] = 'error';
            $data['message'] = 'Error updating comment: ' . mysqli_error($con);
        }
    } else {
        $data['status'] = 'error';
        $data['message'] = 'Comment ID and text are required.';
    }
} else {
    $data['status'] = 'error';
    $data['message'] = 'Invalid request method.';
}

echo json_encode($data);
?>