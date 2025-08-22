<?php
session_start();
include("../database-connection.php");
include("../check-login.php");

$user_data = check_login($con);
$loggedInUser = $user_data['user_id'];

$data = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['userId'])) {
    $userId = mysqli_real_escape_string($con, $_POST['userId']);

    if ($userId == $loggedInUser) {
        $data['status'] = "error";
        $data['message'] = "You cannot delete your own account.";
    } else {
        $query = "DELETE FROM users_accounts WHERE user_id = '$userId'";
        $result = mysqli_query($con, $query);

        if ($result) {
            $data['status'] = "success";
            $data['message'] = "Deleted successfully.";
        } else {
            $data['status'] = "error";
            $data['message'] = "Failed to delete. Please try again later.";
        }
    }
} else {
    $data['status'] = "error";
    $data['message'] = "Invalid request. Please try again later.";
}

echo json_encode($data);
?>