const toastMessage = $("#liveToast .toast-body p");

$(document).ready(function () {
    displayGroups();

    $(document).on("click", ".open-modal", function () {
        var groupId = $(this).data("group-id");
        fetchGroupTasks(groupId);
        $("#groupTaskModal").modal("show");
    });

    $(document).on("change", ".task-status", function () {
        var taskId = $(this).data("task-id");
        var newStatus = $(this).val();
        updateTaskStatus(taskId, newStatus, $(this));
    });
});

function displayGroups() {
    $.ajax({
        url: "../phpscripts/fetch-groups.php",
        method: "GET",
        dataType: "json",
        data: { lesson_id: lessonId, user_id: loggedInUserId },
        success: function (response) {
            if (response.status === "success") {
                var groups = response.groups;
                var groupHtml = "";

                if (groups.length === 0) {
                    $("#collaborationList").append(
                        "<li class='text-center text-danger'>No groups available.</li>"
                    );
                } else {
                    groups.forEach(function (group) {
                        var members = group.members.join(", ");
                        groupHtml += `
                            <a href="#" class="text-decoration-none text-light open-modal" data-group-id="${group.group_id}">
                                <li>
                                    <h6 class="mb-0">${group.project_title}</h6>
                                    <small>Members: ${members}</small>
                                </li>
                            </a>
                        `;
                    });
                    $("#collaborationList").html(groupHtml);
                }
            } else {
                console.error("Error fetching groups: " + response.message);
                $("#collaborationList").append(
                    "<li class='text-center text-danger'>No groups available.</li>"
                );
            }
        },
        error: function (xhr, status, error) {
            console.error(error);
        },
    });
}

function fetchGroupTasks(groupId) {
    $.ajax({
        url: "../phpscripts/fetch-group-tasks.php",
        method: "GET",
        dataType: "json",
        data: { group_id: groupId },
        success: function (response) {
            if (response.status === "success") {
                var membersHtml = "";
                response.members.forEach(function (member) {
                    membersHtml += `<tr><td>${member}</td></tr>`;
                });
                $("#tableMembers tbody").html(membersHtml);

                var tasksHtml = "";
                if (response.tasks.length === 0) {
                    tasksHtml = `<tr><td colspan="3" class="text-center text-danger">Currently no task.</td></tr>`;
                } else {
                    response.tasks.forEach(function (task) {
                        var badgeClass = getBadgeClass(task.task_status);
                        tasksHtml += `
                            <tr>
                                <td>${task.task_title}</td>
                                <td><span class="badge ${badgeClass} w-100">${
                            task.task_status
                        }</span></td>
                                <td>
                                    <select class="form-select task-status" data-task-id="${
                                        task.task_id
                                    }">
                                        <option value="Pending" ${
                                            task.task_status === "Pending"
                                                ? "selected"
                                                : ""
                                        }>Pending</option>
                                        <option value="In Progress" ${
                                            task.task_status === "In Progress"
                                                ? "selected"
                                                : ""
                                        }>In Progress</option>
                                        <option value="Completed" ${
                                            task.task_status === "Completed"
                                                ? "selected"
                                                : ""
                                        }>Completed</option>
                                    </select>
                                </td>
                            </tr>`;
                    });
                }
                $("#tableTasks tbody").html(tasksHtml);
            } else {
                console.error(
                    "Error fetching tasks and members: " + response.message
                );
            }
        },
        error: function (xhr, status, error) {
            console.error(error);
        },
    });
}

function updateTaskStatus(taskId, newStatus, selectElement) {
    $.ajax({
        url: "../phpscripts/update-task-status.php",
        method: "POST",
        dataType: "json",
        data: { task_id: taskId, status: newStatus },
        success: function (response) {
            if (response.status === "success") {
                var badgeClass = getBadgeClass(newStatus);
                selectElement
                    .closest("tr")
                    .find("span.badge")
                    .attr("class", `badge ${badgeClass} w-100`)
                    .text(newStatus);

                toastMessage
                    .text("Comment updated successfully.")
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

function getBadgeClass(status) {
    switch (status) {
        case "Pending":
            return "bg-warning text-dark";
        case "In Progress":
            return "bg-info";
        case "Completed":
            return "bg-success";
        default:
            return "bg-secondary";
    }
}
