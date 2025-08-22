<?php
session_start();
include("../database-connection.php");

$data = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['user_id']) && isset($_POST['group_id'])) {
    $userId = mysqli_real_escape_string($con, $_POST['user_id']);
    $groupId = mysqli_real_escape_string($con, $_POST['group_id']);

    $query = "DELETE FROM group_members WHERE user_id = '$userId' AND group_id = '$groupId'";
    $result = mysqli_query($con, $query);

    if ($result) {
        if (mysqli_affected_rows($con) > 0) {
            $data['status'] = "success";
            $data['message'] = "Member removed successfully.";
        } else {
            $data['status'] = "error";
            $data['message'] = "No member found with the provided ID.";
        }
    } else {
        $data['status'] = "error";
        $data['message'] = "Failed to remove member. Please try again later.";
    }
} else {
    $data['status'] = "error";
    $data['message'] = "Invalid request. Please try again later.";
}

echo json_encode($data);
?>