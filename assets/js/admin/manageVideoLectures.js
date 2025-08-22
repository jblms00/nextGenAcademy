$(document).ready(function () {
    displayVideoLectures();
    updateVideoLecture();
    createNewVideoLecture();

    $(document).on("click", ".btn-primary.edit", function (e) {
        e.stopPropagation();
        var videoLectureId = $(this)
            .closest("tr")
            .find("td:eq(0)")
            .text()
            .trim();
        var weekNumber = $(this).closest("tr").find("td:eq(1)").text().trim();
        var videoUrl = $(this).closest("tr").find("td:eq(2)").text().trim();

        $("#weekNumber").val(weekNumber);
        $("#videoUrl").val(videoUrl);
        $("#editVideoLectureModal")
            .data("vidlec-id", videoLectureId)
            .modal("show");
    });

    $(document).on("click", ".btn-danger", function () {
        var videoLectureId = $(this)
            .closest("tr")
            .find("td:eq(0)")
            .text()
            .trim();
        $("#deleteModal").modal("show");

        $("#deleteModal .btn.btn-primary")
            .off("click")
            .on("click", function () {
                confirmVideoLectureDelete(videoLectureId);
            });
    });
});

const dataTable = $("#videoLecturesTable").DataTable({
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
        $(row).attr("data-video-id", data[0]);
        $(row).attr("data-week-number", data[1]);
        $(row).attr("data-video-url", data[2]);
        $(row).attr("data-created", data[3]);
    },
    data: [],
    language: {
        emptyTable: "No matching records found",
    },
});

function displayVideoLectures() {
    $.ajax({
        url: "../phpscripts/admin/fetch-video-lectures.php",
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.status === "success") {
                var videoLecturesData = response.video_lectures.map((video) => {
                    return [
                        video.video_lectures_id,
                        video.week_number,
                        video.video_url,
                        formatDateTime(video.datetime_created),
                        `<div class="d-flex align-items-center gap-2">
                            <button type="button" class="btn btn-sm btn-primary edit"  data-id="${video.video_lectures_id}"><span><i class="fa-regular fa-pen-to-square me-2"></i></span>View</button>
                            <button type="button" class="btn btn-sm btn-danger delete" data-id="${video.video_lectures_id}"><span><i class="fa-regular fa-trash-can me-2"></i></span>Delete</button>
                        </div>`,
                    ];
                });

                dataTable.clear().rows.add(videoLecturesData).draw();
            } else {
                console.error(response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error(error);
        },
    });
}

function formatDateTime(dateTimeString) {
    const options = {
        year: "numeric",
        month: "2-digit",
        day: "2-digit",
        hour: "2-digit",
        minute: "2-digit",
        second: "2-digit",
    };
    return new Date(dateTimeString).toLocaleString("en-US", options);
}

function updateVideoLecture() {
    $(document).on("submit", "#updateVideoLectureForm", function (event) {
        event.preventDefault();
        var form = this;

        form.classList.remove("was-validated");

        if (form.checkValidity() === false) {
            event.stopPropagation();
        } else {
            var videoLectureId = $("#editVideoLectureModal").data("vidlec-id");
            var weekNumber = $("#weekNumber").val();
            var videoUrl = $("#videoUrl").val();

            $.ajax({
                url: "../phpscripts/admin/update-video-lecture.php",
                type: "POST",
                data: {
                    video_lecture_id: videoLectureId,
                    week_number: weekNumber,
                    video_url: videoUrl,
                },
                dataType: "json",
                success: function (response) {
                    if (response.status === "success") {
                        $("#liveToast .toast-body p")
                            .text(response.message)
                            .addClass("text-success")
                            .removeClass("text-danger");
                        $("#liveToast").toast("show");
                        displayVideoLectures();
                        $("#editVideoLectureModal").modal("hide");
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
        form.classList.add("was-validated");
    });

    $("#editVideoLectureModal").on("hidden.bs.modal", function () {
        var form = $("#updateVideoLectureForm")[0];
        form.reset();
        form.classList.remove("was-validated");
    });
}

function confirmVideoLectureDelete(videoLectureId) {
    $.ajax({
        url: "../phpscripts/admin/delete-video-lecture.php",
        method: "POST",
        dataType: "json",
        data: { video_lecture_id: videoLectureId },
        success: function (response) {
            if (response.status === "success") {
                displayVideoLectures();
                $("#deleteModal").modal("hide");
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

function createNewVideoLecture() {
    $(document).on("submit", "#createVideoLectureForm", function (event) {
        event.preventDefault();
        var form = this;

        if (!this.checkValidity()) {
            this.classList.add("was-validated");
        } else {
            var videoUrl = $("#newVideoUrl").val();
            var weekNumber = $("#newWeekNumber").val();

            $.ajax({
                url: "../phpscripts/admin/create-video-lecture.php",
                type: "POST",
                data: { week_number: weekNumber, video_url: videoUrl },
                dataType: "json",
                success: function (response) {
                    if (response.status === "success") {
                        $("#liveToast .toast-body p")
                            .text(response.message)
                            .addClass("text-success")
                            .removeClass("text-danger");
                        $("#liveToast").toast("show");
                        displayVideoLectures();
                        $("#createVideoLectureModal").modal("hide");
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
        }
        form.classList.add("was-validated");
    });

    $("#createVideoLectureModal").on("hidden.bs.modal", function () {
        var form = $("#createVideoLectureForm")[0];
        form.reset();
        form.classList.remove("was-validated");
    });
}
