$(document).ready(function () {
    displayGroups();
    createGroup();
    editGroup();
    addGroupMembers();
    removeMember();
    assignNewTask();
    deleteTask();

    $("#createGroupModal").on("shown.bs.modal", function () {
        loadLessons();
        loadMembersOnCreateModal();
    });

    $("#editGroupModal").on("shown.bs.modal", function () {
        loadLessons();
        loadMembersOnEditModal();
    });

    $(document).on("change", ".member-checkbox", function () {
        var selectedMembers = $(".member-checkbox:checked");
        if (selectedMembers.length > 4) {
            this.checked = false;
        }

        var selectedIds = selectedMembers
            .map(function () {
                return $(this).val();
            })
            .get();
        $("#selectedMembers").val(selectedIds.join(","));
    });

    $("#createGroupModal").on("hidden.bs.modal", function () {
        var form = $("#createGroupForm")[0];
        form.reset();
        form.classList.remove("was-validated");
        $("#selectedMembers").val("");
    });

    $(document).on("click", ".btn-primary.edit", function () {
        var groupId = $(this).closest("tr").data("groupid");
        loadGroupDetails(groupId);
    });

    $(document).on("click", ".btn-primary.task", function () {
        var groupId = $(this).closest("tr").data("groupid");
        loadGroupTasks(groupId);
    });

    $(document).on("click", ".btn-danger.delete-group", function () {
        var groupId = $(this).closest("tr").data("groupid");
        $("#deleteModal").modal("show");

        $("#deleteModal .btn.btn-primary")
            .off("click")
            .on("click", function () {
                confirmGroupDelete(groupId);
            });
    });

    $("#assignTaskModal").on("hidden.bs.modal", function () {
        var form = $(this).find("#assignTaskForm");

        form.find('input[type="text"], textarea').val("");
        form.find('input[type="hidden"]').val("");

        form.removeClass("was-validated");
        form.find(".invalid-feedback").remove();
        form.find(".form-control").removeClass("is-invalid");
    });
});

const dataTable = $("#groupTable").DataTable({
    autoWidth: true,
    scrollX: true,
    columns: [
        { width: "25%" },
        { width: "25%" },
        { width: "10%" },
        { width: "15%" },
        { width: "20%" },
    ],
    createdRow: function (row, data, dataIndex) {
        $(row).attr("data-groupid", data[5]);
    },
    data: [],
    language: {
        emptyTable: "No groups found",
    },
});

function displayGroups() {
    $.ajax({
        url: "../phpscripts/admin/fetch-groups.php",
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.status === "success") {
                var groupResult = response.groups.map((group) => {
                    var statusBadgeClass =
                        group.group_status === "active"
                            ? "text-bg-success"
                            : "text-bg-secondary";
                    var statusBadge = `<span class="badge rounded-pill w-100 ${statusBadgeClass}">${
                        group.group_status.charAt(0).toUpperCase() +
                        group.group_status.slice(1)
                    }</span>`;

                    return [
                        group.lesson_title,
                        group.project_title,
                        statusBadge,
                        formatDateTime(group.datetime_created),
                        `<div class="d-flex align-items-center gap-2">
                            <button type="button" class="btn btn-sm btn-primary task"><span><i class="fa-solid fa-plus-minus me-2"></i></span>Task</button>
                            <button type="button" class="btn btn-sm btn-primary edit"><span><i class="fa-regular fa-pen-to-square me-2"></i></span>Edit</button>
                            <button type="button" class="btn btn-sm btn-danger delete-group"><span><i class="fa-regular fa-trash-can me-2"></i></span>Delete</button>
                        </div>`,
                        group.group_id,
                    ];
                });
                dataTable.clear().rows.add(groupResult).draw();
            } else {
                console.error(response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error(error);
        },
    });
}

