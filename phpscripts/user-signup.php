<?php
session_start();

include("database-connection.php");

$data = [];

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $fullName = mysqli_real_escape_string($con, $_POST['fullName']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Base64 encode passwords
    $encodedPassword = base64_encode($password);
    $encodedConfirmPassword = base64_encode($confirmPassword);

    if (empty($fullName) || empty($email)) {
        $data['status'] = "error";
        $data['message'] = "All fields are required";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $data['status'] = "error";
        $data['message'] = "Invalid email format";
    } else if ($encodedPassword !== $encodedConfirmPassword) {
        $data['status'] = "error";
        $data['message'] = "Passwords do not match";
    } else {
        $check_email_query = "SELECT user_email FROM users_accounts WHERE user_email = '$email'";
        $check_email_result = mysqli_query($con, $check_email_query);

        if (mysqli_num_rows($check_email_result) > 0) {
            $data['status'] = "error";
            $data['message'] = "Email already used";
        } else {
            $userId = random_int(100000, 999999);
            $create_acc_query = "INSERT INTO users_accounts (user_id, user_name, user_email, user_password, user_type, user_status, date_created) VALUES ('$userId', '$fullName', '$email', '$encodedPassword', 'user', 'active', NOW())";
            $create_acc_result = mysqli_query($con, $create_acc_query);

            if ($create_acc_result) {
                $data['status'] = "success";
                $data['message'] = "Account created successfully!";
            } else {
                $data['status'] = "error";
                $data['message'] = "Failed to create account. Please try again later.";
            }
        }
    }
}

echo json_encode($data);
