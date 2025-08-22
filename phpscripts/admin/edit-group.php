<?php
session_start();
include("../database-connection.php");

$data = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['groupId'])) {
    $groupId = mysqli_real_escape_string($con, $_POST['groupId']);
    $lessonId = mysqli_real_escape_string($con, $_POST['lesson_id']);
    $projectTitle = mysqli_real_escape_string($con, $_POST['project_title']);

    $checkGroupQuery = "SELECT group_id FROM lesson_group_collaborators WHERE group_id = '$groupId'";
    $groupCheckResult = mysqli_query($con, $checkGroupQuery);

    if (mysqli_num_rows($groupCheckResult) == 0) {
        $data['status'] = "error";
        $data['message'] = "Group ID does not exist.";
        echo json_encode($data);
        exit;
    }

    $query = "UPDATE lesson_group_collaborators SET lesson_id = '$lessonId', project_title = '$projectTitle' WHERE group_id = '$groupId'";
    $result = mysqli_query($con, $query);

    if ($result) {
        $data['status'] = "success";
        $data['message'] = "Group updated successfully.";
    } else {
        $data['status'] = "error";
        $data['message'] = "Failed to update group. Please try again later.";
    }

} else {
    $data['status'] = "error";
    $data['message'] = "Invalid request. Please try again later.";
}

echo json_encode($data);
