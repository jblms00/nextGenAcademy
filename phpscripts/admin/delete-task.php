<?php
session_start();
include("../database-connection.php");

$data = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $task_id = isset($_POST['task_id']) ? mysqli_real_escape_string($con, $_POST['task_id']) : '';

    if (empty($task_id)) {
        $data['status'] = 'error';
        $data['message'] = 'Task ID is required.';
    } else {
        $delete_task_query = "DELETE FROM group_tasks WHERE task_id = '$task_id'";

        if (mysqli_query($con, $delete_task_query)) {
            $data['status'] = 'success';
            $data['message'] = 'Task removed successfully.';
        } else {
            $data['status'] = 'error';
            $data['message'] = 'Failed to remove task: ' . mysqli_error($con);
        }
    }
} else {
    $data['status'] = 'error';
    $data['message'] = 'Invalid request method.';
}

echo json_encode($data);
?>