<?php
session_start();
include("database-connection.php");

$data = [];
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $model_id = isset($_GET['model_id']) ? mysqli_real_escape_string($con, $_GET['model_id']) : null;

    if ($model_id) {
        $query = "SELECT model_id, lesson_id, model_name, model_description FROM 3d_models WHERE model_id = '$model_id'";
        $result = mysqli_query($con, $query);

        if (mysqli_num_rows($result) > 0) {
            $modelData = mysqli_fetch_assoc($result);
            $data['status'] = "success";
            $data['modelData'] = $modelData;
        } else {
            $data['status'] = "error";
            $data['message'] = "Model not found.";
        }
    } else {
        $data['status'] = "error";
        $data['message'] = "No model specified.";
    }
} else {
    $data['status'] = "error";
    $data['message'] = "Invalid request method.";
}

echo json_encode($data);
?>