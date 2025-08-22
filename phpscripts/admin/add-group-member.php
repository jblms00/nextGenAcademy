<?php
session_start();
include("../database-connection.php");

$data = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['user_id']) && isset($_POST['group_id'])) {
    $userId = mysqli_real_escape_string($con, $_POST['user_id']);
    $groupId = mysqli_real_escape_string($con, $_POST['group_id']);

    $countQuery = "SELECT COUNT(*) AS member_count FROM group_members WHERE group_id = '$groupId'";
    $countResult = mysqli_query($con, $countQuery);
    $row = mysqli_fetch_assoc($countResult);

    if ($row['member_count'] >= 4) {
        $data['status'] = "error";
        $data['message'] = "Maximum number of members reached. Cannot add more members.";
    } else {
        $checkMemberQuery = "SELECT COUNT(*) AS member_exists FROM group_members WHERE user_id = '$userId' AND group_id = '$groupId'";
        $checkResult = mysqli_query($con, $checkMemberQuery);
        $checkRow = mysqli_fetch_assoc($checkResult);

        if ($checkRow['member_exists'] > 0) {
            $data['status'] = "error";
            $data['message'] = "This member is already part of the group.";
        } else {
            $query = "INSERT INTO group_members (user_id, group_id, datetime_added) VALUES ('$userId', '$groupId', NOW())";
            $result = mysqli_query($con, $query);

            if ($result) {
                $data['status'] = "success";
                $data['message'] = "Member added successfully.";
            } else {
                $data['status'] = "error";
                $data['message'] = "Failed to add member. Please try again later.";
            }
        }
    }
} else {
    $data['status'] = "error";
    $data['message'] = "Invalid request. Please try again later.";
}

echo json_encode($data);
?>