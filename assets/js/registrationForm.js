const toastMessage = $("#liveToast .toast-body p");

$(document).ready(function () {
    displayForm();
    userLogin();
    handle2FA();
    userRegister();
    findAccount();
    resetPassword();
    setupEmailResendCodeButton();
    verifyEmail();
    createNewPassword();
});

function displayForm() {
    $(document).on("click", ".homepage .select-form", function () {
        var button = $(this);
        var contentHTML =
            button.text() === "Register"
                ? getRegistrationForm()
                : getLoginForm();

        $(".homepage .container").html(contentHTML);
    });

    $(document).on("click", ".switch-form", function (e) {
        e.preventDefault();
        var isRegisterLink = $(this).text() === "Login here.";
        var contentHTML = isRegisterLink
            ? getLoginForm()
            : getRegistrationForm();

        $(".homepage .container").html(contentHTML);
    });
}

function getRegistrationForm() {
    return `
        <div class="box-container">
            <form id="registrationForm" class="register needs-validation" novalidate>
                <h2 class="text-uppercase fw-bold">Register</h2>
                <div class="mb-3">
                    <label for="floatingName" class="mb-0">Full Name</label>
                    <input type="text" id="floatingName" class="form-control" placeholder="Full Name" required>
                    <div class="invalid-feedback fw-semibold">Please enter your full name.</div>
                </div>
                <div class="mb-3">
                    <label for="registrationFloatingEmail" class="mb-0">Email address</label>
                    <input type="email" id="registrationFloatingEmail" class="form-control" placeholder="name@example.com" required>
                    <div class="invalid-feedback fw-semibold">Please enter a valid email address.</div>
                </div>
                <div class="mb-3">
                    <label for="registrationFloatingPassword" class="mb-0">Password</label>
                    <input type="password" id="registrationFloatingPassword" class="form-control" placeholder="Password" required>
                    <div class="invalid-feedback fw-semibold">Please enter your password.</div>
                </div>
                <div class="mb-5">
                    <label for="floatingConfirmPassword" class="mb-0">Confirm Password</label>
                    <input type="password" id="floatingConfirmPassword" class="form-control" placeholder="Confirm Password" required>
                    <div class="invalid-feedback fw-semibold">Please confirm your password.</div>
                </div>
                <div class="row mb-4">
                    <div class="col text-center">
                        <button type="submit" class="btn btn-primary rounded-pill w-50 py-0 register-account">Register</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col text-center">
                        <p>Already have an account? <span>
                            <a href="#" class="text-light fw-semibold switch-form">Login here.</a>
                        </span></p>
                    </div>
                </div>
            </form>
        </div>
    `;
}

function get2FAForm() {
    return `
        <div class="box-container">
            <form id="2faForm" class="needs-validation" novalidate>
                <h2 class="text-uppercase fw-bold">Enter 2FA Code</h2>
                <div class="mb-3">
                    <label for="2faCode" class="mb-0">Verification Code</label>
                    <input type="hidden" id="verifyingUserId" class="form-control">
                    <input type="text" id="2faCode" class="form-control" placeholder="Enter your 2FA code" required>
                    <div class="invalid-feedback fw-semibold">Please enter the 2FA code sent to you.</div>
                </div>
                <div class="row mb-4">
                    <div class="col text-center">
                        <button type="submit" class="btn btn-primary rounded-pill w-50 py-0">Verify</button>
                    </div>
                </div>
            </form>
        </div>
    `;
}

function getLoginForm() {
    return `
        <div class="box-container">
            <form id="loginForm" class="login needs-validation" novalidate>
                <h2 class="text-uppercase fw-bold">Login</h2>
                <div class="mb-3">
                    <label for="loginFloatingEmail" class="mb-0">Email address</label>
                    <input type="email" id="loginFloatingEmail" class="form-control" placeholder="name@example.com" required>
                    <div class="invalid-feedback fw-semibold">Please enter your email address.</div>
                </div>
                <div class="mb-4">
                    <p for="loginFloatingPassword" class="mb-0">Password</p>
                    <input type="password" id="loginFloatingPassword" class="form-control" placeholder="Password" required>
                    <div class="invalid-feedback fw-semibold">Please enter your password.</div>
                    <div class="mt-2">
                        <a href="#" class="text-light fw-semibold mt-4 text-decoration-none" data-bs-toggle="modal" data-bs-target="#modalForgotPassword">Forgot Password?</a>
                    </div>
                </div>
                <hr>
                <div class="row mb-2">
                    <div class="col text-center">
                        <button type="submit" class="btn btn-primary rounded-pill w-50 py-0 login-account">Login</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col text-center">
                        <p>Don't have an account? <span>
                            <a href="#" class="text-light fw-semibold switch-form">Register here.</a>
                        </span></p>
                    </div>
                </div>
            </form>
        </div>
    `;
}

