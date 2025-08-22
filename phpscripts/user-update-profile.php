<?php
session_start();

include("database-connection.php");
include("check-login.php");

$user_data = check_login($con);
$logged_in_user = $user_data['user_id'];

$data = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_name = mysqli_real_escape_string($con, $_POST['user_name']);
    $update_profile_query = "UPDATE users_accounts SET user_name = '$user_name'";

    if (empty($user_name)) {
        $data['message'] = "All fields are required";
        $data['status'] = "error";
    } else {
        if (isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['error'] == 0) {
            $allowed_exts = array("jpg", "jpeg", "png", "gif");
            $file_ext = strtolower(pathinfo($_FILES['fileToUpload']['name'], PATHINFO_EXTENSION));

            if (in_array($file_ext, $allowed_exts)) {
                $name_parts = explode(" ", strtoupper($user_name));
                $name_parts_string = implode("-", $name_parts);
                $date = date("dmY-His");
                $file_name = "$name_parts_string-$date.$file_ext";
                $file_path = "../assets/images/usersProfile/" . $file_name;

                if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $file_path)) {
                    $update_profile_query .= ", user_photo = '$file_name'";
                } else {
                    $data['status'] = "error";
                    $data['message'] = "Failed to upload photo";
                    echo json_encode($data);
                    exit;
                }
            } else {
                $data['status'] = "error";
                $data['message'] = "Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed";
                echo json_encode($data);
                exit;
            }
        }

        $update_profile_query .= " WHERE user_id = '$logged_in_user'";
        $update_profile_result = mysqli_query($con, $update_profile_query);

        if ($update_profile_result) {
            $data['status'] = "success";
            $data['message'] = "Profile updated successfully";
        } else {
            $data['status'] = "error";
            $data['message'] = "Failed to update profile";
        }
    }
} else {
    $data['status'] = "error";
    $data['message'] = "Invalid request method";
}

echo json_encode($data);
