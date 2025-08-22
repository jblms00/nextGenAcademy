<?php
session_start();
include("../database-connection.php");

$data = [];

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $fetch_attempts_query = "SELECT * FROM quiz_attempts";
    $fetch_attempts_result = mysqli_query($con, $fetch_attempts_query);

    if ($fetch_attempts_result) {
        $attempts = [];
        while ($row = mysqli_fetch_assoc($fetch_attempts_result)) {
            $attempts[] = $row;
        }
        $data['status'] = 'success';
        $data['attempts'] = $attempts;
    } else {
        $data['status'] = 'error';
        $data['message'] = 'Failed to fetch quiz attempts.';
    }
} else {
    $data['status'] = 'error';
    $data['message'] = 'Invalid request method.';
}

echo json_encode($data);
?>