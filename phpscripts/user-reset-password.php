<?php
session_start();

include("database-connection.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../assets/vendor/autoload.php';

$data = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $user_confirmation = $_POST['user_confirmation'];

    if ($user_confirmation === "yes" || $user_confirmation === "YES") {
        $get_user_query = "SELECT * FROM users_accounts WHERE user_id = '$user_id' LIMIT 1";
        $get_user_result = mysqli_query($con, $get_user_query);

        if ($get_user_result && mysqli_num_rows($get_user_result) > 0) {
            $fetch_user = mysqli_fetch_assoc($get_user_result);
            $user_name = $fetch_user['user_name'];
            $user_email = $fetch_user['user_email'];
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
        } else {
            $data['status'] = "error";
            $data['message'] = "No user found";
        }
    } else if (empty($user_confirmation)) {
        $data['status'] = "error";
        $data['message'] = "Please confirm if its is your account";
    } else {
        $data['status'] = "error";
        $data['message'] = "Please confirm if its is your account";
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

        $mail->Subject = "Email Verification";
        $mail->Body = "<p>Your verification code is: <b>$verification_code</b></p>";

        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}