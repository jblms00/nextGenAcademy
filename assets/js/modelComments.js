const loggedInUserId = $("body").data("user-id");
const userName = $("body").data("user-name");
const userProfile = $("body").data("user-photo");
const toastMessage = $("#liveToast .toast-body p");

const weekNumber = urlParams.get("weekNumber");
const id = urlParams.get("id");
const modelName = urlParams.get("modelName");

$(document).ready(function () {
    loadComments();
    postComment();
    manageComment();
});

function loadComments() {
    $.ajax({
        url: "../phpscripts/fetch-model-comments.php",
        method: "GET",
        data: { model_id: mid },
        dataType: "json",
        success: function (response) {
            if (response.status === "success") {
                $("#commentSection").empty();

                var comments = response.comments;
                comments.forEach(function (comment) {
                    var optionHtml = "";

                    if (String(loggedInUserId) == String(comment.user_id)) {
                        optionHtml = `
                            <div class="ms-auto me-3 option">
                                <div class="dropdown">
                                    <i class="fa-solid fa-ellipsis" data-bs-toggle="dropdown"></i>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item edit-comment" data-comment-id="${comment.model_comment_id}" data-comment-text="${comment.comment_text}" href="#">Edit</a></li>
                                        <li><a class="dropdown-item delete-comment" data-comment-id="${comment.model_comment_id}" href="#">Delete</a></li>
                                    </ul>
                                </div>
                            </div>
                        `;
                    }

                    var commentHTML = `
                        <div class="comment my-2">
                            <div class="user-data d-flex align-items-center gap-2 mb-3">
                                <img src="${
                                    comment.user_photo ||
                                    "../assets/images/usersProfile/default-profile.png"
                                }"
                                     class="border-1 bg-light rounded-circle" width="40" height="100%" alt="img">
                                <h6 class="mb-0 text-light">${
                                    comment.user_name
                                }</h6>
                                ${optionHtml}
                            </div>
                            <div class="user-comment text-light">
                                ${comment.comment_text}
                            </div>
                        </div>
                    `;
                    $("#commentSection").append(commentHTML);
                });

                $(".edit-comment").click(function () {
                    var commentId = $(this).data("comment-id");
                    var commentText = $(this).data("comment-text");
                    $("#editCommentInput").val(commentText);
                    $("#editCommentId").val(commentId);
                    $("#editCommentModal").modal("show");
                });

                $(".delete-comment").click(function () {
                    var commentId = $(this).data("comment-id");
                    $("#confirmDeletion").val(commentId);
                    $("#deleteConfirmationModal").modal("show");
                });
            } else {
                console.error("Error fetching comments: " + response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error("AJAX error: " + error);
        },
    });
}

function postComment() {
    $(document).on("click", "#postCommentButton", function () {
        var comment = $("#inputComment").val();

        if (comment.trim() === "") {
            toastMessage
                .text("Comment cannot be empty.")
                .addClass("text-danger")
                .removeClass("text-success");
            $("#liveToast").toast("show");
            return;
        }

        $.ajax({
            url: "../phpscripts/user-add-model-comment.php",
            method: "POST",
            data: {
                model_id: mid,
                comment_text: comment,
                user_id: loggedInUserId,
            },
            dataType: "json",
            success: function (response) {
                if (response.status === "success") {
                    var commentHtml = `
                        <div class="comment my-2">
                            <div class="user-data d-flex align-items-center gap-2 mb-3">
                                <img src="../assets/images/usersProfile/${userProfile}"
                                    class="border-1 bg-light rounded-circle" width="40" height="100%" alt="img">
                                <h6 class="mb-0 text-light">${userName}</h6>
                                <div class="ms-auto me-3 option">
                                    <div class="dropdown">
                                        <i class="fa-solid fa-ellipsis" data-bs-toggle="dropdown">
                                        </i>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item edit-comment" data-comment-id="${response.model_comment_id}" href="#">Edit</a></li>
                                            <li><a class="dropdown-item delete-comment" data-comment-id="${response.model_comment_id}" href="#">Delete</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="user-comment text-light">${comment}</div>
                        </div>
                    `;
                    $("#commentSection").prepend(commentHtml);
                    $("#inputComment").val("");
                    loadComments();
                } else {
                    console.error("Error posting comment: " + response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX error: " + error);
            },
        });
    });
}

function manageComment() {
    $(document).on("click", "#saveEditCommentButton", function () {
        var commentId = $("#editCommentId").val();
        var updatedCommentText = $("#editCommentInput").val().trim();

        if (updatedCommentText === "") {
            toastMessage
                .text("Comment cannot be empty.")
                .addClass("text-danger")
                .removeClass("text-success");
            $("#liveToast").toast("show");
            return;
        }

        $.ajax({
            url: "../phpscripts/user-edit-model-comment.php",
            method: "POST",
            data: {
                logged_in_user_id: loggedInUserId,
                model_comment_id: commentId,
                comment_text: updatedCommentText,
            },
            dataType: "json",
            success: function (response) {
                if (response.status === "success") {
                    toastMessage
                        .text("Comment updated successfully.")
                        .addClass("text-success")
                        .removeClass("text-danger");
                    $("#liveToast").toast("show");
                    $("#editCommentModal").modal("hide");
                    loadComments();
                } else {
                    console.error(
                        "Error updating comment: " + response.message
                    );
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX error: " + error);
            },
        });
    });

    $(document).on("click", ".confirm-deletion", function () {
        var commentId = $("#confirmDeletion").val();

        $.ajax({
            url: "../phpscripts/user-delete-model-comment.php",
            method: "POST",
            data: {
                logged_in_user_id: loggedInUserId,
                model_comment_id: commentId,
            },
            dataType: "json",
            success: function (response) {
                if (response.status === "success") {
                    $("#deleteConfirmationModal").modal("hide");
                    $("#confirmDeletion").val("");
                    loadComments();
                } else {
                    console.error(
                        "Error deleting comment: " + response.message
                    );
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX error: " + error);
            },
        });
    });
}

function formatTime(datetime) {
    var date = new Date(datetime);
    return date.toLocaleString("en-US", {
        hour: "numeric",
        minute: "numeric",
        hour12: true,
        month: "long",
        day: "numeric",
        year: "numeric",
    });
}
