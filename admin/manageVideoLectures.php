<?php
session_start();

include("../phpscripts/database-connection.php");
include("../phpscripts/check-login.php");
include("../phpscripts/admin/fetch-appearance.php");
$appearance = get_system_appearance($con);
?>
<!doctype html>
<html lang="en">

<head>
    <?php include("../includes/header.php"); ?>
</head>

<body class="admin-side">
    <?php include("../includes/components/admin/navbar.php"); ?>
    <main>
        <div class="page-title d-flex align-items-center justify-content-between">
            <h1>Manage Video Lectures</h1>
            <button type="button" class="btn btn-primary py-0" data-bs-toggle="modal"
                data-bs-target="#createVideoLectureModal">Add New Video Lecture</button>
        </div>
        <div class="container">
            <div class="table-container">
                <table class="display table-bordered border border-opacity-50" id="videoLecturesTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Week Number</th>
                            <th>Youtube Video URL</th>
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
    <div class="modal fade" id="editVideoLectureModal" tabindex="-1" aria-labelledby="editVideoLectureModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form id="updateVideoLectureForm" class="needs-validation" novalidate>
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <h5 class="modal-title fw-semibold" id="editVideoLectureModalLabel">Edit Video Lecture</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col">
                                <div class="form-floating">
                                    <input type="url" class="form-control" id="videoUrl" name="video_url"
                                        placeholder="Video URL" required>
                                    <label for="videoUrl">Youtube Video URL</label>
                                    <div class="invalid-feedback text-danger">
                                        Please enter the youtube video URL.
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-floating">
                                    <input type="number" class="form-control" id="weekNumber" name="week_number"
                                        placeholder="Week Number" required>
                                    <label for="weekNumber">Week Number</label>
                                    <div class="invalid-feedback text-danger">
                                        Please enter the week number.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 py-1">
                        <button type="button" class="btn btn-secondary py-0" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary py-0">Save changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="createVideoLectureModal" tabindex="-1" aria-labelledby="createVideoLectureModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form id="createVideoLectureForm" class="needs-validation" novalidate>
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <h5 class="modal-title fw-semibold" id="createVideoLectureModalLabel">Create Video Lecture</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="newVideoUrl" placeholder="Lesson Title"
                                        required>
                                    <label for="newVideoUrl">Youtube Video URL</label>
                                    <div class="invalid-feedback text-danger">
                                        Please enter the youtube video URL.
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-floating">
                                    <input type="number" class="form-control" id="newWeekNumber"
                                        placeholder="Week Number" required>
                                    <label for="newWeekNumber">Week Number</label>
                                    <div class="invalid-feedback text-danger">
                                        Please enter the week number.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 py-1">
                        <button type="button" class="btn btn-secondary py-0" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary py-0">Create</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php include("../includes/scripts.php"); ?>
    <script src="../assets/js/admin/components.js"></script>
    <script src="../assets/js/admin/manageVideoLectures.js"></script>
</body>

</html>