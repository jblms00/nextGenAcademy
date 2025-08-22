$(document).ready(function () {
    displayUsers();
    addNewUser();

    $(document).on("click", ".btn-danger", function () {
        var userId = $(this).closest("tr").data("userid");
        $("#confirmDeleteBtn").data("userid", userId);
        $("#deleteModal").modal("show");
    });

    $("#confirmDeleteBtn").click(function () {
        var userId = $(this).data("userid");
        deleteUser(userId);
    });

    $(document).on("change", ".form-user-status", function () {
        var userId = $(this).closest("tr").data("userid");
        var newStatus = $(this).val();
        updateUserStatus(userId, newStatus);
    });
});

const dataTable = $("#usersTable").DataTable({
    autoWidth: true,
    scrollX: true,
    columns: [
        { width: "20%" },
        { width: "20%" },
        { width: "10%" },
        { width: "20%" },
        { width: "30%" },
    ],
    createdRow: function (row, data, dataIndex) {
        $(row).attr("data-userid", data[5]);
    },
    data: [],
    language: {
        emptyTable: "No matching records found",
    },
});

function displayUsers() {
    $.ajax({
        url: "../phpscripts/admin/fetch-users.php",
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.status === "success") {
                var usersResult = response.users.map((user) => {
                    var statusBadgeClass =
                        user.user_status === "active"
                            ? "text-bg-success"
                            : "text-bg-danger";
                    var statusBadge = `<span class="badge rounded-pill ${statusBadgeClass} w-100">${
                        user.user_status.charAt(0).toUpperCase() +
                        user.user_status.slice(1)
                    }</span>`;

                    return [
                        user.user_name,
                        user.user_email,
                        statusBadge,
                        formatDateTime(user.date_created),
                        `<div class="d-flex align-items-center gap-2">
                            <select class="form-select form-user-status w-75" aria-label="Default select example">
                                <option selected disabled>Please select status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                            <button type="button" class="btn btn-sm btn-danger"><i class="fa-regular fa-trash-can me-2"></i></span>Delete</button>
                        </div>`,
                        user.user_id,
                    ];
                });

                dataTable.clear().rows.add(usersResult).draw();
            } else {
                console.error(response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error(error);
        },
    });
}

function updateUserStatus(userId, newStatus) {
    $.ajax({
        url: "../phpscripts/admin/update-user-status.php",
        type: "POST",
        data: { userId: userId, status: newStatus },
        dataType: "json",
        success: function (response) {
            if (response.status === "success") {
                displayUsers();
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
            console.error("An error occurred: " + error);
        },
    });
}

function deleteUser(userId) {
    $.ajax({
        url: "../phpscripts/admin/delete-user.php",
        type: "POST",
        data: { userId: userId },
        dataType: "json",
        success: function (response) {
            if (response.status === "success") {
                $("#deleteModal").modal("hide");
                displayUsers();

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
            console.error("An error occurred: " + error);
        },
    });
}

function addNewUser() {
    $("#addUserForm").on("submit", function (event) {
        event.preventDefault();

        var form = $(this)[0];
        if (form.checkValidity() === false) {
            event.stopPropagation();
        } else {
            var userName = $("#userName").val().trim();
            var userEmail = $("#userEmail").val().trim();
            var userBirthday = $("#userBirthday").val();
            var userStatus = $("#userStatus").val();

            var lastName = userName.split(" ").slice(-1)[0].toLowerCase();
            var birthMonthDay = formatBirthday(userBirthday);
            var userPassword = "nextGen" + lastName + birthMonthDay;

            $.ajax({
                url: "../phpscripts/admin/create-user.php",
                type: "POST",
                dataType: "json",
                data: {
                    user_name: userName,
                    user_email: userEmail,
                    user_birthday: userBirthday,
                    user_status: userStatus,
                    user_password: userPassword,
                },
                success: function (response) {
                    if (response.status === "success") {
                        $("#addUserModal").modal("hide");
                        displayUsers();
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

        $(this).addClass("was-validated");
    });
}

function formatBirthday(birthday) {
    var date = new Date(birthday);
    var month = (date.getMonth() + 1).toString().padStart(2, "0");
    var day = date.getDate().toString().padStart(2, "0");
    return month + day;
}
