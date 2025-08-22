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

$query = parse_url($url, PHP_URL_QUERY);
parse_str($query, $params);

// Assign values or null if not set
$weekNumber = isset($params['weekNumber']) ? $params['weekNumber'] : null;
$id = isset($params['id']) ? $params['id'] : null;
$modelName = isset($params['modelName']) ? $params['modelName'] : null;
$mid = isset($params['mid']) ? $params['mid'] : null;
$uid = isset($params['uid']) ? $params['uid'] : null;
?>

<!doctype html>
<html lang="en">

<head>
    <?php include("../includes/header.php"); ?>

    <style>
        #api-frame {
            width: 100%;
            height: 800px;
            border: none;
        }

        .hidden {
            visibility: hidden;
            height: 0;
            width: 0;
        }
    </style>

</head>

<body class="user-side" data-user-id="<?php echo $user_data['user_id']; ?>"
    data-user-profile="<?php echo $userPhoto; ?>">
    <?php include("../includes/components/user/sidebar.php"); ?>
    <section class="home-section">
        <div class="d-flex gap-2">
            <div class="container-3d-models container-fluid p-0">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h2 class="text-uppercase fw-bold">3D Model View</h2>
                    <a href="lecture?weekNumber<?php echo $weekNumber; ?>&id<?php echo $id ?>"
                        class="btn btn-primary rounded-pill py-0" style="width: 10%">Go Back</a>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <iframe class="hidden" src="" id="api-frame"
                            sandbox="allow-scripts allow-same-origin allow-popups allow-forms"
                            allow="autoplay; fullscreen; xr-spatial-tracking" xr-spatial-tracking
                            execution-while-out-of-viewport execution-while-not-rendered web-share allowfullscreen
                            mozallowfullscreen="true" webkitallowfullscreen="true"></iframe>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col">
                        <h5 class="fw-bold mb-3">Description</h5>
                        <div class="description-container">
                            <p id="modelDescription" class="mb-0 text-light"></p>
                        </div>
                    </div>
                </div>
                <div class="comment-container">
                    <h5 class="fw-bold mb-3">Comments</h5>
                    <div class="input-container">
                        <div class="form-floating mb-3">
                            <textarea class="form-control" placeholder="Leave a comment here"
                                id="inputComment"></textarea>
                            <label for="inputComment">Comments</label>
                        </div>
                        <button type="button" id="postCommentButton" class="btn btn-primary">Post Comment</button>
                    </div>
                </div>
                <div class="comment-section" id="commentSection"></div>
            </div>
        </div>
        </div>
    </section>
    <?php include("../includes/components/user/toast.php"); ?>
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
    <?php include("../includes/scripts.php"); ?>
    <script type="text/javascript" src="https://static.sketchfab.com/api/sketchfab-viewer-1.12.1.js"></script>
    <script src="../assets/js/components/sidebar.js"></script>
    <script src="../assets/js/userProfile.js"></script>
    <script src="../assets/js/3DModels/getModel.js"></script>
    <script src="../assets/js/modelComments.js"></script>
</body>

</html>