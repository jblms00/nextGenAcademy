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
        <div class="d-flex justify-content-between">
            <div class="page-title">
                <h1 class="mb-0 fw-bold">Welcome to the TechBuildLearn Community Forum</h1>
            </div>
            <div>
                <button type="button" class="btn btn-primary rounded-pill py-1" data-bs-toggle="modal"
                    data-bs-target="#modalPostForum">Post a Forum</button>
            </div>
        </div>
        <h5 class="mb-0 fw-semibold">Engage with fellow learners, share your progress and get
            help
            from experts</h5>
        <div class="forums-main-container" style="margin-bottom: 2.5rem;">
            <h3 class="text-light text-uppercase fw-bold mb-2 ps-3 pt-3">Forums</h3>
            <div class="forums-container" id="forumsContainer"></div>
        </div>
        <div class="discussion-container">
            <h3 class="mb-4 fw-bold">Recent Discussions</h3>
            <ul id="recentDiscussionsContainer" class="p-0 m-0" style="list-style-type: none;"></ul>
        </div>
    </section>
    <?php include("../includes/components/user/modal.php"); ?>
    <?php include("../includes/components/user/toast.php"); ?>
    <div class="modal fade" id="modalPostForum" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="modalPostForum" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h1 class="modal-title fs-4 fw-bold">Create Your Forum Topic</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="postForumForm" class="needs-validation" novalidate enctype="multipart/form-data">
                        <div class="row mb-3">
                            <div class="col">
                                <p class="mb-0 fw-bold">Title</p>
                                <input type="text" class="form-control" id="formTitle" name="forumTitle" required>
                                <div class="invalid-feedback fw-semibold text-danger">Title is required.</div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <p class="mb-0 fw-bold">Description</p>
                                <textarea class="form-control" style="height: 100px;"
                                    placeholder="Enter your forum description here" id="formDescription"
                                    name="forumDescription" required></textarea>
                                <div class="invalid-feedback fw-semibold text-danger">Description is required.</div>
                            </div>
                        </div>
                        <div class="row mb-5">
                            <div class="col">
                                <p class="mb-0 fw-bold">Upload File</p>
                                <input type="file" class="form-control" id="formUploadedFile" name="forumFile"
                                    accept="image/*,video/*" required>
                                <div class="invalid-feedback fw-semibold text-danger">File is required.</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col text-center">
                                <button type="submit" class="btn btn-primary rounded-pill py-0 w-25 submit-forum"
                                    style="background-color: var(--bg-color5); border-color: var(--bg-color5);">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="forumEditModal" tabindex="-1" aria-labelledby="forumEditModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="forumEditModalLabel">Edit Forum</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="forumTitleGroup" class="mb-3">
                        <label for="forumTitle" class="form-label mb-0 fw-bold">Forum Title</label>
                        <input type="text" class="form-control" id="forumTitle">
                    </div>
                    <div id="forumDescriptionGroup" class="mb-3">
                        <label for="forumDescription" class="form-label mb-0 fw-bold">Description</label>
                        <textarea class="form-control" id="forumDescription" style="height: 100px"></textarea>
                    </div>
                    <div id="forumFileGroup">
                        <label for="forumFile" class="form-label mb-0 fw-bold">Upload File</label>
                        <input type="file" class="form-control" id="forumFile">
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary py-0" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary py-0" id="modalConfirmButton">Save Changes</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="forumDeleteModal" tabindex="-1" aria-labelledby="forumDeleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="forumDeleteModalLabel">Delete Forum</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="deleteConfirmationMessage" class="text-danger">
                        Are you sure you want to delete this forum?
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary py-0" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary py-0" id="modalConfirmDeleteButton">Confirm</button>
                </div>
            </div>
        </div>
    </div>
    <?php include("../includes/scripts.php"); ?>
    <script src="../assets/js/components/sidebar.js"></script>
    <script src="../assets/js/userProfile.js"></script>
    <script src="../assets/js/displayForums.js"></script>
</body>

</html>