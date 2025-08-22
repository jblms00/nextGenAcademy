<?php
session_start();

include("database-connection.php");

$data = [];

// Old
// $fetch_forums_query = "SELECT * FROM forums";

// New 
$fetch_forums_query = "
    SELECT forums.*, users_accounts.user_name, users_accounts.user_email, users_accounts.user_photo 
    FROM forums
    LEFT JOIN users_accounts ON forums.user_id = users_accounts.user_id
";
$fetch_forums_result = mysqli_query($con, $fetch_forums_query);

if ($fetch_forums_result) {
    if (mysqli_num_rows($fetch_forums_result) > 0) {
        $forums = [];
        while ($row = mysqli_fetch_assoc($fetch_forums_result)) {
            $forums[] = $row;
        }
        $data['status'] = 'success';
        $data['forums'] = $forums;
    } else {
        $data['status'] = 'success';
        $data['forums'] = [];
    }
} else {
    $data['status'] = 'error';
    $data['message'] = 'Failed to execute query.';
}

echo json_encode($data);
?>