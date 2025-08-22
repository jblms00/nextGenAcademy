<?php
session_start();
include("../database-connection.php");

$data = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $lesson_id = mysqli_real_escape_string($con, $_POST['lesson_id']);
    $project_title = mysqli_real_escape_string($con, $_POST['project_title']);
    $selected_members = explode(',', $_POST['selected_members']);

    $new_group_id = random_int(100000, 999999);
    $query = "INSERT INTO lesson_group_collaborators (group_id, lesson_id, project_title, group_status, datetime_created) VALUES ('$new_group_id', '$lesson_id', '$project_title', 'active', NOW())";
    $result = mysqli_query($con, $query);

    if ($result) {
        foreach ($selected_members as $member_id) {
            $member_id = mysqli_real_escape_string($con, $member_id);
            $query = "INSERT INTO group_members (group_id, user_id, datetime_added) VALUES ('$new_group_id', '$member_id', NOW())";
            mysqli_query($con, $query);
        }

        $data['status'] = 'success';
        $data['message'] = 'Group created successfully.';
    } else {
        $data['status'] = 'error';
        $data['message'] = 'Failed to create group.';
    }
} else {
    $data['status'] = 'error';
    $data['message'] = 'Invalid request method.';
}

echo json_encode($data);
?>