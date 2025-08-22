const url = window.location.href;

const weekNumberMatch = url.match(/weekNumber=(\d+)&id=(\d+)/);
const weekNumber = weekNumberMatch ? weekNumberMatch[1] : null;
const idNumber = weekNumberMatch ? weekNumberMatch[2] : null;

const urlObj = new URL(url);
const lessonTitle = urlObj.searchParams.get("lesson");
const quizId = urlObj.searchParams.get("quiz");

const loggedInUserId = $("body").data("user-id");
const toastMessage = $("#liveToast .toast-body p");

$(document).ready(function () {
    displayQuestionnaires();
    submitQuiz();
});

function displayQuestionnaires() {
    $.ajax({
        url: "../phpscripts/get-quiz-questions.php",
        method: "GET",
        dataType: "json",
        data: { quiz_id: quizId },
        success: function (response) {
            if (response.status === "success") {
                var questions = response.data;
                var questionsHtml = "";

                questions.forEach((question, index) => {
                    questionsHtml += `
                        <div class="question">
                            <h6>Question ${index + 1}: <span>${
                        question.question_text
                    }</span></h6>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="question${
                                    question.question_id
                                }" value="A" id="choiceA${
                        question.question_id
                    }">
                                <label class="form-check-label" for="choiceA${
                                    question.question_id
                                }">${question.choice_a}</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="question${
                                    question.question_id
                                }" value="B" id="choiceB${
                        question.question_id
                    }">
                                <label class="form-check-label" for="choiceB${
                                    question.question_id
                                }">${question.choice_b}</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="question${
                                    question.question_id
                                }" value="C" id="choiceC${
                        question.question_id
                    }">
                                <label class="form-check-label" for="choiceC${
                                    question.question_id
                                }">${question.choice_c}</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="question${
                                    question.question_id
                                }" value="D" id="choiceD${
                        question.question_id
                    }">
                                <label class="form-check-label" for="choiceD${
                                    question.question_id
                                }">${question.choice_d}</label>
                            </div>
                        </div>
                    `;
                });

                $("#questionsContainer").html(questionsHtml);
                var submitBtn = `
                    <div class="text-center" style="margin-top: 4rem;">
                        <button id="submitQuiz" class="btn btn-primary">Submit Quiz</button>
                    </div>
                `;
                $("#questionsContainer").append(submitBtn);
            } else {
                console.error("Error fetching quizzes: " + response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error(error);
        },
    });
}

function submitQuiz() {
    $(document).on("click", "#submitQuiz", function (event) {
        event.preventDefault();
        var allAnswered = true;
        $("input[type='radio']").each(function () {
            var questionId = $(this).attr("name").split("question")[1];
            if (!$(`input[name='question${questionId}']:checked`).length) {
                allAnswered = false;
                $(this).closest(".question").addClass("border border-danger");
            } else {
                $(this)
                    .closest(".question")
                    .removeClass("border border-danger");
            }
        });

        if (!allAnswered) {
            toastMessage
                .text("Please answer all questions before submitting the quiz.")
                .addClass("text-danger")
                .removeClass("text-success");
            $("#liveToast").toast("show");
            return;
        }

        var userAnswers = {};
        $("input[type='radio']:checked").each(function () {
            var questionId = $(this).attr("name").split("question")[1];
            var answer = $(this).val();
            userAnswers[`question_${questionId}`] = answer;
        });

        $.ajax({
            url: "../phpscripts/user-submit-quiz.php",
            method: "POST",
            dataType: "json",
            data: { quiz_id: quizId, user_id: loggedInUserId, ...userAnswers },
            success: function (response) {
                if (response.status === "success") {
                    $("button, input").prop("disabled", true);
                    $("a")
                        .addClass("disabled")
                        .on("click", function (e) {
                            e.preventDefault();
                        });

                    $("#scoreModal .modal-body").html(
                        `<h5 class="text-center text-success fw-semibold">Quiz submitted successfully! Your score: ${response.score} out of ${response.total_questions}</h5>`
                    );
                    $("#scoreModal").modal("show");

                    setTimeout(function () {
                        window.location.href = `lecture?weekNumber${weekNumber}&id${idNumber}`;
                    }, 4000);
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
    });
}
