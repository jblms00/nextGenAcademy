<?php
session_start();

include("phpscripts/database-connection.php");
include("phpscripts/check-login.php");
include("phpscripts/admin/fetch-appearance.php");
$appearance = get_system_appearance($con);
?>
<!doctype html>
<html lang="en">

<head>
    <?php include("includes/header.php"); ?>
    <style>
        body {
            background-color: var(--bg-color1);
            background-image: url(assets/images/<?php echo htmlspecialchars($appearance['background']['file_name'], ENT_QUOTES); ?>);
            background-size: cover;
            height: 100%;
            overflow-x: hidden;
            font-size: 15px;
            position: relative;
        }

        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: -1;
            filter: blur(10px);
        }
    </style>
</head>

<body>
    <main class="homepage">
        <div class="container d-flex flex-column justify-content-center align-items-center gap-3"
            style="height: 100vh;">
            <div class="title text-center animation-downwards">
                <img src="assets/images/<?php echo htmlspecialchars($appearance['logo']['file_name'], ENT_QUOTES); ?>"
                    width="100%" height="300" alt="logo">
            </div>
            <div class="d-flex gap-3">
                <button type="button" class="btn btn-primary select-form rounded-pill animation-left"
                    style="width: 200px;">Register</button>
                <button type="button" class="btn btn-primary select-form rounded-pill animation-right"
                    style="width: 200px;">Login</button>
            </div>
        </div>
    </main>
    <?php include("includes/components/user/toast.php"); ?>
    <!-- Modal -->
    <div class="modal fade" id="modalForgotPassword" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid" id="containerContent">
                        <div class="row mb-3">
                            <div class="col text-center">
                                <h6 class="mb-0">Please enter your email to search for your account.</h6>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <div class="form-floating mb-1 text-center">
                                    <input type="email" class="form-control" id="findEmail"
                                        placeholder="name@example.com" autocomplete="off">
                                    <label for="findEmail">Email address</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col text-center">
                                <button type="button" class="btn btn-primary py-0 btn-find w-50">Find
                                    Account</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include("includes/scripts.php"); ?>
    <script src="assets/js/registrationForm.js"></script>
</body>

</html>