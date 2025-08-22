<?php
session_start();

include("../phpscripts/database-connection.php");
include("../phpscripts/check-login.php");
include("../phpscripts/admin/fetch-appearance.php");
$appearance = get_system_appearance($con);
$user_data = check_login($con);
$full_name = $user_data['user_name'];
$first_name = explode(' ', trim($full_name))[0];
$userPhoto = !empty($user_data['user_photo']) ? trim($user_data['user_photo']) : 'default-profile.png';
$weekNumber = isset($_GET['weekNumber']) ? htmlspecialchars($_GET['weekNumber']) : 'Unknown';
?>
<!doctype html>
<html lang="en">

<head>
    <?php include("../includes/header.php"); ?>
    <style>
        .user-side .home-section {
            min-height: auto;
            padding-bottom: 0;
        }
    </style>
</head>

<body class="user-side" data-user-photo="<?php echo $userPhoto; ?>" data-user-id="<?php echo $user_data['user_id']; ?>"
    data-user-profile="<?php echo $userPhoto; ?>">
    <?php include("../includes/components/user/sidebar.php"); ?>
    <section class="home-section">
        <div class="d-flex gap-2">
            <div class="container-video-lecture container-fluid p-0"></div>
        </div>
    </section>
    <?php include("../includes/components/user/modal.php"); ?>
    <?php include("../includes/scripts.php"); ?>
    <script src="../assets/js/components/sidebar.js"></script>
    <script src="../assets/js/userProfile.js"></script>
    <script src="../assets/js/displayVideoLecture.js"></script>
</body>

</html>