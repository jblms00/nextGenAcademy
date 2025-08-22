<?php
session_start();
include("database-connection.php");

$data = [];

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $model_id = mysqli_real_escape_string($con, $_POST['model_id']);
    $comment_text = mysqli_real_escape_string($con, $_POST['comment_text']);
    $user_id = mysqli_real_escape_string($con, $_POST['user_id']);

    if (empty($comment_text)) {
        $data['status'] = "error";
        $data['message'] = "Comment cannot be empty.";
    } else {
        $model_comment_id = random_int(1000000, 9999999);

        $insert_comment_query = "INSERT INTO model_comments (model_comment_id, model_id, user_id, comment, datetime_created) 
                                 VALUES ('$model_comment_id', '$model_id', '$user_id', '$comment_text', NOW())";

        if (mysqli_query($con, $insert_comment_query)) {
            $data['model_comment_id'] = $model_comment_id;
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