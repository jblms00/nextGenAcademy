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
            <h1>Manage Users</h1>
            <button type="button" class="btn btn-primary py-0" data-bs-toggle="modal" data-bs-target="#addUserModal">Add
                New User</button>
        </div>
        <div class="container">
            <div class="table-container">
                <table class="display table-bordered border border-opacity-50" id="usersTable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>
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
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="addUserForm" class="needs-validation" novalidate>
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <h5 class="modal-title fw-semibold" id="addUserModalLabel">Add New User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="userName" placeholder="Complete Name" required>
                            <label for="userName">Complete Name</label>
                            <div class="invalid-feedback text-danger">
                                Please enter the complete name.
                            </div>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="userEmail" placeholder="name@example.com"
                                required>
                            <label for="userEmail">Email address</label>
                            <div class="invalid-feedback text-danger">
                                Please enter a valid email address.
                            </div>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="date" class="form-control" id="userBirthday" placeholder="Birthday" required>
                            <label for="userBirthday">Birthday</label>
                            <div class="invalid-feedback text-danger">
                                Please enter your birthday.
                            </div>
                        </div>
                        <select class="form-select" id="userStatus" required>
                            <option value="" disabled selected>Please select user status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                        <div class="invalid-feedback text-danger">
                            Please select a user status.
                        </div>
                    </div>
                    <div class="modal-footer border-0 py-1">
                        <button type="button" class="btn btn-secondary py-0" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary py-0">Create User</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php include("../includes/scripts.php"); ?>
    <script src="../assets/js/admin/components.js"></script>
    <script src="../assets/js/admin/manageUsers.js"></script>
</body>

</html>