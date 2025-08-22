<?php
session_start();

include("database-connection.php");
include("check-login.php");

require '../assets/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$user_data = check_login($con);
$user_name = $user_data['user_name'];
$current_password = base64_decode($user_data['user_password']);

$data = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $user_email = $_POST['user_email'];
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_new_password = $_POST['confirm_new_password'];

    if (empty($old_password) && empty($new_password) && empty($confirm_new_password)) {
        $data['status'] = "error";
        $data['message'] = "All fields are required";
    } else if ($old_password !== $current_password) {
        $data['status'] = "error";
        $data['message'] = "Old password is wrong";
    } else if ($new_password !== $confirm_new_password) {
        $data['status'] = "error";
        $data['message'] = "New password does not match";
    } else {
        $verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);

        $id = rand(10000000, 99999999);
        $insert_verification_query = "INSERT INTO user_reset_password_logs (id, user_id, verify_token, reset_date) VALUES ('$id', '$user_id', '$verification_code', NOW())";
        $insert_verification_result = mysqli_query($con, $insert_verification_query);

        if ($insert_verification_result) {
            sendVerificationEmail($user_email, $user_name, $verification_code);

            $data['status'] = 'success';
            $data['message'] = "Check your email for verification.";
        } else {
            $data['status'] = "error";
            $data['message'] = "Error sending verification to your email";
        }
    }
} else {
    $data['status'] = "error";
    $data['message'] = "Invalid request method";
}

echo json_encode($data);

function sendVerificationEmail($user_email, $user_name, $verification_code)
{
    $mail = new PHPMailer(true);

    try {
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;

        $mail->Username = 'nextgenacademy2002@gmail.com';
        $mail->Password = 'xiwe yxzq ptla nyqf';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('nextgenacademy2002@gmail.com', 'nextGenAcademy Administrator');
        $mail->addAddress($user_email, $user_name);

        $mail->isHTML(true);

        $mail->Subject = "Email Verification from nextGenAcademy Administrator";
        $mail->Body = "<p>Your verification code is: <b style='font-size: 2rem;'>$verification_code</b></p>";

        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}