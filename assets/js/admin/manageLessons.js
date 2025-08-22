$(document).ready(function () {
    displayLessons();
    createNewLesson();

    $(document).on("click", ".btn-primary.edit", function (e) {
        e.stopPropagation();
        var lessonId = $(this).closest("tr").find("td:eq(0)").text().trim();
        var weekNumber = $(this).closest("tr").find("td:eq(1)").text().trim();
        var lessonTitle = $(this).closest("tr").find("td:eq(2)").text().trim();
        var lessonDescription = $(this)
            .closest("tr")
            .data("lesson-description");
        var lessonBanner = $(this).closest("tr").data("lesson-banner");

        $("#weekNumber").val(weekNumber);
        $("#lessonTitle").val(lessonTitle);
        $("#lessonDescription").val(lessonDescription);
        $("#previewBanner").attr(
            "src",
            "../assets/images/lessonsBanner/" + lessonBanner
        );
        $("#editLessonModal").data("lesson-id", lessonId).modal("show");
    });

    $("#updateLessonForm").submit(function (event) {
        event.preventDefault();
        updateLesson();
    });

    $(document).on("click", ".btn-danger", function () {
        var lessonId = $(this).closest("tr").data("lessonid");
        $("#deleteModal").modal("show");

        $("#deleteModal .btn.btn-primary")
            .off("click")
            .on("click", function () {
                confirmLessonDelete(lessonId);
            });
    });
});

const dataTable = $("#lessonsTable").DataTable({
    autoWidth: true,
    scrollX: true,
    columns: [
        { width: "10%" },
        { width: "10%" },
        { width: "25%" },
        { width: "20%" },
        { width: "15%" },
    ],
    createdRow: function (row, data, dataIndex) {
        $(row).attr("data-week-number", data[1]);
        $(row).attr("data-lesson-topic", data[2]);
        $(row).attr("data-lesson-description", data[6]);
        $(row).attr("data-lesson-banner", data[7]);
    },
    data: [],
    language: {
        emptyTable: "No matching records found",
    },
});

function displayLessons() {
    $.ajax({
        url: "../phpscripts/fetch-lessons.php",
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.status === "success") {
                var tableBody = $("#lessonsTable tbody");
                tableBody.empty();

                var lessonsResult = response.lessons.map((lesson) => {
                    return [
                        lesson.lesson_id,
                        lesson.week_number,
                        lesson.lesson_title,
                        formatDateTime(lesson.datetime_created),
                        `<div class="d-flex align-items-center gap-2">
                            <button type="button" class="btn btn-sm btn-primary edit"><span><i class="fa-regular fa-eye me-2"></i></span>View</button>
                            <button type="button" class="btn btn-sm btn-danger"><span><i class="fa-regular fa-trash-can me-2"></i></span>Delete</button>
                        </div>`,
                        lesson.lesson_title,
                        lesson.lesson_description,
                        lesson.lesson_image_banner,
                    ];
                });
                dataTable.clear().rows.add(lessonsResult).draw();
            } else {
                console.error(response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error(error);
        },
    });
}

function updateLesson() {
    var lessonId = $("#editLessonModal").data("lesson-id");
    var formData = new FormData();

    formData.append("lesson_id", lessonId);
    formData.append("week_number", $("#weekNumber").val());
    formData.append("lesson_title", $("#lessonTitle").val());
    formData.append("lesson_description", $("#lessonDescription").val());

    var fileInput = $("#lessonBanner")[0].files[0];
    if (fileInput) {
        formData.append("lessonBanner", fileInput);
    }

    $.ajax({
        url: "../phpscripts/admin/update-lesson.php",
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
                displayLessons();
                $("#editLessonModal").modal("hide");
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

function confirmLessonDelete(lessonId) {
    $.ajax({
        url: "../phpscripts/admin/delete-lessson.php",
        method: "POST",
        dataType: "json",
        data: { lesson_id: lessonId },
        success: function (response) {
            if (response.status === "success") {
                displayLessons();
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

function createNewLesson() {
    $(document).on("submit", "#createLessonForm", function (event) {
        event.preventDefault();

        if (!this.checkValidity()) {
            this.classList.add("was-validated");
            return;
        }

        var formData = new FormData();

        formData.append("week_number", $("#newWeekNumber").val());
        formData.append("lesson_title", $("#newLessonTitle").val());
        formData.append("lesson_description", $("#newLessonDescription").val());

        var fileInput = $("#newLessonBanner")[0].files[0];
        if (fileInput) {
            formData.append("lessonBanner", fileInput);
        }

        $.ajax({
            url: "../phpscripts/admin/create-lesson.php",
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
                    displayLessons();
                    $("#createLessonModal").modal("hide");
                } else {
                    $("#liveToast .toast-body p")
                        .text(response.message || "An error occurred.")
                        .addClass("text-danger")
                        .removeClass("text-success");
                    $("#liveToast").toast("show");
                }
            },
            error: function (xhr, status, error) {
                console.error(error);
            },
        });
    });
}
