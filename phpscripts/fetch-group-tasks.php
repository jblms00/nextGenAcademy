<?php
session_start();
include("database-connection.php");

$data = [];
$groupId = isset($_GET['group_id']) ? intval($_GET['group_id']) : 0;

if ($groupId > 0) {
    // Fetch group members
    $sqlMembers = "
        SELECT 
            gm.user_id AS member_id, 
            ua.user_name 
        FROM 
            group_members gm
        LEFT JOIN 
            users_accounts ua ON gm.user_id = ua.user_id
        WHERE 
            gm.group_id = $groupId
    ";

    $resultMembers = mysqli_query($con, $sqlMembers);
    $members = [];

    if ($resultMembers) {
        while ($row = mysqli_fetch_assoc($resultMembers)) {
            $members[] = $row['user_name'];
        }
    }

    // Fetch group tasks
    $sqlTasks = "
        SELECT 
            task_id, 
            task_title, 
            task_status 
        FROM 
            group_tasks 
        WHERE 
            group_id = $groupId
    ";

    $resultTasks = mysqli_query($con, $sqlTasks);
    $tasks = [];

    if ($resultTasks) {
        while ($row = mysqli_fetch_assoc($resultTasks)) {
            $tasks[] = [
                'task_id' => $row['task_id'],
                'task_title' => $row['task_title'],
                'task_status' => $row['task_status']
            ];
        }
    }

    $data['status'] = 'success';
    $data['members'] = $members;
    $data['tasks'] = $tasks;
} else {
    $data['status'] = 'error';
    $data['message'] = 'Invalid group ID.';
}

echo json_encode($data);
?>