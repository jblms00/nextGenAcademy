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
            <h1>Manage</h1>
            <button type="button" class="btn btn-primary add-lesson py-0" data-bs-toggle="modal"
                data-bs-target="#createGroupModal">Create Group</button>
        </div>
        <div class="container">
            <div class="table-container">
                <table class="display table-bordered border border-opacity-50" id="groupTable">
                    <thead>
                        <tr>
                            <th>Group For</th>
                            <th>Group Project Title</th>
                            <th>Group Status</th>
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
    <div class="modal fade" id="createGroupModal" tabindex="-1" aria-labelledby="createGroupModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="createGroupModalLabel">Create New Group</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="createGroupForm" class="needs-validation" novalidate>
                    <div class="modal-body">
                        <div class="mb-3">
                            <p class="mb-0 fw-semibold">Lesson</p>
                            <select class="form-select" id="lessonSelect" name="lesson_id" required>
                                <option selected disabled value="">Select a lesson</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select a lesson.
                            </div>
                        </div>
                        <div class="mb-3">
                            <p class="mb-0 fw-semibold">Project Title</p>
                            <input type="text" class="form-control" id="projectTitle" name="project_title" required>
                            <div class="invalid-feedback">
                                Please provide a project title.
                            </div>
                        </div>
                        <div class="mb-3">
                            <p class="mb-0 fw-semibold">Select Members (Max 4)</p>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="memberDropdown"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Choose Members
                                </button>
                                <ul class="dropdown-menu w-50" id="memberSelect" aria-labelledby="memberDropdown"></ul>
                            </div>
                            <div class="invalid-feedback">
                                Please select up to 4 members.
                            </div>
                        </div>
                        <input type="hidden" id="selectedMembers" name="selected_members">
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary py-0" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Create Group</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editGroupModal" tabindex="-1" aria-labelledby="editGroupModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="editGroupForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editGroupModalLabel">Edit Group</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="groupId" id="editGroupId" value="">
                        <div class="mb-3">
                            <p class="fw-semibold mb-0">Lesson Title</p>
                            <select id="editLessonSelect" name="lesson_id" class="form-select" required>
                                <option selected disabled value="">Select a lesson</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <p class="fw-semibold mb-0">Project Title</p>
                            <input type="text" class="form-control" id="editProjectTitle" name="project_title" required>
                        </div>
                        <div class="mb-3">
                            <p class="fw-semibold mb-0">Group Members</p>
                            <table class="table table-bordered table-sm" id="groupMembersTable">
                                <thead>
                                    <tr>
                                        <th>Member Name</th>
                                        <th style="width: 10%;">Action</th>
                                    </tr>
                                </thead>
                                <tbody><!-- Members will be dynamically loaded here --></tbody>
                            </table>
                        </div>
                        <div class="mb-3">
                            <p class="fw-semibold mb-0">Add Members</p>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="addMemberDropdown"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Select Members
                                </button>
                                <ul class="dropdown-menu w-100" id="availableMembersDropdown"></ul>
                            </div>
                        </div>
                        <input type="hidden" id="selectedMembers" name="selected_members" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Group</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="assignTaskModal" tabindex="-1" aria-labelledby="assignTaskModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="assignTaskModalLabel">Group Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-container mb-3">
                        <table class="table table-bordered table-sm" id="tasksTable">
                            <thead>
                                <th>#</th>
                                <th>Task</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <form id="assignTaskForm" class="needs-validation" novalidate>
                        <input type="hidden" name="group_id" value="">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="taskTitle" name="task_title"
                                placeholder="Task Title" required>
                            <label for="taskTitle">Task Title</label>
                            <div class="invalid-feedback">Please enter a task title.</div>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea class="form-control" placeholder="Leave a description here" id="taskDescription"
                                name="task_description" required></textarea>
                            <label for="taskDescription">Task Description</label>
                            <div class="invalid-feedback">Please enter a task description.</div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary rounded-pill w-25"
                                style="background-color: var(--bg-color5);">Add Task</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php include("../includes/scripts.php"); ?>
    <script src="../assets/js/admin/components.js"></script>
    <script src="../assets/js/admin/manageGroup.js"></script>
</body>

</html>