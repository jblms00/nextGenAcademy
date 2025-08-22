<?php
session_start();
include("database-connection.php");

$data = [];

$fetch_recent_forums_query = "
    SELECT forum_id, user_id, forum_title, forum_description, forum_file_upload, datetime_created
    FROM forums
    ORDER BY datetime_created DESC
    LIMIT 3
";

$fetch_recent_forums_result = mysqli_query($con, $fetch_recent_forums_query);

if ($fetch_recent_forums_result) {
    if (mysqli_num_rows($fetch_recent_forums_result) > 0) {
        $forums = [];
        while ($row = mysqli_fetch_assoc($fetch_recent_forums_result)) {
            $forums[] = $row;
        }
        $data['status'] = 'success';
        $data['forums'] = $forums;
    } else {
        $data['status'] = 'error';
        $data['message'] = 'No recent forums found.';
    }
} else {
    $data['status'] = 'error';
    $data['message'] = 'Failed to execute query.';
}

echo json_encode($data);
?>