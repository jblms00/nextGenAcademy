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

<body class="admin-side">
    <?php include("../includes/components/admin/navbar.php"); ?>
    <main>
        <div class="page-title d-flex align-items-center justify-content-between">
            <h1>Manage Lessons</h1>
            <button type="button" class="btn btn-primary add-lesson py-0" data-bs-toggle="modal"
                data-bs-target="#createLessonModal">Add New Lesson</button>
        </div>
        <div class="container">
            <div class="table-container">
                <table class="display table-bordered border border-opacity-50" id="lessonsTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Week Number</th>
                            <th>Lesson Title</th>
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
    <div class="modal fade" id="editLessonModal" tabindex="-1" aria-labelledby="editLessonModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form id="updateLessonForm" class="needs-validation" novalidate>
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <h5 class="modal-title fw-semibold" id="editLessonModalLabel">Edit Lesson</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="lessonTitle" name="lesson_title"
                                        placeholder="Lesson Title" required>
                                    <label for="lessonTitle">Lesson Title</label>
                                    <div class="invalid-feedback text-danger">
                                        Please enter the lesson title.
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
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
                        <div class="form-floating mb-3">
                            <p for="lessonDescription" class="form-label mb-0 fw-semibold">Lesson Description</p>
                            <textarea id="lessonDescription" name="lesson_description" placeholder="Lesson Description"
                                style="height: 120px;" required></textarea>
                            <div class="invalid-feedback">
                                Please enter the lesson description.
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col">
                                <p class="mb-0 fw-semibold">Lesson Banner</p>
                                <input type="file" class="form-control" id="lessonBanner" name="lessonBanner"
                                    accept="image/*" required>
                                <div class="invalid-feedback fw-semibold text-danger">Lesson banner is required.</div>
                            </div>
                        </div>
                        <div class="preview-container text-center">
                            <p class="mb-0 fw-semibold">Current Lesson Banner</p>
                            <img src="" alt="img" width="350" height="100%" id="previewBanner"
                                class="object-fit-contain">
                        </div>
                    </div>
                    <div class="modal-footer border-0 py-1">
                        <button type="button" class="btn btn-secondary py-0" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary py-0" id="updateLessonButton">Save changes</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
    <div class="modal fade" id="createLessonModal" tabindex="-1" aria-labelledby="createLessonModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form id="createLessonForm" class="needs-validation" novalidate>
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <h5 class="modal-title fw-semibold" id="createLessonModalLabel">Create New Lesson</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="newLessonTitle"
                                        placeholder="Lesson Title" required>
                                    <label for="newLessonTitle">Lesson Title</label>
                                    <div class="invalid-feedback text-danger">
                                        Please enter the lesson title.
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
                        <div class="form-floating mb-3">
                            <p for="newLessonDescription" class="form-label mb-0 fw-semibold">Lesson Description</p>
                            <textarea id="newLessonDescription" class="form-control" placeholder="Lesson Description"
                                style="height: 120px;" required></textarea>
                            <div class="invalid-feedback">Please enter the lesson description.</div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <p class="mb-0 fw-semibold">Lesson Banner</p>
                                <input type="file" class="form-control" id="newLessonBanner" name="lessonBanner"
                                    accept="image/*,video/*" required>
                                <div class="invalid-feedback fw-semibold text-danger">Lesson banner is required.</div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 py-1">
                        <button type="button" class="btn btn-secondary py-0" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary py-0">Create Lesson</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php include("../includes/scripts.php"); ?>
    <script src="../assets/js/admin/components.js"></script>
    <script src="../assets/js/admin/manageLessons.js"></script>
</body>

</html>