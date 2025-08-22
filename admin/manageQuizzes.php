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
            <h1>Manage Quizzes</h1>
            <button type="button" class="btn btn-primary add-quiz py-0" data-bs-toggle="modal"
                data-bs-target="#addQuizQuestionModal">Add Question on Quiz</button>
        </div>
        <div class="container">
            <div class="table-container">
                <table class="display table-bordered border border-opacity-50" id="quizzesTable">
                    <thead>
                        <tr>
                            <th>Topic</th>
                            <th>Week Number</th>
                            <th>Total Questions</th>
                            <th>Type of Questions</th>
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
    <div class="modal fade" id="editQuizModal" tabindex="-1" aria-labelledby="editQuizModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editQuizForm" novalidate>
                    <div class="modal-header border-0">
                        <h5 class="modal-title" id="editQuizModalLabel">Edit Quiz</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-0">
                        <div class="mb-3">
                            <h6 class="mb-0 fw-semibold">Quiz Topic: <span id="quizTopic" class="fw-normal"></span></h6>
                        </div>
                        <div id="quizQuestionsContainer">
                            <!-- Existing questions will be populated here -->
                        </div>
                    </div>
                    <div class="modal-footer border-0 py-1">
                        <button type="button" class="btn btn-secondary py-0" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary update-quiz">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addQuizQuestionModal" tabindex="-1" aria-labelledby="addQuizQuestionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="createQuizForm" novalidate>
                    <div class="modal-header">
                        <h5 class="modal-title" id="addQuizQuestionModalLabel">Create New Quiz</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-4">
                            <label for="newQuizTopic" class="form-label mb-0 fw-semibold">Quiz Topic</label>
                            <select class="form-select form-select-lg" id="newQuizTopic" required>
                                <option selected disabled>Please select quiz topic</option>
                                <!-- Options should be populated dynamically -->
                            </select>
                            <div class="invalid-feedback text-danger">Please select a quiz topic.</div>
                        </div>
                        <div id="newQuizQuestionsContainer">
                            <div class="mb-4 question-container">
                                <label for="question-0" class="form-label mb-0 fw-semibold">Question 1:</label>
                                <input type="text" class="form-control" id="question-0" required>
                                <div class="choices-container mt-2">
                                    <label class="form-label mb-0 fw-semibold">Choices:</label>
                                    <input type="text" class="form-control mb-1 choice-input" placeholder="Choice A"
                                        required>
                                    <input type="text" class="form-control mb-1 choice-input" placeholder="Choice B"
                                        required>
                                    <input type="text" class="form-control mb-1 choice-input" placeholder="Choice C"
                                        required>
                                    <input type="text" class="form-control mb-3 choice-input" placeholder="Choice D"
                                        required>
                                    <span class="fw-semibold">Correct Answer: </span>
                                    <input type="text" class="form-control correct-answer" required>
                                    <div class="invalid-feedback text-danger">All choices and the correct answer must be
                                        filled.</div>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-secondary" id="addQuestionButton">Add Another
                            Question</button>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="createQuizButton">Create Quiz</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php include("../includes/scripts.php"); ?>
    <script src="../assets/js/admin/components.js"></script>
    <script src="../assets/js/admin/manageQuizzes.js"></script>
</body>

</html>