function userLogin() {
    $(document).on("submit", "#loginForm", function (event) {
        event.preventDefault();
        var form = $(this);
        var userEmail = form.find("#loginFloatingEmail").val();
        var userPassword = form.find("#loginFloatingPassword").val();

        if (!form[0].checkValidity()) {
            form.addClass("was-validated");
            return;
        }

        $.ajax({
            method: "POST",
            url: "phpscripts/user-login.php",
            data: { userEmail: userEmail, userPassword: userPassword },
            dataType: "json",
            success: function (response) {
                if (response.status === "2fa_required") {
                    $(".homepage .container").html(get2FAForm());
                    $("#verifyingUserId").val(response.userId);
                } else {
                    toastMessage
                        .text(response.message)
                        .addClass("text-danger")
                        .removeClass("text-success");
                    $("#liveToast").toast("show");
                }
            },
            error: function (xhr, status, error) {
                console.log(error);
            },
        });
    });
}

function handle2FA() {
    $(document).on("submit", "#2faForm", function (event) {
        event.preventDefault();
        var form = $(this);
        var code = form.find("#2faCode").val();
        var verifyingUserId = form.find("#verifyingUserId").val();

        if (!form[0].checkValidity()) {
            form.addClass("was-validated");
            return;
        }

        $.ajax({
            method: "POST",
            url: "phpscripts/verify-2fa.php",
            data: { code: code, verifyingUserId: verifyingUserId },
            dataType: "json",
            success: function (response) {
                if (response.status === "success") {
                    toastMessage
                        .text(response.message)
                        .addClass("text-success")
                        .removeClass("text-danger");
                    $("#liveToast").toast("show");
                    $("button, input").prop("disabled", true);
                    $("a")
                        .addClass("disabled")
                        .on("click", function (e) {
                            e.preventDefault();
                        });

                    toastMessage.fadeOut(3000, function () {
                        if (response.user_type === "user") {
                            window.location.href = "user/lessons";
                        } else if (response.user_type === "admin") {
                            window.location.href = "admin/dashboard";
                        }
                    });
                } else {
                    toastMessage
                        .text(response.message)
                        .addClass("text-danger")
                        .removeClass("text-success");
                    $("#liveToast").toast("show");
                }
            },
            error: function (xhr, status, error) {
                console.log("AJAX Error:", status, error);
            },
        });
    });
}

function userRegister() {
    $(document).on("submit", "#registrationForm", function (event) {
        event.preventDefault();
        var form = $(this);

        var fullName = form.find("#floatingName").val();
        var email = form.find("#registrationFloatingEmail").val();
        var password = form.find("#registrationFloatingPassword").val();
        var confirmPassword = form.find("#floatingConfirmPassword").val();

        if (!form[0].checkValidity()) {
            form.addClass("was-validated");
            return;
        }

        $.ajax({
            method: "POST",
            url: "phpscripts/user-signup.php",
            data: {
                fullName: fullName,
                email: email,
                password: password,
                confirmPassword: confirmPassword,
            },
            dataType: "json",
            success: function (response) {
                if (response.status === "success") {
                    toastMessage
                        .text(response.message)
                        .addClass("text-success")
                        .removeClass("text-danger");
                    $("#liveToast").toast("show");

                    toastMessage.fadeOut(3000, function () {
                        $(".homepage .container").html(getLoginForm());
                    });
                } else {
                    toastMessage
                        .text(response.message)
                        .addClass("text-danger")
                        .removeClass("text-success");
                    $("#liveToast").toast("show");
                }
            },
            error: function (xhr, status, error) {
                console.log("AJAX Error:", status, error);
            },
        });
    });
}

