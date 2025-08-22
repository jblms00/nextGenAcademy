<?php
session_start();
include("database-connection.php");

$data = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['task_id']) && isset($_POST['status'])) {
        $taskId = mysqli_real_escape_string($con, $_POST['task_id']);
        $newStatus = mysqli_real_escape_string($con, $_POST['status']);

        $update_task_query = "UPDATE group_tasks SET task_status = '$newStatus' WHERE task_id = '$taskId'";
        $update_task_result = mysqli_query($con, $update_task_query);

        if ($update_task_result) {
            $data['status'] = 'success';
            $data['message'] = 'Task status updated successfully.';
        } else {
            $data['status'] = 'error';
            $data['message'] = 'Error updating task status: ' . mysqli_error($con);
        }
    } else {
        $data['status'] = 'error';
        $data['message'] = 'Task ID and status are required.';
    }
} else {
    $data['status'] = 'error';
    $data['message'] = 'Invalid request method.';
}

echo json_encode($data);
?>