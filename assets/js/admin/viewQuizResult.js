const url = window.location.href;
const paramString = url.split("?")[1];
const params = paramString.split("&");

const weekNumber = params[0].match(/\d+/) ? params[0].match(/\d+/)[0] : null;
const lessonId = params[1].match(/\d+/) ? params[1].match(/\d+/)[0] : null;
const topicTitle = params[2] ? decodeURIComponent(params[2]) : null;

$(document).ready(function () {
    displayQuizResults();
});

const dataTable = $("#quizResultsTable").DataTable({
    autoWidth: true,
    scrollX: true,
    columns: [
        { width: "20%" },
        { width: "20%" },
        { width: "20%" },
        { width: "20%" },
    ],
    data: [],
    language: {
        emptyTable: "No matching records found",
    },
});
function displayQuizResults() {
    $.ajax({
        url: "../phpscripts/admin/fetch-quiz-results.php",
        data: { weekNumber: weekNumber, lessonId: lessonId },
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.status === "success") {
                var quizResults = response.quizResults.map((result) => {
                    return [
                        result.user_name,
                        result.user_email,
                        `${result.score}/${result.total_questions}`,
                        formatDateTime(result.datetime_created),
                    ];
                });

                dataTable.clear().rows.add(quizResults).draw();
            } else {
                console.error(response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error(error);
        },
    });
}
