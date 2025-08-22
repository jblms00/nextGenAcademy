<?php
session_start();
include("../database-connection.php");

$data = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $week_number = mysqli_real_escape_string($con, $_POST['week_number']);
    $lesson_title = mysqli_real_escape_string($con, $_POST['lesson_title']);
    $lesson_description = mysqli_real_escape_string($con, $_POST['lesson_description']);

    if (empty($week_number) || empty($lesson_title) || empty($lesson_description)) {
        $data['status'] = 'error';
        $data['message'] = 'All fields are required';
    } else if (!is_numeric($week_number)) {
        $data['status'] = "error";
        $data['message'] = "Invalid week number. Please enter a valid week_number.";
    } else {
        if (isset($_FILES['lessonBanner'])) {
            $banner_file = $_FILES['lessonBanner'];
            $banner_extension = pathinfo($banner_file['name'], PATHINFO_EXTENSION);

            $banner_filename = 'WEEK' . $week_number . '-LESSON-' . date('Y-m-d-H-i-s') . '.' . $banner_extension;
            $upload_path = '../assets/images/lessonsBanner/' . $banner_filename;

            if (move_uploaded_file($banner_file['tmp_name'], $upload_path)) {
                $lesson_id = random_int(100000, 999999);
                $create_lesson_query = "INSERT INTO lessons (lesson_id, week_number, lesson_title, lesson_description, lesson_banner) VALUES ('$lesson_id', '$week_number', '$lesson_title', '$lesson_description', '$banner_filename')";
                $create_lesson_result = mysqli_query($con, $create_lesson_query);

                if ($create_lesson_result) {
                    $data['status'] = 'success';
                    $data['message'] = 'Lesson created successfully';
                } else {
                    $data['status'] = 'error';
                    $data['message'] = 'Failed to create lesson: ' . mysqli_error($con);
                }
            } else {
                $data['status'] = 'error';
                $data['message'] = 'Failed to upload lesson banner';
            }
        } else {
            $data['status'] = 'error';
            $data['message'] = 'Lesson banner is required';
        }
    }
} else {
    $data['status'] = 'error';
    $data['message'] = 'Invalid request method. Please try again later';
}

echo json_encode($data);
?>