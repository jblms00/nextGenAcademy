<?php
session_start();
include("../database-connection.php");

$data = [];

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $fetch_tasks_query = "
        SELECT group_id, task_status, COUNT(*) as task_count 
        FROM group_tasks 
        GROUP BY group_id, task_status";
    $fetch_tasks_result = mysqli_query($con, $fetch_tasks_query);

    if ($fetch_tasks_result) {
        $tasks = [];
        while ($row = mysqli_fetch_assoc($fetch_tasks_result)) {
            $group_id = $row['group_id'];
            $status = $row['task_status'];

            // Initialize group if not exists
            if (!isset($tasks[$group_id])) {
                $tasks[$group_id] = [
                    'pending' => 0,
                    'inProgress' => 0,
                    'completed' => 0,
                ];
            }

            // Increment the count based on status
            if ($status === "Pending") {
                $tasks[$group_id]['pending'] += $row['task_count'];
            } elseif ($status === "In Progress") {
                $tasks[$group_id]['inProgress'] += $row['task_count'];
            } elseif ($status === "Completed") {
                $tasks[$group_id]['completed'] += $row['task_count'];
            }
        }

        $data['status'] = 'success';
        $data['tasks'] = $tasks;
    } else {
        $data['status'] = 'error';
        $data['message'] = 'Failed to fetch tasks: ' . mysqli_error($con);
    }
} else {
    $data['status'] = 'error';
    $data['message'] = 'Invalid request method.';
}

echo json_encode($data);
?>