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

$weekNumber = 'N/A';
$queryString = $_SERVER['QUERY_STRING'];

if (preg_match('/weekNumber(\d+)/', $queryString, $matches)) {
    $weekNumber = $matches[1];
}
?>
<!doctype html>
<html lang="en">

<head>
    <?php include("../includes/header.php"); ?>
</head>

<body class="user-side" data-user-id="<?php echo $user_data['user_id']; ?>"
    data-user-profile="<?php echo $userPhoto; ?>">
    <?php include("../includes/components/user/sidebar.php"); ?>
    <section class="home-section">
        <div class="row">
            <div class="col">
                <div class="page-title">
                    <h1 class="mb-0 text-uppercase fw-bold">Week <span><?php echo $weekNumber ?></span> -
                        Video Lectures</h1>
                </div>
                <div class="container-video-lectures container-fluid p-0" style="margin: 56px 0;"></div>
                <div class="main-contianer-models">
                    <div class="page-title">
                        <h1 class="mb-0 text-uppercase fw-bold">Week
                            <span><?php echo $weekNumber ?></span> -
                            3D Models
                        </h1>
                    </div>
                    <div class="contianer-models"></div>
                </div>
            </div>
            <div class="col-2">
                <div class="quizzes-container mb-2">
                    <h4 class="mb-3 p-3 pb-0">Quizzes</h4>
                    <ul id="quizzesList"></ul>
                </div>
                <div class="collaborations-container mb-2">
                    <h4 class="mb-3 p-3 pb-0">Group Collaborations</h4>
                    <ul id="collaborationList"></ul>
                </div>
            </div>
        </div>
    </section>
    <?php include("../includes/components/user/modal.php"); ?>
    <?php include("../includes/components/user/toast.php"); ?>
    <div class="modal fade" id="groupTaskModal" tabindex="-1" aria-labelledby="groupTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="groupTaskModalLabel">Group Task</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-container">
                        <table class="table table-bordered table-sm align-middle mb-3" id="tableMembers">
                            <thead>
                                <th>Members</th>
                            </thead>
                            <tbody></tbody>
                        </table>
                        <table class="table table-bordered table-sm align-middle mb-3" id="tableTasks">
                            <thead>
                                <th>Task</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include("../includes/scripts.php"); ?>
    <script src="../assets/js/components/sidebar.js"></script>
    <script src="../assets/js/userProfile.js"></script>
    <script src="../assets/js/displayLectures.js"></script>
    <script src="../assets/js/displayQuiz.js"></script>
    <script src="../assets/js/displayModels.js"></script>
    <script src="../assets/js/displayGroup.js"></script>
</body>

</html>