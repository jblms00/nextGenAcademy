const loggedInUserId = $("body").data("user-id");

$(document).ready(function () {
    displayForums();
    postForum();

    $(document).on("click", ".btn-primary.view", function (e) {
        e.stopPropagation();
        var forumTitle = $(this).closest("tr").find("td:eq(2)").text().trim();
        var forumDescription = $(this).closest("tr").data("forum-description");
        var forumFileUpload = $(this).closest("tr").data("forum-file-upload");

        $("#forumTitle").text(forumTitle);
        $("#forumDescription").text(forumDescription);

        if (forumFileUpload) {
            $("#forumFilUpload").html(generateFileUploadHtml(forumFileUpload));
        } else {
            $("#forumFilUpload").text("No attachments");
        }

        $("#forumViewModal").modal("show");
    });

    $(document).on("click", ".btn-danger", function () {
        var forumId = $(this).closest("tr").data("forumid");
        var authorId = $(this).closest("tr").data("authorid");
        $("#deleteModal").modal("show");

        $("#deleteModal .btn.btn-primary")
            .off("click")
            .on("click", function () {
                confirmForumDelete(forumId, authorId);
            });
    });
});

const dataTable = $("#forumsTable").DataTable({
    autoWidth: true,
    scrollX: true,
    columns: [
        { width: "20%" },
        { width: "20%" },
        { width: "25%" },
        { width: "20%" },
        { width: "15%" },
    ],
    createdRow: function (row, data, dataIndex) {
        $(row).attr("data-forumid", data[5]);
        $(row).attr("data-authorid", data[6]);
        $(row).attr("data-forum-description", data[7]);
        $(row).attr("data-forum-file-upload", data[8]);
    },
    data: [],
    language: {
        emptyTable: "No matching records found",
    },
});

function displayForums() {
    $.ajax({
        url: "../phpscripts/fetch-forums.php",
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.status === "success") {
                var forumsResult = response.forums.map((forum) => {
                    return [
                        forum.user_name,
                        forum.user_email,
                        forum.forum_title,
                        formatDateTime(forum.datetime_created),
                        `<div class="d-flex align-items-center gap-2">
                            <button type="button" class="btn btn-sm btn-primary view"><span><i class="fa-regular fa-pen-to-square me-2"></i></span>View</button>
                            <button type="button" class="btn btn-sm btn-danger"><span><i class="fa-regular fa-trash-can me-2"></i></span>Delete</button>
                        </div>`,
                        forum.forum_id,
                        forum.user_id,
                        forum.forum_description,
                        forum.forum_file_upload,
                    ];
                });
                dataTable.clear().rows.add(forumsResult).draw();
            } else {
                console.error(response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error(error);
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
                        $("#liveToast .toast-body p")
                            .text(response.message)
                            .addClass("text-success")
                            .removeClass("text-danger");
                        $("#liveToast").toast("show");

                        $("#modalPostForum").modal("hide");
                        form.reset();
                        form.classList.remove("was-validated");
                        displayForums();
                    } else {
                        $("#liveToast .toast-body p")
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

function generateFileUploadHtml(fileUpload) {
    var fileExtension = fileUpload.split(".").pop().toLowerCase();
    var isImage = ["jpg", "jpeg", "png", "gif"].includes(fileExtension);
    var isVideo = ["mp4", "avi", "mov"].includes(fileExtension);
    var filePath = "../assets/uploadedFile";

    if (isImage) {
        return `<img src="${filePath}/${fileUpload}" alt="Forum File" style="max-width: 100%; height: auto;" />`;
    } else if (isVideo) {
        return `<video controls style="max-width: 100%; height: auto;"><source src="${filePath}/${fileUpload}" type="video/${fileExtension}">Your browser does not support the video tag.</video>`;
    } else {
        return "Unsupported file type";
    }
}

function confirmForumDelete(forumId, authorId) {
    $.ajax({
        url: "../phpscripts/admin/delete-forum.php",
        method: "POST",
        dataType: "json",
        data: { forum_id: forumId, author_id: authorId },
        success: function (response) {
            if (response.status === "success") {
                displayForums();
                setTimeout(function () {
                    $("#deleteModal").modal("hide");
                }, 500);
                $("#liveToast .toast-body p")
                    .text(response.message)
                    .addClass("text-success")
                    .removeClass("text-danger");
                $("#liveToast").toast("show");
            } else {
                $("#liveToast .toast-body p")
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
