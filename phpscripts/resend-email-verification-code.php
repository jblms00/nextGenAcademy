<?php
include("database-connection.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../assets/vendor/autoload.php';

$data = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['userId'])) {
    $userId = mysqli_real_escape_string($con, $_POST['userId']);

    // Get user ID
    $query = "SELECT user_email, user_name FROM users_accounts WHERE user_id = '$userId'";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $userEmail = $user['user_email'];
        $userName = $user['user_name'];

        $verificationCode = generateVerificationCode();
        $insertQuery = "INSERT INTO user_reset_password_logs (user_id, verify_token, reset_date) VALUES ('$userId', '$verificationCode', NOW())";
        if (mysqli_query($con, $insertQuery)) {
            if (sendVerificationEmail($userEmail, $userName, $verificationCode)) {
                $data['status'] = "success";
                $data['message'] = "A new verification code has been sent to your email.";
            } else {
                $data['status'] = "error";
                $data['message'] = "Failed to send the new verification code. Please try again.";
            }
        } else {
            $data['status'] = "error";
            $data['message'] = "Failed to insert the verification code into the database.";
        }
    } else {
        $data['status'] = "error";
        $data['message'] = "No user found with the provided email address.";
    }
} else {
    $data['status'] = "error";
    $data['message'] = "Invalid request. Please try again.";
}

echo json_encode($data);

function generateVerificationCode()
{
    return rand(100000, 999999);
}

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

        $mail->isHTML(true);
        $mail->Subject = "New Verification Code";
        $mail->Body = "<p>Your new verification code is: <b>$verification_code</b></p>";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
}
