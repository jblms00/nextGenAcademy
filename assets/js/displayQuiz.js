const loggedInUserId = $("body").data("user-id");

$(document).ready(function () {
    displayQuiz();
});

function displayQuiz() {
    $.ajax({
        url: "../phpscripts/fetch-quizzes.php",
        method: "GET",
        dataType: "json",
        data: { lesson_id: lessonId, user_id: loggedInUserId },
        success: function (response) {
            if (response.status === "success") {
                var quizzes = response.quizzes;
                var quizzesHtml = "";

                if (quizzes.length === 0) {
                    $("#quizzesList").append(
                        "<li class='text-center text-danger'>No quizzes available.</li>"
                    );
                } else {
                    quizzes.forEach(function (quiz) {
                        quizzesHtml += `
                        <li>
                            <h6 class="mb-0">${quiz.lesson_title}</h6>
                            <div class="d-flex align-items-center justify-content-between mt-3">
                                <small>${
                                    quiz.score !== null
                                        ? "Score: " +
                                          quiz.score +
                                          "/" +
                                          quiz.total_questions
                                        : quiz.total_questions + " points"
                                }</small>
                                ${
                                    quiz.score === null
                                        ? `<a href="takeQuiz?weekNumber=${weekNumber}&id=${lessonId}&lesson=${quiz.lesson_title}&quiz=${quiz.quiz_id}" class="btn bg-warning-subtle py-0">Take Quiz</a>`
                                        : ""
                                }
                            </div>
                        </li>`;
                    });
                    $("#quizzesList").html(quizzesHtml);
                }
            } else {
                console.error("Error fetching quizzes: " + response.message);
                $("#quizzesList").append(
                    "<li class='text-center text-danger'>No quizzes available.</li>"
                );
            }
        },
        error: function (xhr, status, error) {
            console.error(error);
        },
    });
}
