<?php
session_start();
include("database-connection.php");

$data = [];

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $loggedInUserId = mysqli_real_escape_string($con, $_GET['loggedInUserId']);

    $fetch_users_query = "SELECT user_id, user_name, user_photo FROM users_accounts WHERE user_id != '$loggedInUserId' AND user_type != 'admin'";
    $fetch_users_result = mysqli_query($con, $fetch_users_query);

    if ($fetch_users_result) {
        $users = [];
        while ($row = mysqli_fetch_assoc($fetch_users_result)) {
            $users[] = $row;
        }
        $data['status'] = 'success';
        $data['users'] = $users;
    } else {
        $data['status'] = 'error';
        $data['message'] = 'Failed to fetch users.';
    }

    echo json_encode($data);
}

?>