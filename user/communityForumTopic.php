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
        <div class="page-title" style="margin-bottom: 1.5rem;">
            <h1 class="mb-0 fw-bold" id="forumTitle"></h1>
        </div>
        <div class="user-posted">
            <div class="user-profile">
                <img src="" class="border-1 bg-light rounded-circle" width="80" height="100%" alt="img">
            </div>
            <div class="post-info">
                <h4 class="mb-0"></h4>
                <small></small>
            </div>
        </div>
        <div class="post-data">
            <div class="post-description"></div>
            <div class="post-file-upload text-center">
                <img src="" alt="img">
            </div>
        </div>
        <div class="comment-container">
            <h5 class="fw-bold mb-3">Comments</h5>
            <div class="input-container">
                <div class="form-floating mb-3">
                    <textarea class="form-control" placeholder="Leave a comment here" id="inputComment"></textarea>
                    <label for="inputComment">Comments</label>
                </div>
                <button type="button" id="postCommentButton" class="btn btn-primary">Post Comment</button>
            </div>
        </div>
        <div class="comment-section" id="commentSection"></div>
        </div>
    </section>
    <?php include("../includes/components/user/modal.php"); ?>
    <div class="modal fade" id="editCommentModal" tabindex="-1" aria-labelledby="editCommentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="editCommentModalLabel">Edit Comment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <textarea id="editCommentInput" class="form-control" rows="3"></textarea>
                    <input type="hidden" id="editCommentId" />
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-primary py-0" id="saveEditCommentButton">Save Changes</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-0">
                    Are you sure you want to delete this comment?
                    <input type="hidden" id="confirmDeletion">
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-danger py-0 confirm-deletion">Delete</button>
                </div>
            </div>
        </div>
    </div>
    <?php include("../includes/components/user/toast.php"); ?>
    <?php include("../includes/scripts.php"); ?>
    <script src="../assets/js/components/sidebar.js"></script>
    <script src="../assets/js/userProfile.js"></script>
    <script src="../assets/js/displayForumData.js"></script>
</body>

</html>