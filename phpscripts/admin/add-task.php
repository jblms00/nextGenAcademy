<?php
session_start();
include("../database-connection.php");

$data = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $group_id = isset($_POST['group_id']) ? mysqli_real_escape_string($con, $_POST['group_id']) : '';
    $task_title = isset($_POST['task_title']) ? mysqli_real_escape_string($con, $_POST['task_title']) : '';
    $task_description = isset($_POST['task_description']) ? mysqli_real_escape_string($con, $_POST['task_description']) : '';

    if (empty($group_id)) {
        $data['status'] = 'error';
        $data['message'] = 'Group ID is required.';
    } elseif (empty($task_title)) {
        $data['status'] = 'error';
        $data['message'] = 'Task title is required.';
    } elseif (empty($task_description)) {
        $data['status'] = 'error';
        $data['message'] = 'Task description is required.';
    } else {
        $add_task_query = "INSERT INTO group_tasks (group_id, task_title, task_description, task_status, datetime_created) 
                           VALUES ('$group_id', '$task_title', '$task_description', 'pending', NOW())";

        if (mysqli_query($con, $add_task_query)) {
            $last_id = mysqli_insert_id($con);
            $task_query = "SELECT * FROM group_tasks WHERE task_id = $last_id";
            $result = mysqli_query($con, $task_query);
            $new_task = mysqli_fetch_assoc($result);

            $data['status'] = 'success';
            $data['message'] = 'Task added successfully.';
            $data['task'] = $new_task;
        } else {
            $data['status'] = 'error';
            $data['message'] = 'Failed to add task: ' . mysqli_error($con);
        }
    }
} else {
    $data['status'] = 'error';
    $data['message'] = 'Invalid request method.';
}

echo json_encode($data);
?>