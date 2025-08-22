$(window).on("resize", function () {
    chart.render();
});

$(document).ready(function () {
    getUsers();
    getQuizAttempts();
    getTaskProgress();
});

function getUsers() {
    $.ajax({
        url: "../phpscripts/admin/fetch-users.php",
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.status === "success") {
                var activeCounts = { active: 0, inactive: 0 };
                response.users.forEach((user) => {
                    if (user.user_status === "active") {
                        activeCounts.active++;
                    } else if (user.user_status === "inactive") {
                        activeCounts.inactive++;
                    }
                });

                var barChartData = {
                    series: [
                        {
                            name: "Users",
                            data: [activeCounts.active, activeCounts.inactive],
                        },
                    ],
                    categories: ["Active Users", "Inactive Users"],
                };

                renderUserBarChart(barChartData);
            } else {
                console.error(response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error(error);
        },
    });
}

function renderUserBarChart(data) {
    var options = {
        chart: {
            type: "bar",
            height: 350,
            width: "100%",
            animations: {
                enabled: true,
                easing: "easeinout",
                speed: 800,
            },
            toolbar: {
                show: false, // Hide the toolbar
            },
        },
        series: data.series,
        xaxis: {
            categories: data.categories,
        },
        dataLabels: {
            enabled: true,
            formatter: function (val) {
                return val;
            },
            offsetY: -20,
            style: {
                fontSize: "12px",
                colors: ["#304758"],
            },
        },
        plotOptions: {
            bar: {
                distributed: true,
                borderRadius: 5,
                columnWidth: "50%",
            },
        },
        yaxis: {
            title: {
                text: "Number of Users",
            },
        },
        responsive: [
            {
                breakpoint: 480,
                options: {
                    chart: {
                        width: "100%",
                        height: 250,
                    },
                },
            },
        ],
    };

    var chart = new ApexCharts(document.querySelector("#userChart"), options);
    chart.render();
}

function getQuizAttempts() {
    $.ajax({
        url: "../phpscripts/admin/fetch-quiz-attempts.php",
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.status === "success") {
                var quizCounts = { completed: 0, pending: 0 };
                response.attempts.forEach((attempt) => {
                    if (attempt.status === "completed") {
                        quizCounts.completed++;
                    } else {
                        quizCounts.pending++;
                    }
                });

                var barChartData = {
                    series: [
                        {
                            name: "Quizzes",
                            data: [quizCounts.completed, quizCounts.pending],
                        },
                    ],
                    categories: ["Completed", "Pending"],
                };

                renderQuizBarChart(barChartData);
            } else {
                console.error(response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error(error);
        },
    });
}

function renderQuizBarChart(data) {
    var options = {
        chart: {
            type: "bar",
            height: 350,
            width: "100%",
            toolbar: {
                show: false, // Hide the toolbar
            },
        },
        series: data.series,
        xaxis: {
            categories: data.categories,
        },
        dataLabels: {
            enabled: true,
        },
        plotOptions: {
            bar: {
                distributed: true,
                borderRadius: 5,
                columnWidth: "50%",
            },
        },
        yaxis: {
            title: { text: "Number of Attempts" },
        },
    };

    var chart = new ApexCharts(document.querySelector("#quizChart"), options);
    chart.render();
}

function getTaskProgress() {
    $.ajax({
        url: "../phpscripts/admin/fetch-tasks.php",
        type: "GET",
        dataType: "json",
        success: function (response) {
            var taskProgressContainer = $("#taskProgressChart");
            taskProgressContainer.empty();

            if (response.status === "success") {
                var tasks = response.tasks;

                if ($.isEmptyObject(tasks)) {
                    taskProgressContainer.append(
                        "<p class='text-center fw-semibold mb-0 text-danger'>No tasks found for any group.</p>"
                    );
                } else {
                    $.each(tasks, function (groupId, taskCounts) {
                        var pieChartData = {
                            series: [
                                taskCounts.pending,
                                taskCounts.inProgress,
                                taskCounts.completed,
                            ],
                            labels: ["Pending", "In Progress", "Completed"],
                        };

                        var groupChartId = `taskProgressChart-${groupId}`;
                        taskProgressContainer.append(
                            `<div id="${groupChartId}" class="mb-4"></div>`
                        );

                        renderTaskProgressChart(
                            groupChartId,
                            pieChartData,
                            groupId
                        );
                    });
                }
            } else {
                console.error(response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error(error);
        },
    });
}

function renderTaskProgressChart(chartId, data, groupId) {
    var options = {
        chart: {
            type: "pie",
            height: 350,
            width: "100%",
            toolbar: { show: false },
        },
        title: {
            text: `Group ${groupId} Task Progress`,
            align: "center",
        },
        series: data.series,
        labels: data.labels,
    };

    var chart = new ApexCharts(document.querySelector(`#${chartId}`), options);
    chart.render();
}
