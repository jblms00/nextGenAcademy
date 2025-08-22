<?php
session_start();

include("database-connection.php");

$data = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_account = $_POST['user_account'];

    if (empty($user_account)) {
        $data['status'] = "error";
        $data['message'] = "Please enter your email";
    } else {
        $get_user_info_query = "SELECT * FROM users_accounts WHERE user_email = '$user_account'";
        $get_user_info_result = mysqli_query($con, $get_user_info_query);

        if ($get_user_info_result && mysqli_num_rows($get_user_info_result) > 0) {
            $data['account_info'] = mysqli_fetch_assoc($get_user_info_result);
            $data['status'] = 'success';
            $data['message'] = "Account found.";
        } else {
            $data['status'] = "error";
            $data['message'] = "No user found. Please try again.";
        }
    }

} else {
    $data['status'] = "error";
    $data['message'] = "Invalid request method. Please try again.";
}

echo json_encode($data);