<?php
session_start();

include("database-connection.php");
include("check-login.php");

$user_data = check_login($con);
$logged_in_user = $user_data['user_id'];
$current_password = base64_decode($user_data['user_password']);

$data = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_password = $_POST['new_password'];
    $verification_code = $_POST['verification_code'];

    if (empty($verification_code)) {
        $data['status'] = "error";
        $data['message'] = "Please enter the verification code sent to your email";
    } else {
        $confirm_code_query = "SELECT * FROM user_reset_password_logs WHERE verify_token = '$verification_code'";
        $confirm_code_result = mysqli_query($con, $confirm_code_query);

        if ($confirm_code_result && mysqli_num_rows($confirm_code_result) > 0) {
            $fetch_code = mysqli_fetch_assoc($confirm_code_result);

            if ($fetch_code['verify_token'] === $verification_code) {
                $hashed_password = base64_encode($new_password);
                $user_id = $fetch_code['user_id'];

                $update_query = "UPDATE user_reset_password_logs SET is_verified = 'true' WHERE verify_token = $verification_code";
                $update_result = mysqli_query($con, $update_query);

                $update_password_query = "UPDATE users_accounts SET user_password = '$hashed_password' WHERE user_id = '$logged_in_user'";
                $update_password_result = mysqli_query($con, $update_password_query);

                if ($update_result && $update_password_result) {
                    $data['status'] = "success";
                    $data['message'] = "Verification successful. Your password has been changed.";
                } else {
                    $data['status'] = "error";
                    $data['message'] = "Failed to update verification status.";
                }
            } else {
                $data['status'] = "error";
                $data['message'] = "Invalid verification code. Please double-check and try again.";
            }
        } else {
            $data['status'] = "error";
            $data['message'] = "Invalid verification code. Please double-check and try again.";
        }
    }
} else {
    $data['status'] = "error";
    $data['message'] = "Invalid request method";
}

echo json_encode($data);
