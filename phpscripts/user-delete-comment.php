<?php
session_start();
include("database-connection.php");

$data = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['comment_id']) && isset($_POST['logged_in_user_id'])) {
        $loggedInUserId = mysqli_real_escape_string($con, $_POST['logged_in_user_id']);
        $commentId = mysqli_real_escape_string($con, $_POST['comment_id']);

        $delete_comment_query = "DELETE FROM forum_comments WHERE comment_id = '$commentId' AND user_id = '$loggedInUserId'";
        $delete_comment_result = mysqli_query($con, $delete_comment_query);

        if ($delete_comment_result) {
            $data['status'] = 'success';
            $data['message'] = 'Comment deleted successfully.';
        } else {
            $data['status'] = 'error';
            $data['message'] = 'Error deleting comment: ' . mysqli_error($con);
        }
    } else {
        $data['status'] = 'error';
        $data['message'] = 'Comment ID is required.';
    }
} else {
    $data['status'] = 'error';
    $data['message'] = 'Invalid request method.';
}

echo json_encode($data);
?>