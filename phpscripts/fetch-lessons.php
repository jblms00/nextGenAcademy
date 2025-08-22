<?php
session_start();

include("database-connection.php");

$data = [];

$fetch_lessons_query = "SELECT * FROM lessons ORDER BY lesson_id ASC";
$fetch_lessons_result = mysqli_query($con, $fetch_lessons_query);

if ($fetch_lessons_result) {
    $lessons = [];
    while ($row = mysqli_fetch_assoc($fetch_lessons_result)) {
        $lessons[] = $row;
    }
    $data['status'] = 'success';
    $data['lessons'] = $lessons;
} else {
    $data['status'] = 'error';
    $data['message'] = 'Failed to fetch lessons.';
}

echo json_encode($data);
?>