<?php
session_start();
include("../database-connection.php");

$data = [];

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $forum_id = mysqli_real_escape_string($con, $_POST['forum_id']);
    $author_id = mysqli_real_escape_string($con, $_POST['author_id']);

    if (empty($forum_id)) {
        $data['status'] = "error";
        $data['message'] = "Invalid forum ID";
    } else {
        $fetchQuery = "SELECT forum_file_upload FROM forums WHERE forum_id = '$forum_id' AND user_id = '$author_id'";
        $fetchResult = mysqli_query($con, $fetchQuery);

        if (mysqli_num_rows($fetchResult) > 0) {
            $forumData = mysqli_fetch_assoc($fetchResult);

            $delete_query = "DELETE FROM forums WHERE forum_id = '$forum_id' AND user_id = '$author_id'";
            $delete_result = mysqli_query($con, $delete_query);

            if ($delete_result) {
                if (!empty($forumData['forum_file_upload'])) {
                    $oldFilePath = "../assets/uploadedFile/" . $forumData['forum_file_upload'];
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }
                $data['status'] = "success";
                $data['message'] = "Forum deleted successfully";
            } else {
                $data['status'] = "error";
                $data['message'] = "Failed to delete the forum. Please try again later.";
            }
        } else {
            $data['status'] = "error";
            $data['message'] = "Forum not found.";
        }
    }
} else {
    $data['status'] = "error";
    $data['message'] = "Invalid request method. Please try again later.";
}

echo json_encode($data);
?>