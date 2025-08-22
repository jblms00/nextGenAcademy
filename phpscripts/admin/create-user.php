<?php
session_start();

include("../database-connection.php");

$data = [];

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $user_name = mysqli_real_escape_string($con, $_POST['user_name']);
    $user_email = mysqli_real_escape_string($con, $_POST['user_email']);
    $user_status = mysqli_real_escape_string($con, $_POST['user_status']);
    $user_password = mysqli_real_escape_string($con, $_POST['user_password']);

    if (empty($user_name) || empty($user_email) || empty($user_type) || empty($user_status)) {
        $data['status'] = "error";
        $data['message'] = "All fields are required";
    } else if ($user_type === "Please select user type") {
        $data['status'] = "error";
        $data['message'] = "Please select user type";
    } else if ($user_status === "Please select user status") {
        $data['status'] = "error";
        $data['message'] = "Please select user status";
    } else {
        $user_id = random_int(100000, 999999);
        $date_created = date('Y-m-d H:i:s');
        $encoded_password = base64_encode($user_password);

        $insert_user_query = "INSERT INTO users_accounts (user_id, user_name, user_email, user_password, user_type, user_status, date_created) 
                              VALUES ('$user_id', '$user_name', '$user_email', '$encoded_password', 'user', '$user_status', '$date_created')";

        $insert_user_result = mysqli_query($con, $insert_user_query);

        if ($insert_user_result) {
            $data['status'] = "success";
            $data['message'] = "User created successfully";
        } else {
            $data['status'] = "error";
            $data['message'] = "Database error: " . mysqli_error($con);
        }
    }
} else {
    $data['status'] = "error";
    $data['message'] = "Invalid request method. Please try again later.";
}

echo json_encode($data);
?>