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
    data-user-name="<?php echo $user_data['user_name']; ?>" data-user-photo="<?php echo $userPhoto; ?>"
    data-user-profile="<?php echo $userPhoto; ?>">
    <?php include("../includes/components/user/sidebar.php"); ?>
    <section class="home-section">
        <div class="main-chat-container">
            <div class="chat-list-container">
                <div class="search-container">
                    <input type="text" id="searchChatMate" placeholder="Search here">
                    <button type="button" class="add-conversation"><i class="fa-solid fa-plus"></i></button>
                </div>
                <ul class="chat-list"></ul>
            </div>
            <div class="chat-container">
                <div class="chat-header p-2 gap-2 d-none">
                    <div class="group-photos-container" style="display: flex; gap: 5px;"></div>
                    <img src="" class="bg-light rounded-circle" height="50" width="50" alt="img">
                    <h4 class="mb-0"></h4>
                </div>
                <div class="chat-box"></div>
                <div class="chat-input d-none">
                    <input type="text" placeholder="Enter your message here">
                </div>
            </div>
        </div>
    </section>
    <?php include("../includes/components/user/modal.php"); ?>
    <?php include("../includes/components/user/toast.php"); ?>
    <div class="modal fade" id="usersModal" tabindex="-1" aria-labelledby="usersModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h1 class="modal-title fs-5">Add Conversation</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="usersContainer">
                        <!-- Users will be displayed here -->
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary py-0" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary py-0" id="createConversationBtn">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <?php include("../includes/scripts.php"); ?>
    <script src="../assets/js/components/sidebar.js"></script>
    <script src="../assets/js/userProfile.js"></script>
    <script src="../assets/js/userConvsersation.js"></script>
</body>

</html>