<?php
session_start();
include("../database-connection.php");

$data = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fetch_query = "SELECT * FROM system_appearance";
    $fetch_result = mysqli_query($con, $fetch_query);
    $existingFiles = [];

    while ($row = mysqli_fetch_assoc($fetch_result)) {
        $existingFiles[$row['appearance_type']] = $row['file_name'];
    }

    // Handle background image upload
    $backgroundFile = $_FILES['backgroundImage'] ?? null;
    if ($backgroundFile && $backgroundFile['error'] === UPLOAD_ERR_OK) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($backgroundFile['type'], $allowedTypes)) {
            $data["status"] = "error";
            $data["message"] = "Background image must be a JPEG, PNG, or GIF.";
            echo json_encode($data);
            exit;
        }

        if ($backgroundFile['size'] > 2 * 1024 * 1024) {
            $data["status"] = "error";
            $data["message"] = "Background image must be less than 2MB.";
            echo json_encode($data);
            exit;
        }

        // Create a new filename for the background image
        $timestamp = date("m-d-Y-H-i-s"); // Format: MM-DD-YYYY-HH-MM-SS
        $backgroundFilename = "BACKGROUND-" . $timestamp . "." . pathinfo($backgroundFile['name'], PATHINFO_EXTENSION);
        $backgroundPath = "../../assets/images/" . $backgroundFilename;

        if (move_uploaded_file($backgroundFile['tmp_name'], $backgroundPath)) {
            if (isset($existingFiles['background'])) {
                unlink("../../assets/images/" . $existingFiles['background']);
            }
            $query = "UPDATE system_appearance SET file_name = '" . mysqli_real_escape_string($con, $backgroundFilename) . "', datetime_added = NOW() WHERE appearance_type = 'background'";
            mysqli_query($con, $query);
        } else {
            $data["status"] = "error";
            $data["message"] = "Error moving background image.";
            echo json_encode($data);
            exit;
        }
    }

    // Handle logo image upload
    $logoFile = $_FILES['logoImage'] ?? null;
    if ($logoFile && $logoFile['error'] === UPLOAD_ERR_OK) {
        $allowedTypes = ['image/jpeg', 'image/png'];
        if (!in_array($logoFile['type'], $allowedTypes)) {
            $data["status"] = "error";
            $data["message"] = "Logo must be a JPEG or PNG.";
            echo json_encode($data);
            exit;
        }

        if ($logoFile['size'] > 2 * 1024 * 1024) {
            $data["status"] = "error";
            $data["message"] = "Logo must be less than 2MB.";
            echo json_encode($data);
            exit;
        }

        // Create a new filename for the logo image
        $logoFilename = "LOGO-" . $timestamp . "." . pathinfo($logoFile['name'], PATHINFO_EXTENSION);
        $logoPath = "../../assets/images/" . $logoFilename;

        if (move_uploaded_file($logoFile['tmp_name'], $logoPath)) {
            if (isset($existingFiles['logo'])) {
                unlink("../../assets/images/" . $existingFiles['logo']);
            }
            $query = "UPDATE system_appearance SET file_name = '" . mysqli_real_escape_string($con, $logoFilename) . "', datetime_added = NOW() WHERE appearance_type = 'logo'";
            mysqli_query($con, $query);
        } else {
            $data["status"] = "error";
            $data["message"] = "Error moving logo image.";
            echo json_encode($data);
            exit;
        }
    }

    $data["status"] = "success";
    $data["message"] = "Appearance updated successfully.";
} else {
    $data["status"] = "error";
    $data["message"] = "Invalid request method.";
}

echo json_encode($data);
?>