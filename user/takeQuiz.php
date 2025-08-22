<?php
session_start();

include("../phpscripts/database-connection.php");
include("../phpscripts/check-login.php");
include("../phpscripts/admin/fetch-appearance.php");
$appearance = get_system_appearance($con);
$user_data = check_login($con);
$full_name = $user_data['user_name'];
$first_name = explode(' ', trim($full_name))[0];
$userPhoto = !empty($user_data['user_photo']) ? $user_data['user_photo'] : 'default-profile.png';

$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

$weekNumberMatch = [];
preg_match("/weekNumber=(\d+)&id=(\d+)/", $url, $weekNumberMatch);
$weekNumber = isset($weekNumberMatch[1]) ? $weekNumberMatch[1] : null;
$idNumber = isset($weekNumberMatch[2]) ? $weekNumberMatch[2] : null;

$lessonTitle = isset($_GET['lesson']) ? $_GET['lesson'] : null;
$quizNumber = isset($_GET['quiz']) ? $_GET['quiz'] : null;
?>

<!doctype html>
<html lang="en">

<head>
    <?php include("../includes/header.php"); ?>
    <style>
        body {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body class="user-side" data-user-id="<?php echo $user_data['user_id']; ?>">
    <div class="quiz-container mt-5">
        <div class="page-title text-center">
            <h1 class="mb-0 fw-bold">Interactive Quiz</h1>
            <h5 class="mb-0 fw-semibold">Test your knowledge in <?php echo $lessonTitle ?></h5>
            <div class="mt-4">
                <a href="lecture?weekNumber<?php echo $weekNumber; ?>&id<?php echo $idNumber; ?>"
                    class="btn btn-primary py-0" style="width: 10%;">Go Back</a>
            </div>
        </div>
        <div class="container" id="questionsContainer"></div>
    </div>
    </div>
    <?php include("../includes/components/user/modal.php"); ?>
    <!-- Score Modal -->
    <div class="modal fade" id="scoreModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="scoreModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body"></div>
            </div>
        </div>
    </div>

    <?php include("../includes/components/user/toast.php"); ?>
    <?php include("../includes/scripts.php"); ?>
    <script src="../assets/js/components/sidebar.js"></script>
    <script src="../assets/js/displayQuizQuestionnaires.js"></script>
</body>

</html>