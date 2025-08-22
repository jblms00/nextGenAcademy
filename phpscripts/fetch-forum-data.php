<?php
session_start();
include("database-connection.php");

$data = [];
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $forum_id = mysqli_real_escape_string($con, $_GET['forum_id']);

    $forum_query = "SELECT f.forum_id, f.user_id, f.forum_title, f.forum_description, f.forum_file_upload, f.datetime_created, 
                           u.user_name, u.user_photo 
                    FROM forums f 
                    JOIN users_accounts u ON f.user_id = u.user_id 
                    WHERE f.forum_id = '$forum_id'";

    $result = mysqli_query($con, $forum_query);

    if (mysqli_num_rows($result) > 0) {
        $forum = mysqli_fetch_assoc($result);
        $data['status'] = "success";
        $data['forum'] = $forum;
    } else {
        $data['status'] = "error";
        $data['message'] = "Forum not found.";
    }
}

echo json_encode($data);
