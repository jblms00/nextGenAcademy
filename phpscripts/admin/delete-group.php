<?php
session_start();
include("../database-connection.php");

$data = [];

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $group_id = mysqli_real_escape_string($con, $_POST['group_id']);

    if (empty($group_id)) {
        $data['status'] = "error";
        $data['message'] = "Invalid group ID";
    } else {

        $delete_group_query = "DELETE FROM lesson_group_collaborators WHERE group_id = '$group_id'";
        $delete_group_result = mysqli_query($con, $delete_group_query);

        if ($delete_group_result) {
            $data['status'] = "success";
            $data['message'] = "Group deleted successfully";
        } else {
            $data['status'] = "error";
            $data['message'] = "Failed to delete the group. Please try again later.";
        }
    }
} else {
    $data['status'] = "error";
    $data['message'] = "Invalid request method. Please try again later.";
}

echo json_encode($data);
?>