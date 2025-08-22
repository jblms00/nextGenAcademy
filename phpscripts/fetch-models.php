<?php
session_start();
include("database-connection.php");

$data = [];
$lessonId = isset($_POST['lessonId']) ? intval($_POST['lessonId']) : 0;

if ($lessonId > 0) {
    $fetch_model_query = "
        SELECT m.*, l.week_number 
        FROM 3d_models m 
        JOIN lessons l ON m.lesson_id = l.lesson_id 
        WHERE m.lesson_id = $lessonId
    ";
    $fetch_model_result = mysqli_query($con, $fetch_model_query);

    if ($fetch_model_result) {
        $models = [];
        while ($row = mysqli_fetch_assoc($fetch_model_result)) {
            $models[] = $row;
        }
        $data['status'] = 'success';
        $data['models'] = $models;
    } else {
        $data['status'] = 'error';
        $data['message'] = 'Failed to execute query.';
    }
} else {
    $data['status'] = 'error';
    $data['message'] = 'Invalid week number.';
}

echo json_encode($data);
?>