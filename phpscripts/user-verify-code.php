<?php
session_start();

include("database-connection.php");

$data = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
                $user_id = $fetch_code['user_id'];

                $update_query = "UPDATE user_reset_password_logs SET is_verified = 'true' WHERE verify_token = $verification_code";
                $update_result = mysqli_query($con, $update_query);

                if ($update_result) {
                    $data['status'] = "success";
                    $data['message'] = "Verification successful. Your account has been verified.";
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