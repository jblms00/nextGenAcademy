const loggedInUserId = $("body").data("user-id");
const toastMessage = $("#liveToast .toast-body p");

$(document).ready(function () {
    displayForums();
    displayRecentForums();
    postForum();
});

function displayForums() {
    $.ajax({
        url: "../phpscripts/fetch-forums.php",
        method: "GET",
        dataType: "json",
        success: function (response) {
            if (response.status === "success") {
                var forums = response.forums;
                var forumsHtml = "";

                if (forums.length > 0) {
                    forums.forEach(function (forum) {
                        var isUserForum = forum.user_id == loggedInUserId;

                        forumsHtml += `
                        <div class="card" data-forum-id="${
                            forum.forum_id
                        }" data-forum-title="${forum.forum_title}">
                            <div class="card-body">
                                <h4 class="card-title mb-2">${
                                    forum.forum_title
                                }</h4>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="fw-bold text-light">${formatDateTime(
                                        forum.datetime_created
                                    )}</small>
                                    ${
                                        isUserForum
                                            ? `
                                        <div class="mt-2">
                                            <button class="btn btn-warning btn-sm edit-forum py-0" data-forum-id="${forum.forum_id}" data-forum-title="${forum.forum_title}" data-forum-description="${forum.forum_description}">Edit</button>
                                            <button class="btn btn-danger btn-sm delete-forum py-0" data-forum-id="${forum.forum_id}">Delete</button>
                                        </div>`
                                            : ""
                                    }
                                </div>
                            </div>
                        </div>`;
                    });
                } else {
                    forumsHtml = `
                        <div class="no-forums-message text-center">
                            <h5 class="fw-bold text-danger">No forums available.</h5>
                        </div>`;
                    $("#forumsContainer").css("justify-content", "center");
                }
                $("#forumsContainer").html(forumsHtml);

                $(".card").on("click", function () {
                    var forumId = $(this).data("forum-id");
                    var forumTitle = $(this).data("forum-title");
                    window.location.href = `communityForumTopic?${forumTitle}&${forumId}`;
                });

                $(".edit-forum").on("click", function (e) {
                    e.stopPropagation();
                    var forumId = $(this).data("forum-id");
                    var forumTitle = $(this).data("forum-title");
                    var forumDescription = $(this).data("forum-description");

                    $("#forumTitle").val(forumTitle);
                    $("#forumDescription").val(forumDescription);
                    $("#forumEditModal").modal("show");
                    $("#modalConfirmButton")
                        .off("click")
                        .on("click", function () {
                            saveForumEdit(
                                forumId,
                                forumTitle,
                                forumDescription
                            );
                        });
                });

                $(".delete-forum").on("click", function (e) {
                    e.stopPropagation();
                    var forumId = $(this).data("forum-id");
                    $("#forumDeleteModal").modal("show");

                    $("#forumDeleteModal .btn.py-0")
                        .off("click")
                        .on("click", function () {
                            confirmForumDelete(forumId);
                        });
                });
            } else {
                console.error(response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error(error);
        },
    });
}

function displayRecentForums() {
    $.ajax({
        url: "../phpscripts/fetch-recent-forums.php",
        method: "GET",
        dataType: "json",
        success: function (response) {
            if (response.status === "success") {
                var forums = response.forums;
                var discussionsHtml = "";

                forums.forEach(function (forum) {
                    discussionsHtml += `
                    <li>
                        <h4 class="mb-0">${forum.forum_title}</h4>
                        <p class="mb-0">${forum.forum_description}</p>
                        <small class="fw-semibold text-danger">Posted on: ${formatDateTime(
                            forum.datetime_created
                        )}</small>
                        <hr>
                    </li>`;
                });

                $("#recentDiscussionsContainer").html(discussionsHtml);
            } else {
                $("#recentDiscussionsContainer").html(
                    "<li class='mt-3 text-danger fw-semibold'>No recent forums found.</li>"
                );
            }
        },
        error: function (xhr, status, error) {
            console.error("Error fetching recent forums: " + error);
        },
    });
}

function postForum() {
    $(document).on("submit", "#postForumForm", function (event) {
        event.preventDefault();
        var form = this;

        if (form.checkValidity() === false) {
            event.stopPropagation();
        } else {
            var formData = new FormData(this);
            formData.append("user_id", loggedInUserId);

            $.ajax({
                url: "../phpscripts/user-post-forum.php",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function (response) {
                    if (response.status === "success") {
                        toastMessage
                            .text(response.message)
                            .addClass("text-success")
                            .removeClass("text-danger");
                        $("#liveToast").toast("show");

                        $("#modalPostForum").modal("hide");
                        form.reset();
                        form.classList.remove("was-validated");
                        displayForums();
                        displayRecentForums();
                    } else {
                        toastMessage
                            .text(response.message)
                            .addClass("text-danger")
                            .removeClass("text-success");
                        $("#liveToast").toast("show");
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error posting forum: " + error);
                },
            });
        }

        form.classList.add("was-validated");
    });

    $("#modalPostForum").on("hidden.bs.modal", function () {
        var form = $("#postForumForm")[0];
        form.reset();
        form.classList.remove("was-validated");
    });
}

function formatDateTime(datetime) {
    var options = { year: "numeric", month: "long", day: "numeric" };
    var date = new Date(datetime);

    var timeOptions = { hour: "numeric", minute: "numeric", hour12: true };
    var timeString = date.toLocaleString("en-US", timeOptions);
    var dateString = date.toLocaleDateString("en-US", options);

    return `${timeString} at ${dateString}`;
}

function saveForumEdit(forumId, forumTitle, forumDescription) {
    var forumTitle = $("#forumTitle").val();
    var forumDescription = $("#forumDescription").val();
    var forumFile = $("#forumFile")[0].files[0];

    var formData = new FormData();
    formData.append("forum_id", forumId);
    formData.append("forum_title", forumTitle);
    formData.append("forum_description", forumDescription);

    if (forumFile) {
        formData.append("forum_file", forumFile);
    }

    $.ajax({
        url: "../phpscripts/user-edit-forum.php",
        method: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (response) {
            if (response.status === "success") {
                $("#forumEditModal").modal("hide");
                displayForums();
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
            console.error(error);
        },
    });
}

function confirmForumDelete(forumId) {
    $.ajax({
        url: "../phpscripts/user-delete-forum.php",
        method: "POST",
        dataType: "json",
        data: { forum_id: forumId, user_id: loggedInUserId },
        success: function (response) {
            if (response.status === "success") {
                displayForums();
                setTimeout(function () {
                    $("#forumDeleteModal").modal("hide");
                }, 500);
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
            console.error(error);
        },
    });
}
