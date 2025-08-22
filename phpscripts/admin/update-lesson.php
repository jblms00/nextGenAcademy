<?php
session_start();

include("../database-connection.php");

$data = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $lesson_id = mysqli_real_escape_string($con, $_POST['lesson_id']);
    $week_number = mysqli_real_escape_string($con, $_POST['week_number']);
    $lesson_title = mysqli_real_escape_string($con, $_POST['lesson_title']);
    $lesson_description = mysqli_real_escape_string($con, $_POST['lesson_description']);

    if (empty($lesson_id) || empty($week_number) || empty($lesson_title) || empty($lesson_description)) {
        $data['status'] = 'error';
        $data['message'] = 'All fields are required';
    } else {
        if (isset($_FILES['lessonBanner']) && $_FILES['lessonBanner']['error'] == 0) {
            $target_dir = "../uploads/";

            $current_date_time = date("Y-m-d-H-i-s");
            $new_filename = "WEEK{$week_number}-LESSON-{$current_date_time}.webp";
            $target_file = $target_dir . $new_filename;

            $get_current_banner_query = "SELECT lesson_image_banner FROM lessons WHERE lesson_id = '$lesson_id'";
            $result = mysqli_query($con, $get_current_banner_query);
            $row = mysqli_fetch_assoc($result);
            $old_banner_file = $row['lesson_image_banner'];

            if (move_uploaded_file($_FILES['lessonBanner']['tmp_name'], $target_file)) {
                $update_lesson_query = "UPDATE lessons SET week_number = '$week_number', lesson_title = '$lesson_title', 
                                        lesson_description = '$lesson_description', lesson_image_banner = '$new_filename' 
                                        WHERE lesson_id = '$lesson_id'";
                $update_lesson_result = mysqli_query($con, $update_lesson_query);

                if ($update_lesson_result) {
                    if (!empty($old_banner_file) && file_exists($target_dir . $old_banner_file)) {
                        unlink($target_dir . $old_banner_file);
                    }

                    $data['status'] = 'success';
                    $data['message'] = 'Lesson updated successfully with a new banner';
                } else {
                    $data['status'] = 'error';
                    $data['message'] = 'Failed to update lesson: ' . mysqli_error($con);
                }
            } else {
                $data['status'] = 'error';
                $data['message'] = 'Failed to upload new banner file';
            }
        } else {
            $update_lesson_query = "UPDATE lessons SET week_number = '$week_number', lesson_title = '$lesson_title', 
                                    lesson_description = '$lesson_description' WHERE lesson_id = '$lesson_id'";
            $update_lesson_result = mysqli_query($con, $update_lesson_query);

            if ($update_lesson_result) {
                $data['status'] = 'success';
                $data['message'] = 'Lesson updated successfully without changing the banner';
            } else {
                $data['status'] = 'error';
                $data['message'] = 'Failed to update lesson: ' . mysqli_error($con);
            }
        }
    }
} else {
    $data['status'] = 'error';
    $data['message'] = 'Invalid request method';
}

echo json_encode($data);
?>