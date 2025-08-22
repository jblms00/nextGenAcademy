<?php
session_start();
include("database-connection.php");

$weekNumber = isset($_GET['weekNumber']) ? intval($_GET['weekNumber']) : 0;
$data = [];

if ($weekNumber > 0) {
    $query = "SELECT video_lectures_id, lesson_id, week_number, video_url, datetime_created 
              FROM video_lectures WHERE week_number = $weekNumber";
    $result = mysqli_query($con, $query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $lectures = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $lecture = [
                    'lesson_id' => $row['lesson_id'],
                    'week_number' => $row['week_number'],
                    'video_id' => getYouTubeID($row['video_url']),
                    'datetime_created' => $row['datetime_created']
                ];
                $lectures[] = $lecture;
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
    $datetime_added['message'] = 'Invalid week number.';
}

echo json_encode($data);

function getYouTubeID($url)
{
    preg_match("/(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^&\n]{11})/", $url, $matches);
    return $matches[1] ?? null;
}
