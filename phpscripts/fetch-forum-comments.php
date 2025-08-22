<?php
session_start();
include 'database-connection.php';

$data = [];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['forum_id'])) {
        $forumId = mysqli_real_escape_string($con, $_GET['forum_id']);

        $query = "
            SELECT fc.comment_id, fc.comment, fc.datetime_created, u.user_id, u.user_name, u.user_photo 
            FROM forum_comments fc
            LEFT JOIN users_accounts u ON fc.user_id = u.user_id
            WHERE fc.forum_id = '$forumId'
            ORDER BY fc.datetime_created DESC";

        $result = mysqli_query($con, $query);

        if ($result) {
            $comments = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $comments[] = [
                    'comment_id' => $row['comment_id'],
                    'user_id' => $row['user_id'],
                    'user_name' => $row['user_name'],
                    'user_photo' => $row['user_photo'] ? "../assets/images/usersProfile/" . $row['user_photo'] : "../assets/images/usersProfile/default-profile.png",
                    'comment_text' => $row['comment'],
                    'datetime_created' => $row['datetime_created'],
                ];
            }
            $data['status'] = 'success';
            $data['comments'] = $comments;
        }
    } else {
        $data['status'] = 'error';
        $data['message'] = 'Forum ID not provided.';
    }
} else {
    $data['status'] = 'error';
    $data['message'] = 'Invalid request method.';
}

echo json_encode($data);
?>