<?php
session_start();

include("database-connection.php");

$data = [];
$weekNumber = isset($_GET['weekNumber']) ? intval($_GET['weekNumber']) : 0;

if ($weekNumber > 0) {
    $fetch_lectures_query = "SELECT video_lectures_id, lesson_id, week_number, video_url FROM video_lectures WHERE week_number = $weekNumber ORDER BY video_lectures_id ASC";
    $fetch_lectures_result = mysqli_query($con, $fetch_lectures_query);

    if ($fetch_lectures_result) {
        if (mysqli_num_rows($fetch_lectures_result) > 0) {
            $lectures = [];
            while ($row = mysqli_fetch_assoc($fetch_lectures_result)) {
                $lectures[] = $row;
            }
            $data['status'] = 'success';
            $data['lectures'] = $lectures;
        } else {
            $data['status'] = 'error';
            $data['message'] = 'No lectures found for this week.';
        }
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