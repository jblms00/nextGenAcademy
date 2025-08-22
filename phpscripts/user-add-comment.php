<?php
session_start();
include("database-connection.php");

$data = [];

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $forum_id = mysqli_real_escape_string($con, $_POST['forum_id']);
    $comment_text = mysqli_real_escape_string($con, $_POST['comment_text']);
    $user_id = mysqli_real_escape_string($con, $_POST['user_id']);

    if (empty($comment_text)) {
        $data['status'] = "error";
        $data['message'] = "Comment cannot be empty.";
    } else {
        $comment_id = random_int(1000000, 9999999);

        $insert_comment_query = "INSERT INTO forum_comments (comment_id, forum_id, user_id, comment, datetime_created) 
                                 VALUES ('$comment_id', '$forum_id', '$user_id', '$comment_text', NOW())";

        if (mysqli_query($con, $insert_comment_query)) {
            $data['comment_id'] = $comment_id;
            $data['status'] = "success";
            $data['message'] = "Comment posted successfully.";
        } else {
            $data['status'] = "error";
            $data['message'] = "Failed to post the comment.";
        }
    }
}

echo json_encode($data);
?>