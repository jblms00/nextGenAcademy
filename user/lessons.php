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
        <div class="page-title">
            <h1 class="mb-0 text-uppercase fw-bold">Lessons</h1>
        </div>
        <div class="container-lessons container-fluid p-0" style="margin-top: 56px;"></div>
    </section>
    <?php include("../includes/components/user/modal.php"); ?>
    <?php include("../includes/scripts.php"); ?>
    <script src="../assets/js/components/sidebar.js"></script>
    <script src="../assets/js/userProfile.js"></script>
    <script src="../assets/js/displayLessons.js"></script>
</body>

</html>