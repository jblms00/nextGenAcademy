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

<body class="admin-side admin-dashboard">
    <?php include("../includes/components/admin/navbar.php"); ?>
    <main>
        <div class="page-title">
            <h1>Dashboard</h1>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-4">
                    <div class="card">
                        <div class="card-title p-2 m-0">
                            <h6 class="fw-bold mb-0">Users</h6>
                        </div>
                        <hr class="divider m-0">
                        <div class="card-body">
                            <div id="userChart"></div>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card">
                        <div class="card-title p-2 m-0">
                            <h6 class="fw-bold mb-0">Quiz Attempts</h6>
                        </div>
                        <hr class="divider m-0">
                        <div class="card-body">
                            <div id="quizChart"></div>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card">
                        <div class="card-title p-2 m-0">
                            <h6 class="fw-bold mb-0">Group Task Progress</h6>
                        </div>
                        <hr class="divider m-0">
                        <div class="card-body">
                            <div id="taskProgressChart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php include("../includes/components/admin/toast.php"); ?>
    <?php include("../includes/components/admin/modal.php"); ?>
    <?php include("../includes/scripts.php"); ?>
    <script src="../assets/js/admin/dashboard.js"></script>
</body>

</html>