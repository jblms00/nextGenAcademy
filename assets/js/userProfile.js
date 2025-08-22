$(document).ready(function () {
    updateProfile();
    changePassword();
    verifyEmail();

    var userProfileUrl = $("body").data("user-profile");
    $(".profile-pic").css(
        "background-image",
        "url(../assets/images/usersProfile/" + userProfileUrl + ")"
    );

    $("#fileToUpload").on("change", function (event) {
        var imageUrl = URL.createObjectURL(event.target.files[0]);
        $(".profile-pic").css("background-image", "url(" + imageUrl + ")");
    });

    $("#modalChangePassword").on("hidden.bs.modal", function () {
        $("#userOldPassword").val("");
        $("#userNewPassword").val("");
        $("#userConfirmPassword").val("");
    });
});

function updateProfile() {
    $(document).on("click", ".update-profile", function () {
        var formData = new FormData();
        formData.append("fileToUpload", $("#fileToUpload")[0].files[0]);
        formData.append("user_name", $("#userName").val());

        $.ajax({
            url: "../phpscripts/user-update-profile.php",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (response) {
                var toastMessage = $("#liveToast .toast-body p");
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
                        location.reload();
                    }, 2000);
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

function changePassword() {
    $(document).on("click", ".change-password", function () {
        var modalContent = $(this).closest(".modal-content");
        var user_id = $("body").data("user-id");
        var user_email = $("body").data("user-email");
        var old_password = $("#userOldPassword").val();
        var new_password = $("#userNewPassword").val();
        var confirm_new_password = $("#userConfirmPassword").val();

        var messageContainer = modalContent.find(".message-container");
        messageContainer.find(".success-message, .error-message").hide();

        $.ajax({
            method: "POST",
            url: "../phpscripts/user-verify-password.php",
            data: {
                user_id,
                user_email,
                old_password,
                new_password,
                confirm_new_password,
            },
            dataType: "json",
            success: function (response) {
                if (response.status === "success") {
                    var newModalContent = `
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="container-fluid p-0">
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-floating mb-3">
                                                <input type="text" id="inputCode" class="form-control" autocomplete="off" required>
                                                <label for="inputCode">Verification Code</label>
                                                <div class="valid-feedback">Verification code is valid!</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col">
                                            <button type="button" class="btn btn-success btn-verify w-100" data-user-id="${user_id}" data-new-password="${new_password}">Verify</button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="message-container d-flex justify-content-center"></div>
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
                    $("#liveToast .toast-body p")
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

function verifyEmail() {
    $(document).on("click", ".btn-verify", function () {
        var modalContent = $(this).closest(".modal-content");
        var verification_code = modalContent.find("#inputCode").val();
        var user_id = $(this).data("user-id");
        var new_password = $(this).data("new-password");

        var messageContainer = modalContent.find(".message-container");
        messageContainer.find(".success-message, .error-message").hide();

        $.ajax({
            method: "POST",
            url: "../phpscripts/user-change-password.php",
            data: { verification_code: verification_code, new_password },
            dataType: "json",
            success: function (response) {
                if (response.status === "success") {
                    $("input, button").prop("disabled", true);

                    $("a")
                        .addClass("disabled")
                        .on("click", function (e) {
                            e.preventDefault();
                        });

                    $("#liveToast .toast-body p")
                        .text(response.message)
                        .addClass("text-success")
                        .removeClass("text-danger");
                    $("#liveToast").toast("show");

                    setTimeout(function () {
                        location.reload();
                    }, 3000);
                } else {
                    var errorMessage = $(
                        "<div class='alert alert-danger error-message text-center w-100 mb-0 p-2 px-4' role='alert'>" +
                            response.message +
                            "</div>"
                    );
                    $(".error-message").remove();
                    $(".message-container").append(errorMessage);
                    errorMessage.fadeOut(3000);
                }
            },
            error: function (xhr, status, error) {
                console.log("AJAX Error:", error);
            },
        });
    });
}
