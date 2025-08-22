const loggedInUserId = $("body").data("user-id");
const userName = $("body").data("user-name");
const userProfile = $("body").data("user-photo");
const toastMessage = $("#liveToast .toast-body p");

$(document).ready(function () {
    var url = window.location.href;
    var urlObject = new URL(url);
    var params = urlObject.searchParams;
    var forumTopic =
        params.get("forumTitle") ||
        urlObject.search.split("?")[1].split("&")[0];
    var forumId = urlObject.search.split("&")[1];

    forumTopic = decodeURIComponent(forumTopic);
    $("#forumTitle").text(forumTopic);

    $("#editCommentModal").on("hidden.bs.modal", function () {
        $("#editCommentInput").val("");
        $("#editCommentId").val("");
    });

    $("#deleteConfirmationModal").on("hidden.bs.modal", function () {
        $("#confirmDeletion").val("");
    });

    getForumData(forumId);
    loadComments(forumId);
    postComment(forumId);
    manageComment(forumId, loggedInUserId);
});

function getForumData(forumId) {
    $.ajax({
        url: "../phpscripts/fetch-forum-data.php",
        method: "GET",
        data: { forum_id: forumId },
        dataType: "json",
        success: function (response) {
            if (response.status === "success") {
                var forum = response.forum;

                var userPhotoSrc = forum.user_photo
                    ? forum.user_photo
                    : "../assets/images/usersProfile/default-profile.png";
                $(".user-posted .user-profile img").attr(
                    "src",
                    "../assets/images/usersProfile/" + userPhotoSrc
                );

                $(".user-posted .post-info h4").text(forum.user_name);
                $(".user-posted .post-info small").text(
                    formatTime(forum.datetime_created)
                );
                $(".post-data .post-description").text(forum.forum_description);

                if (forum.forum_file_upload) {
                    $(".post-file-upload img").attr(
                        "src",
                        "../assets/uploadedFile/" + forum.forum_file_upload
                    );
                }
            } else {
                console.error("Error fetching forum data: " + response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error("AJAX error: " + error);
        },
    });
}

function loadComments(forumId) {
    $.ajax({
        url: "../phpscripts/fetch-forum-comments.php",
        method: "GET",
        data: { forum_id: forumId },
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
                                        <li><a class="dropdown-item edit-comment" data-comment-id="${comment.comment_id}" data-comment-text="${comment.comment_text}" href="#">Edit</a></li>
                                        <li><a class="dropdown-item delete-comment" data-comment-id="${comment.comment_id}" href="#">Delete</a></li>
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

function postComment(forumId) {
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
            url: "../phpscripts/user-add-comment.php",
            method: "POST",
            data: {
                forum_id: forumId,
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
                                            <li><a class="dropdown-item edit-comment" data-comment-id="${response.comment_id}" href="#">Edit</a></li>
                                            <li><a class="dropdown-item delete-comment" data-comment-id="${response.comment_id}" href="#">Delete</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="user-comment text-light">${comment}</div>
                        </div>
                    `;
                    $("#commentSection").prepend(commentHtml);
                    $("#inputComment").val("");
                    loadComments(forumId);
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

function manageComment(forumId, loggedInUserId) {
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
            url: "../phpscripts/user-edit-comment.php",
            method: "POST",
            data: {
                logged_in_user_id: loggedInUserId,
                comment_id: commentId,
                comment_text: updatedCommentText,
            },
            dataType: "json",
            success: function (response) {
                if (response.status === "success") {
                    $("#editCommentModal").modal("hide");
                    loadComments(forumId);
                    toastMessage
                        .text("Comment updated successfully.")
                        .addClass("text-success")
                        .removeClass("text-danger");
                    $("#liveToast").toast("show");
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
            url: "../phpscripts/user-delete-comment.php",
            method: "POST",
            data: {
                logged_in_user_id: loggedInUserId,
                comment_id: commentId,
            },
            dataType: "json",
            success: function (response) {
                if (response.status === "success") {
                    $("#deleteConfirmationModal").modal("hide");
                    $("#confirmDeletion").val("");
                    loadComments(forumId);
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
