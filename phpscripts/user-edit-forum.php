<?php
session_start();
include("database-connection.php");
$data = [];

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $forum_id = $_POST['forum_id'];
    $forum_title = $_POST['forum_title'];
    $forum_description = $_POST['forum_description'];

    $fetchQuery = "SELECT forum_file_upload FROM forums WHERE forum_id = '$forum_id'";
    $fetchResult = mysqli_query($con, $fetchQuery);
    $forumData = mysqli_fetch_assoc($fetchResult);
    $oldFileName = $forumData['forum_file_upload'];

    if (isset($_FILES['forum_file']) && $_FILES['forum_file']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['forum_file']['tmp_name'];
        $fileName = $_FILES['forum_file']['name'];
        $destination = "../assets/uploadedFile/" . $fileName;

        if (!empty($oldFileName)) {
            $oldFilePath = "../assets/uploadedFile/" . $oldFileName;
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }
        }

        if (move_uploaded_file($fileTmpPath, $destination)) {
            $fileQuery = ", forum_file_upload = '$fileName'";
        } else {
            $data['status'] = "error";
            $data['message'] = "Error uploading file";
            echo json_encode($data);
            exit;
        }
    } else {
        $fileQuery = "";
    }

    $updateQuery = "UPDATE forums SET forum_title = '$forum_title', forum_description = '$forum_description' $fileQuery WHERE forum_id = '$forum_id'";
    $result = mysqli_query($con, $updateQuery);

    if ($result) {
        $data['message'] = "Forum successfully updated";
        $data['status'] = "success";
    } else {
        $data['status'] = "error";
        $data['message'] = "Error updating forum";
    }

    echo json_encode($data);
}
?>