function findAccount() {
    $(document).on("click", ".btn-find", function () {
        var modalContent = $(this).closest(".modal-content");
        var user_account = $(this)
            .closest(".modal-content")
            .find("#findEmail")
            .val();

        $.ajax({
            method: "POST",
            url: "phpscripts/fetch-user-account.php",
            data: { user_account, user_account },
            dataType: "json",
            success: function (response) {
                if (response.status === "success") {
                    toastMessage
                        .text(response.message)
                        .addClass("text-success")
                        .removeClass("text-danger");
                    $("#liveToast").toast("show");

                    var newModalContent = `
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="container-fluid p-0">
                                    <div class="row mb-2">
                                        <div class="col">
                                            <div class="user-photo text-center">
                                                <p class="fw-bold">${response.account_info.user_name}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <p class="fw-light">Is this your account? If it is, please type <span class="fw-bold">'yes'</span> to confirm: <span><input type="text" id="userConfirmaton" autocomplete="off"></span></p>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col text-center">
                                            <button type="button" class="btn btn-primary py-0 btn-reset-password w-50" data-user-id="${response.account_info.user_id}">Reset Password</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    modalContent.find("button, input").prop("disabled", true);

                    modalContent.fadeOut(2500, function () {
                        modalContent.replaceWith(newModalContent);
                        modalContent.fadeIn(2500);
                    });
                } else {
                    toastMessage
                        .text(response.message)
                        .addClass("text-danger")
                        .removeClass("text-success");
                    $("#liveToast").toast("show");
                }
            },
            error: function (xhr, status, error) {
                console.log("AJAX Error:", error);
            },
        });
    });
}

function resetPassword() {
    $(document).on("click", ".btn-reset-password", function () {
        var modalContent = $(this).closest(".modal-content");
        var user_id = $(this).data("user-id");
        var user_confirmation = $(this)
            .closest(".modal-content")
            .find("#userConfirmaton")
            .val();

        $.ajax({
            method: "POST",
            url: "phpscripts/user-reset-password.php",
            data: { user_id, user_id, user_confirmation: user_confirmation },
            dataType: "json",
            success: function (response) {
                if (response.status === "success") {
                    toastMessage
                        .text(response.message)
                        .addClass("text-success")
                        .removeClass("text-danger");
                    $("#liveToast").toast("show");

                    var newModalContent = `
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="container-fluid p-0">
                                    <div class="row mb-3">
                                        <div class="col text-center">
                                            <h3 class="fw-bold">Verify Code</h3>
                                            <p>Check your email, you'll receive a code to verify here so you can reset your account password.</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-floating mb-3">
                                                <input type="text" id="inputCode" class="form-control" autocomplete="off" required>
                                                <input type="hidden" id="userId" class="form-control" value="${user_id}" autocomplete="off" required>
                                                <label for="inputCode">Verification Code</label>
                                                <div class="valid-feedback">Verification code is valid!</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col text-center">
                                            <button type="button" class="btn btn-primary py-0 btn-verify w-50" data-user-id="${user_id}">Verify</button>
                                        </div>
                                    </div>
                                    <div class="text-center my-2">
                                        <span class="countdownDisplay"></span><br>
                                        <p>Didn't receive the code? <span> <button id="resendCodeButton" class="btn btn-link p-0 m-0"
                                                    style="font-size: 15px;">Send code again.</button></span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    modalContent.find("button, input").prop("disabled", true);

                    modalContent.fadeOut(2500, function () {
                        modalContent.replaceWith(newModalContent);
                        modalContent.fadeIn(2500);
                    });

                    setupEmailResendCodeButton();
                } else {
                    toastMessage
                        .text(response.message)
                        .addClass("text-danger")
                        .removeClass("text-success");
                    $("#liveToast").toast("show");
                }
            },
            error: function (xhr, status, error) {
                console.log("AJAX Error:", error);
            },
        });
    });
}

