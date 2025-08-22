<?php
session_start();
include("../database-connection.php");

$data = [];

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['group_id'])) {
    $groupId = mysqli_real_escape_string($con, $_GET['group_id']);

    $query = "SELECT lesson_id, project_title FROM lesson_group_collaborators WHERE group_id = '$groupId'";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $group = mysqli_fetch_assoc($result);

        $membersQuery = "
            SELECT gm.user_id, ua.user_name 
            FROM group_members gm 
            JOIN users_accounts ua ON gm.user_id = ua.user_id 
            WHERE gm.group_id = '$groupId'
        ";
        $membersResult = mysqli_query($con, $membersQuery);
        $members = [];

        while ($row = mysqli_fetch_assoc($membersResult)) {
            $members[] = [
                'user_id' => $row['user_id'],
                'user_name' => $row['user_name']
            ];
        }

        $data['status'] = "success";
        $data['group'] = [
            'lesson_id' => $group['lesson_id'],
            'project_title' => $group['project_title'],
            'members' => $members
        ];
    } else {
        $data['status'] = "error";
        $data['message'] = "Group not found.";
    }
} else {
    $data['status'] = "error";
    $data['message'] = "Invalid request.";
}

echo json_encode($data);
?>