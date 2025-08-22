<?php
session_start();
include("database-connection.php");

$data = [];

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $forum_title = mysqli_real_escape_string($con, $_POST['forumTitle']);
    $forum_description = mysqli_real_escape_string($con, $_POST['forumDescription']);
    $user_id = mysqli_real_escape_string($con, $_POST['user_id']);

    $uploaded_file_path = '';

    if (isset($_FILES['forumFile']) && $_FILES['forumFile']['error'] == 0) {
        $file_tmp = $_FILES['forumFile']['tmp_name'];
        $file_type = pathinfo($_FILES['forumFile']['name'], PATHINFO_EXTENSION);
        $date_time = date("Y-m-d-H-i-s");
        $new_file_name = "FORUM-$date_time.$file_type";
        $upload_dir = '../assets/uploadedFile/';

        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        $uploaded_file_path = $upload_dir . $new_file_name;

        if (!move_uploaded_file($file_tmp, $uploaded_file_path)) {
            $data['status'] = "error";
            $data['message'] = "Failed to upload file.";
            echo json_encode($data);
            exit();
        }
    }

    if (empty($forum_title) || empty($forum_description)) {
        $data['status'] = "error";
        $data['message'] = "All fields are required.";
    } else {
        $forum_id = random_int(1000000, 9999999);
        $insert_forum_query = "INSERT INTO forums (forum_id, user_id, forum_title,  forum_description, forum_file_upload, datetime_created) 
                                VALUES ('$forum_id', '$user_id', '$forum_title', '$forum_description', '$new_file_name', NOW())";

        if (mysqli_query($con, $insert_forum_query)) {
            $data['status'] = "success";
            $data['message'] = "Forum posted successfully!";
        } else {
            $data['status'] = "error";
            $data['message'] = "Failed to post forum: " . mysqli_error($con);
        }
    }
}

echo json_encode($data);