function setupEmailResendCodeButton() {
    $(document).on("click", "#resendCodeButton", function () {
        var resendCodeButton = $(this);
        var countdownDisplay = $(".countdownDisplay");
        var countdown;

        if (!$(this).hasClass("disabled")) {
            resendEmailVerificationCode();
            $(this).addClass("disabled");
            var timeLeft = 59;
            countdownDisplay.text(`Send code in ${timeLeft} seconds`);
            countdown = setInterval(function () {
                timeLeft--;
                countdownDisplay.text(`Send code in ${timeLeft} seconds`);
                if (timeLeft <= 0) {
                    clearInterval(countdown);
                    $(resendCodeButton).removeClass("disabled");
                    countdownDisplay.text("");
                }
            }, 1000);
        }
    });
}

function resendEmailVerificationCode() {
    var userId = $("#userId").val();

    $.ajax({
        method: "POST",
        url: "phpscripts/resend-email-verification-code.php",
        data: { userId: userId },
        dataType: "json",
        success: function (response) {
            if (response.status === "success") {
                toastMessage
                    .text(response.message)
                    .addClass("text-success")
                    .removeClass("text-danger");
                $("#liveToast").toast("show");
            } else {
                toastMessage
                    .text(response.message)
                    .addClass("text-danger")
                    .removeClass("text-success");
                $("#liveToast").toast("show");
            }
        },
        error: function (xhr, status, error) {
            console.log(error);
        },
    });
}

function verifyEmail() {
    $(document).on("click", ".btn-verify", function () {
        var modalContent = $(this).closest(".modal-content");
        var verification_code = modalContent.find("#inputCode").val();
        var user_id = $(this).data("user-id");

        $.ajax({
            method: "POST",
            url: "phpscripts/user-verify-code.php",
            data: { verification_code: verification_code },
            dataType: "json",
            success: function (response) {
                if (response.status === "success") {
                    toastMessage
                        .text(response.message)
                        .addClass("text-success")
                        .removeClass("text-danger");
                    $("#liveToast").toast("show");

                    var newModalContent = `
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="container-fluid p-0">
                                    <div class="row mb-3">
                                        <div class="col">
                                            <div class="form-floating mb-3">
                                                <input type="password" id="newPassword" class="form-control" autocomplete="off">
                                                <label for="newPassword">New Password</label>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col">
                                            <div class="form-floating mb-3">
                                                <input type="password" id="confirmNewPassword" class="form-control" autocomplete="off">
                                                <label for="confirmNewPassword">Confirm New Password</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col text-center">
                                            <button type="button" class="btn btn-primary py-0 submit-new-password w-50" data-user-id="${user_id}">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    modalContent.find("button, input").prop("disabled", true);

                    modalContent.fadeOut(2500, function () {
                        modalContent.replaceWith(newModalContent);
                        modalContent.fadeIn(2500);
                    });
                } else {
                    toastMessage
                        .text(response.message)
                        .addClass("text-danger")
                        .removeClass("text-success");
                    $("#liveToast").toast("show");
                }
            },
            error: function (xhr, status, error) {
                console.log("AJAX Error:", error);
            },
        });
    });
}

function createNewPassword() {
    $(document).on("click", ".submit-new-password", function () {
        var user_id = $(this).data("user-id");
        var new_password = $(this)
            .closest(".modal-content")
            .find("#newPassword")
            .val();
        var confirm_new_password = $(this)
            .closest(".modal-content")
            .find("#confirmNewPassword")
            .val();

        $.ajax({
            method: "POST",
            url: "phpscripts/user-create-new-password.php",
            data: {
                new_password: new_password,
                confirm_new_password: confirm_new_password,
                user_id: user_id,
            },
            dataType: "json",
            success: function (response) {
                if (response.status === "success") {
                    $("button, input").prop("disabled", true);
                    $("a")
                        .addClass("disabled")
                        .on("click", function (e) {
                            e.preventDefault();
                        });

                    toastMessage
                        .text(response.message)
                        .addClass("text-success")
                        .removeClass("text-danger");
                    $("#liveToast").toast("show");

                    setTimeout(function () {
                        window.location.reload();
                    }, 3000);
                } else {
                    toastMessage
                        .text(response.message)
                        .addClass("text-danger")
                        .removeClass("text-success");
                    $("#liveToast").toast("show");
                }
            },
            error: function (xhr, status, error) {
                console.log("AJAX Error:", error);
            },
        });
    });
}
