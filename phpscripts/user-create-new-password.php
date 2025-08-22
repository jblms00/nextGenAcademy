<?php
session_start();

include("database-connection.php");

$data = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_password = $_POST['new_password'];
    $confirm_new_password = $_POST['confirm_new_password'];
    $user_id = $_POST['user_id'];

    if (empty($new_password) || empty($confirm_new_password)) {
        $data['status'] = "error";
        $data['message'] = "Please enter your new password";
    } else if ($new_password != $confirm_new_password) {
        $data['status'] = "error";
        $data['message'] = "Password does not match";
    } else {
        $hashed_password = base64_encode($new_password);

        $update_password_query = "UPDATE users_accounts SET user_password = '$hashed_password' WHERE user_id = '$user_id'";
        $update_password_result = mysqli_query($con, $update_password_query);

        $delete_log_query = "DELETE FROM user_reset_password_logs WHERE user_id = '$user_id'";
        $delete_log_result = mysqli_query($con, $delete_log_query);

        if ($update_password_result && $delete_log_result) {
            $data['status'] = "success";
            $data['message'] = "Password updated successfully";
        } else {
            $data['status'] = "error";
            $data['message'] = "Failed to update password";
        }
    }
} else {
    $data['status'] = "error";
    $data['message'] = "Invalid request method";
}

echo json_encode($data);
