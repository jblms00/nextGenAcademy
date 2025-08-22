<?php
session_start();

include("../database-connection.php");

$data = [];

$query = "
        SELECT user_id, user_name, user_email, user_status, date_created 
        FROM users_accounts 
        WHERE user_type != 'admin'";

$result = mysqli_query($con, $query);

if ($result) {
    $users = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = [
            'user_id' => $row['user_id'],
            'user_name' => $row['user_name'],
            'user_email' => $row['user_email'],
            'user_status' => $row['user_status'],
            'date_created' => date("F j, Y", strtotime($row['date_created']))
        ];
    }

    $data['status'] = "success";
    $data['users'] = $users;
} else {
    $data['status'] = "error";
    $data['message'] = "Failed to fetch users.";
}


echo json_encode($data);
?>