function loadLessons() {
    $.ajax({
        url: "../phpscripts/fetch-lessons.php",
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.status === "success") {
                var lessonSelect = $("#lessonSelect");
                var editLessonSelect = $("#editLessonSelect");

                lessonSelect.empty();
                editLessonSelect.empty();

                lessonSelect.append(
                    '<option selected disabled value="">Select a lesson</option>'
                );
                editLessonSelect.append(
                    '<option selected disabled value="">Select a lesson</option>'
                );

                response.lessons.forEach(function (lesson) {
                    lessonSelect.append(
                        `<option value="${lesson.lesson_id}">${lesson.lesson_title}</option>`
                    );
                    editLessonSelect.append(
                        `<option value="${lesson.lesson_id}">${lesson.lesson_title}</option>`
                    );
                });
            } else {
                console.error("Error fetching lessons: " + response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error("Error: " + error);
        },
    });
}

function loadGroupDetails(groupId) {
    $.ajax({
        url: "../phpscripts/admin/fetch-group-details.php",
        type: "GET",
        dataType: "json",
        data: { group_id: groupId },
        success: function (response) {
            if (response.status === "success") {
                $("#editGroupId").val(groupId);
                $("#editGroupModal #editProjectTitle").val(
                    response.group.project_title
                );
                $("#editGroupModal #editLessonSelect").val(
                    response.group.lesson_id
                );
                $("#editGroupModal #selectedMembers").val(
                    response.group.members.join(",")
                );

                loadGroupMembersTable(response.group.members);
                loadAvailableMembersDropdown(
                    response.group.members.map((member) => member.user_id)
                );

                $("#editGroupModal").modal("show");
            } else {
                console.error(response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error("Error: " + error);
        },
    });
}

function loadGroupMembersTable(members) {
    var membersTableBody = $("#groupMembersTable tbody");
    membersTableBody.empty();

    members.forEach(function (member) {
        membersTableBody.append(`
            <tr>
                <td>${member.user_name}</td>
                <td>
                    <button class="btn btn-danger btn-sm remove-member" data-user-id="${member.user_id}">Remove</button>
                </td>
            </tr>
        `);
    });
}

function loadAvailableMembersDropdown(existingMembers) {
    $.ajax({
        url: "../phpscripts/admin/fetch-users.php",
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.status === "success") {
                var availableMembersDropdown = $("#availableMembersDropdown");
                availableMembersDropdown.empty();

                let hasAvailableUsers = false;

                response.users.forEach(function (user) {
                    if (!existingMembers.includes(user.user_id)) {
                        availableMembersDropdown.append(`
                            <li>
                                <button class="dropdown-item add-member" data-user-id="${user.user_id}">
                                    ${user.user_name}
                                </button>
                            </li>
                        `);
                        hasAvailableUsers = true;
                    }
                });

                if (!hasAvailableUsers) {
                    availableMembersDropdown.append(`
                        <li class="dropdown-item disabled">No users available</li>
                    `);
                }
            } else {
                console.error("Error fetching users: " + response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error("Error: " + error);
        },
    });
}

function loadMembersOnEditModal(selectedMembers = []) {
    $.ajax({
        url: "../phpscripts/admin/fetch-users.php",
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.status === "success") {
                var memberSelect = $("#editGroupModal #memberSelect");
                memberSelect.empty();

                response.users.forEach(function (user) {
                    var isChecked = selectedMembers.includes(user.user_id)
                        ? "checked"
                        : "";

                    if (!selectedMembers.includes(user.user_id)) {
                        memberSelect.append(`
                            <li>
                                <label class="dropdown-item">
                                    <input type="checkbox" class="form-check-input member-checkbox" value="${user.user_id}" ${isChecked}> 
                                    ${user.user_name}
                                </label>
                            </li>
                        `);
                    }
                });
            } else {
                console.error("Error fetching users: " + response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error("Error: " + error);
        },
    });
}

function loadMembersOnCreateModal() {
    $.ajax({
        url: "../phpscripts/admin/fetch-users.php",
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.status === "success") {
                var memberSelect = $("#memberSelect");
                memberSelect.empty();
                response.users.forEach(function (user) {
                    memberSelect.append(
                        `<li>
                            <label class="dropdown-item">
                                <input type="checkbox" class="form-check-input member-checkbox" value="${user.user_id}"> ${user.user_name}
                            </label>
                        </li>`
                    );
                });
            } else {
                console.error("Error fetching users: " + response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error("Error: " + error);
        },
    });
}

function confirmGroupDelete(groupId) {
    $.ajax({
        url: "../phpscripts/admin/delete-group.php",
        method: "POST",
        dataType: "json",
        data: { group_id: groupId },
        success: function (response) {
            if (response.status === "success") {
                displayGroups();
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

function addGroupMembers() {
    $(document).on("click", ".add-member", function () {
        var userId = $(this).data("user-id");
        var userName = $(this).text().trim();
        var groupId = $("#editGroupId").val();

        var newRow = `
            <tr>
                <td>${userName}</td>
                <td>
                    <button class="btn btn-danger btn-sm remove-member" data-user-id="${userId}">Remove</button>
                </td>
            </tr>
        `;

        var selectedMembers = $("#selectedMembers").val().split(",");
        selectedMembers.push(userId);
        $("#selectedMembers").val(selectedMembers.join(","));

        $(this).parent().remove();

        $.ajax({
            type: "POST",
            url: "../phpscripts/admin/add-group-member.php",
            data: { user_id: userId, group_id: groupId },
            success: function (response) {
                var data = JSON.parse(response);
                if (data.status === "success") {
                    $("#liveToast .toast-body p")
                        .text(data.message)
                        .addClass("text-success")
                        .removeClass("text-danger");
                    $("#liveToast").toast("show");

                    $("#groupMembersTable tbody").append(newRow);
                    loadAvailableMembersDropdown(selectedMembers);
                } else {
                    $("#liveToast .toast-body p")
                        .text(data.message)
                        .addClass("text-danger")
                        .removeClass("text-success");
                    $("#liveToast").toast("show");
                }
            },
            error: function (xhr, status, error) {
                console.error("Error: " + error);
            },
        });
    });
}

function removeMember() {
    $(document).on("click", ".remove-member", function () {
        var userId = $(this).data("user-id");
        var groupId = $("#editGroupId").val();

        $(this).closest("tr").remove();

        var selectedMembers = $("#selectedMembers").val().split(",");
        selectedMembers = selectedMembers.filter(function (id) {
            return id !== userId.toString();
        });
        $("#selectedMembers").val(selectedMembers.join(","));

        $.ajax({
            url: "../phpscripts/admin/remove-member.php",
            type: "POST",
            data: {
                user_id: userId,
                group_id: groupId,
            },
            dataType: "json",
            success: function (response) {
                if (response.status === "success") {
                    $("#liveToast .toast-body p")
                        .text(response.message)
                        .addClass("text-success")
                        .removeClass("text-danger");
                    $("#liveToast").toast("show");
                    loadAvailableMembersDropdown(selectedMembers);
                } else {
                    $("#liveToast .toast-body p")
                        .text(response.message)
                        .addClass("text-danger")
                        .removeClass("text-success");
                    $("#liveToast").toast("show");
                }
            },
            error: function (xhr, status, error) {
                console.error("Error: " + error);
            },
        });
    });
}

function createGroup() {
    $(document).on("submit", "#createGroupForm", function (event) {
        event.preventDefault();
        var form = this;

        if (form.checkValidity() === false) {
            event.stopPropagation();
        } else {
            var formData = $(form).serialize();
            $.ajax({
                url: "../phpscripts/admin/create-group.php",
                type: "POST",
                data: formData,
                dataType: "json",
                success: function (response) {
                    if (response.status === "success") {
                        $("#liveToast .toast-body p")
                            .text(response.message)
                            .addClass("text-success")
                            .removeClass("text-danger");
                        $("#liveToast").toast("show");

                        $("#createGroupModal").modal("hide");
                        form.reset();
                        displayGroups();
                    } else {
                        $("#liveToast .toast-body p")
                            .text(response.message)
                            .addClass("text-danger")
                            .removeClass("text-success");
                        $("#liveToast").toast("show");
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error: " + error);
                },
            });
        }
        form.classList.add("was-validated");
    });
}

function editGroup() {
    $(document).on("submit", "#editGroupForm", function (event) {
        event.preventDefault();
        var form = this;

        if (form.checkValidity() === false) {
            event.stopPropagation();
        } else {
            var formData = $(form).serialize();
            $.ajax({
                url: "../phpscripts/admin/edit-group.php",
                type: "POST",
                data: formData,
                dataType: "json",
                success: function (response) {
                    if (response.status === "success") {
                        $("#liveToast .toast-body p")
                            .text(response.message)
                            .addClass("text-success")
                            .removeClass("text-danger");
                        $("#liveToast").toast("show");

                        $("#editGroupModal").modal("hide");
                        displayGroups();
                    } else {
                        $("#liveToast .toast-body p")
                            .text(response.message)
                            .addClass("text-danger")
                            .removeClass("text-success");
                        $("#liveToast").toast("show");
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error: " + error);
                },
            });
        }
        form.classList.add("was-validated");
    });
}

function loadGroupTasks(groupId) {
    $.ajax({
        url: "../phpscripts/admin/fetch-tasks.php",
        type: "GET",
        dataType: "json",
        data: { group_id: groupId },
        success: function (response) {
            if (response.status === "success") {
                $("#assignTaskModal")
                    .find('input[name="group_id"]')
                    .val(groupId);

                var tasks = response.tasks || [];
                var taskHtml;

                if (tasks.length === 0) {
                    taskHtml = `<tr><td colspan="4" class="text-center text-danger">Currently no task</td></tr>`;
                } else {
                    taskHtml = tasks
                        .map((task) => {
                            return `<tr data-task-id="${task.task_id}">
                                <td>${task.task_id}</td>
                                <td>${task.task_title}</td>
                                <td>${task.task_status}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-danger remove-task">Remove</button>
                                </td>
                            </tr>`;
                        })
                        .join("");
                }

                $("#tasksTable tbody").html(taskHtml);
                $("#assignTaskModal").modal("show");
            } else {
                console.error(response.message);
                $("#tasksTable tbody").html(
                    `<tr><td colspan="4" class="text-center text-danger">Error: ${response.message}</td></tr>`
                );
                $("#assignTaskModal").modal("show");
            }
        },
        error: function (xhr, status, error) {
            console.error(error);
            $("#assignTaskModal").modal("show");
        },
    });
}

function assignNewTask() {
    $(document).on("submit", "#assignTaskForm", function (event) {
        event.preventDefault();
        var form = this;

        if (form.checkValidity() === false) {
            event.stopPropagation();
        } else {
            var formData = $(form).serialize();
            $.ajax({
                url: "../phpscripts/admin/add-task.php",
                type: "POST",
                data: formData,
                dataType: "json",
                success: function (response) {
                    if (response.status === "success") {
                        $("#liveToast .toast-body p")
                            .text(response.message)
                            .addClass("text-success")
                            .removeClass("text-danger");
                        $("#liveToast").toast("show");

                        appendTaskToTable(response.task);
                        $("#taskTitle").val("");
                        $("#taskDescription").val("");

                        $("#assignTaskForm input")
                            .removeClass("is-invalid")
                            .removeClass("is-valid");
                        form.classList.remove("was-validated");
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
}

function appendTaskToTable(task) {
    var taskHtml = `<tr>
                        <td>${task.task_id}</td>
                        <td>${task.task_title}</td>
                        <td>${task.task_status}</td>
                        <td>
                            <button type="button" class="btn btn-danger delete-task" data-id="${task.task_id}">Remove</button>
                        </td>
                    </tr>`;
    $("#tasksTable tbody").append(taskHtml);
}

function deleteTask() {
    $(document).on("click", ".remove-task", function () {
        var taskId = $(this).closest("tr").data("task-id");

        $.ajax({
            url: "../phpscripts/admin/delete-task.php",
            type: "POST",
            dataType: "json",
            data: { task_id: taskId },
            success: function (response) {
                if (response.status === "success") {
                    $(`tr[data-task-id="${taskId}"]`).remove();

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
    });
}
