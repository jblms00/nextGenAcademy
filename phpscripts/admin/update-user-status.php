<?php
session_start();
include("../database-connection.php");
include("../check-login.php");
$user_data = check_login($con);
$loggedInUser = $user_data['user_id'];

$data = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['userId']) && isset($_POST['status'])) {
    $userId = mysqli_real_escape_string($con, $_POST['userId']);
    $newStatus = mysqli_real_escape_string($con, $_POST['status']);

    if ($userId == $loggedInUser) {
        $data['status'] = "error";
        $data['message'] = "You cannot update your own status.";
    } else {
        if ($newStatus === 'active' || $newStatus === 'inactive') {
            $query = "UPDATE users_accounts SET user_status = '$newStatus' WHERE user_id = '$userId'";
            $result = mysqli_query($con, $query);

            if ($result) {
                $data['status'] = "success";
                $data['message'] = "User status updated successfully.";
            } else {
                $data['status'] = "error";
                $data['message'] = "Failed to update user status. Please try again later.";
            }
        } else {
            $data['status'] = "error";
            $data['message'] = "Invalid status value Please try again later.";
        }
    }

} else {
    $data['status'] = "error";
    $data['message'] = "Invalid request. Please try again later.";
}

echo json_encode($data);
?>