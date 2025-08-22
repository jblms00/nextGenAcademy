<?php
session_start();

include("../phpscripts/database-connection.php");
include("../phpscripts/check-login.php");
include("../phpscripts/admin/fetch-appearance.php");

$appearance = get_system_appearance($con);
$user_data = check_login($con);
?>
<!doctype html>
<html lang="en">

<head>
    <?php include("../includes/header.php"); ?>
</head>

<body class="admin-side" data-user-id="<?php echo $user_data['user_id']; ?>">
    <?php include("../includes/components/admin/navbar.php"); ?>
    <main>
        <div class="page-title d-flex align-items-center justify-content-between">
            <h1>Manage Forums</h1>
            <button type="button" class="btn btn-primary add-post py-0" data-bs-toggle="modal"
                data-bs-target="#modalPostForum">Post New Forum</button>
        </div>
        <div class="container">
            <div class="table-container">
                <table class="display table-bordered border border-opacity-50" id="forumsTable">
                    <thead>
                        <tr>
                            <th>Author Name</th>
                            <th>Email</th>
                            <th>Forum Topic</th>
                            <th>Date and Time Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </main>
    <?php include("../includes/components/admin/toast.php"); ?>
    <?php include("../includes/components/admin/modal.php"); ?>
    <div class="modal fade" id="modalPostForum" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="modalPostForum" aria-hidden="true">
        <div class="modal-dialog modal-md">
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
                                <button type="submit" class="btn btn-primary py-0 w-25 submit-forum">Create</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="forumViewModal" tabindex="-1" aria-labelledby="forumViewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-semibold" id="forumViewModalLabel">View Forum Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered border-dark table-forum" style="width: 100%;">
                        <tbody>
                            <tr>
                                <td class="bg-primary fw-bold">Forum Topic:</td>
                                <td id="forumTitle"></td>
                            </tr>
                            <tr>
                                <td class="bg-primary fw-bold">Forum Content:</td>
                                <td id="forumDescription"></td>
                            </tr>
                            <tr>
                                <td class="bg-primary fw-bold">Forum File Upload:</td>
                                <td id="forumFilUpload"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php include("../includes/scripts.php"); ?>
    <script src="../assets/js/admin/components.js"></script>
    <script src="../assets/js/admin/manageForums.js"></script>
</body>

</html>