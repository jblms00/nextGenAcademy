$(document).ready(function () {
    displayQuizzes();

    $(document).on("click", ".btn-danger", function () {
        var quizId = $(this).closest("tr").data("quizid");
        $("#deleteModal").modal("show");

        $("#deleteModal .btn.btn-primary")
            .off("click")
            .on("click", function () {
                confirmQuizDelete(quizId);
            });
    });

    $(document).on("click", ".btn-primary.edit", function () {
        var quizId = $(this).closest("tr").data("quizid");
        var topic = $(this).closest("tr").data("topic");
        fetchQuizQuestions(quizId);

        $("#quizTopic").text(topic);
        $(".update-quiz").attr("data-quizid", quizId);
        $("#editQuizModal").modal("show");
    });

    $("#editQuizForm").submit(function (event) {
        event.preventDefault();
        var quizId = $(this).find(".update-quiz").data("quizid");
        editQuiz(quizId);
    });

    $("#createQuizForm").submit(function (event) {
        event.preventDefault();
        var isValid = true;

        if ($("#newQuizTopic").val() === null) {
            $("#newQuizTopic").addClass("is-invalid");
            isValid = false;
        } else {
            $("#newQuizTopic").removeClass("is-invalid");
        }

        $(".question-container").each(function () {
            var questionText = $(this).find("input[type='text']").first();
            var choices = $(this).find(".choice-input");
            var correctAnswer = $(this).find(".correct-answer");

            if (questionText.val().trim() === "") {
                questionText.addClass("is-invalid");
                isValid = false;
            } else {
                questionText.removeClass("is-invalid");
            }

            choices.each(function () {
                if ($(this).val().trim() === "") {
                    $(this).addClass("is-invalid");
                    isValid = false;
                } else {
                    $(this).removeClass("is-invalid");
                }
            });

            if (correctAnswer.val().trim() === "") {
                correctAnswer.addClass("is-invalid");
                isValid = false;
            } else {
                correctAnswer.removeClass("is-invalid");
            }
        });

        if (isValid) {
            addNewQuizQuestion();
        }
    });

    var questionCount = 1;
    $("#addQuestionButton").on("click", function () {
        questionCount++;
        var questionHtml = `
            <div class="mb-4 question-container">
                <label for="question-${
                    questionCount - 1
                }" class="form-label mb-0 fw-semibold">Question ${questionCount}:</label>
                <input type="text" class="form-control" id="question-${
                    questionCount - 1
                }" required>
                <div class="choices-container mt-2">
                    <label class="form-label">Choices:</label>
                    <input type="text" class="form-control mb-1 choice-input" placeholder="Choice A" required>
                    <input type="text" class="form-control mb-1 choice-input" placeholder="Choice B" required>
                    <input type="text" class="form-control mb-1 choice-input" placeholder="Choice C" required>
                    <input type="text" class="form-control mb-2 choice-input" placeholder="Choice D" required>
                    <span class="fw-semibold">Correct Answer: </span>
                    <input type="text" class="form-control mb-1 correct-answer" required>
                    <div class="invalid-feedback">All choices and correct answer must be filled.</div>
                </div>
            </div>`;
        $("#newQuizQuestionsContainer").append(questionHtml);
    });
});

var dataTable = $("#quizzesTable").DataTable({
    autoWidth: true,
    scrollX: true,
    columns: [
        { width: "20%" },
        { width: "10%" },
        { width: "10%" },
        { width: "15%" },
        { width: "15%" },
        { width: "20%" },
    ],
    createdRow: function (row, data, dataIndex) {
        $(row).attr("data-topic", data[0]);
        $(row).attr("data-quizid", data[6]);
        $(row).attr("data-week-number", data[1]);
        $(row).attr("data-total-questions", data[2]);
        $(row).attr("data-question-types", data[3]);
        $(row).attr("data-datetime-created", data[4]);
        $(row).attr("data-lessonid", data[7]);
    },
    data: [],
    language: {
        emptyTable: "No matching records found",
    },
});

function displayQuizzes() {
    $.ajax({
        url: "../phpscripts/admin/fetch-quizzes.php",
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.status === "success") {
                var quizTopicSelect = $("#newQuizTopic");
                quizTopicSelect.empty();
                quizTopicSelect.append(
                    "<option selected disabled>Please select quiz topic</option>"
                );

                var topicsResult = response.topics.map((topic) => {
                    quizTopicSelect.append(
                        `<option value="${topic.lessonId}">${topic.Topic}</option>`
                    );

                    var formattedQuestionType = formatQuestionType(
                        topic.QuestionTypes
                    );

                    return [
                        topic.Topic,
                        topic.WeekNumber,
                        topic.TotalQuestions,
                        formattedQuestionType,
                        formatDateTime(topic.DateTimeCreated),
                        `<div class="d-flex align-items-center gap-2">
                            <a href="quizResults?weekNumber${topic.WeekNumber}&lesson${topic.lessonId}&${topic.Topic}" class="btn btn-sm btn-info text-light"><span><i class="fa-regular fa-eye me-2"></i></span>Results</a>
                            <button type="button" class="btn btn-sm btn-primary edit"><span><i class="fa-regular fa-pen-to-square me-2"></i></span>View</button>
                            <button type="button" class="btn btn-sm btn-danger"><span><i class="fa-regular fa-trash-can me-2"></i></span>Delete</button>
                        </div>`,
                        topic.quizId,
                        topic.lessonId,
                    ];
                });
                dataTable.clear().rows.add(topicsResult).draw();
            } else {
                console.error(response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error(error);
        },
    });
}

function formatQuestionType(questionType) {
    return questionType
        .split("-")
        .map((word) => word.charAt(0).toUpperCase() + word.slice(1))
        .join(" ");
}

function confirmQuizDelete(quizId) {
    $.ajax({
        url: "../phpscripts/admin/delete-quiz.php",
        method: "POST",
        dataType: "json",
        data: { lesson_id: quizId },
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

function fetchQuizQuestions(quizId) {
    $.ajax({
        url: "../phpscripts/admin/fetch-quiz-questions.php",
        type: "GET",
        data: { quizId: quizId },
        dataType: "json",
        success: function (response) {
            if (response.status === "success") {
                var quizQuestionsContainer = $("#quizQuestionsContainer");
                quizQuestionsContainer.empty();

                response.questions.forEach(function (question, index) {
                    var questionHtml = `
                        <div class="mb-4 question-container" data-question-id="${
                            question.question_id
                        }">
                            <label for="question-${index}" class="form-label mb-0 fw-semibold">Question ${
                        index + 1
                    }:</label>
                            <input type="text" class="form-control" id="question-${index}" value="${
                        question.question_text
                    }" required>
                            <div class="invalid-feedback text-danger">Question cannot be empty.</div>
                            <label class="form-label mt-2 mb-0 fw-semibold">Choices:</label>
                            <div class="choices-container">`;

                    if (question.choice_a) {
                        questionHtml += `
                            <input type="text" class="form-control mb-1 choice-input" id="choice-${index}-0" value="${question.choice_a}" required>
                            <div class="invalid-feedback text-danger">Choice A cannot be empty.</div>`;
                    }
                    if (question.choice_b) {
                        questionHtml += `
                            <input type="text" class="form-control mb-1 choice-input" id="choice-${index}-1" value="${question.choice_b}" required>
                            <div class="invalid-feedback text-danger">Choice B cannot be empty.</div>`;
                    }
                    if (question.choice_c) {
                        questionHtml += `
                            <input type="text" class="form-control mb-1 choice-input" id="choice-${index}-2" value="${question.choice_c}" required>
                            <div class="invalid-feedback text-danger">Choice C cannot be empty.</div>`;
                    }
                    if (question.choice_d) {
                        questionHtml += `
                            <input type="text" class="form-control mb-2 choice-input" id="choice-${index}-3" value="${question.choice_d}" required>
                            <div class="invalid-feedback text-danger">Choice D cannot be empty.</div>`;
                    }

                    questionHtml += `
                                <span class="fw-semibold">Correct Answer: </span>
                                <input type="text" class="form-control mb-1 correct-answer" value="${question.correct_answer}" required>
                                <div class="invalid-feedback text-danger">Correct answer cannot be empty.</div>
                            </div>
                        </div>`;

                    quizQuestionsContainer.append(questionHtml);
                });
            } else {
                console.error(response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error(error);
        },
    });
}

function editQuiz(quizId) {
    var questions = [];

    $(".question-container").each(function () {
        var questionId = $(this).data("question-id");
        var questionText = $(this)
            .find("input[type='text']")
            .first()
            .val()
            .trim();
        var choices = [];

        $(this)
            .find(".choice-input")
            .each(function () {
                choices.push($(this).val().trim());
            });

        var correctAnswer = $(this).find(".correct-answer").val().trim();

        questions.push({
            question_id: questionId,
            question_text: questionText,
            choices: choices,
            correct_answer: correctAnswer,
        });
    });

    let isValid = true;
    $(".question-container").each(function () {
        $(this).removeClass("was-validated");
        $(this)
            .find(".form-control")
            .removeClass("is-invalid")
            .removeClass("is-valid");

        if ($(this).find("input[type='text']").first().val().trim() === "") {
            isValid = false;
            $(this).addClass("was-validated");
            $(this).find("input[type='text']").first().addClass("is-invalid");
        } else {
            $(this).find("input[type='text']").first().addClass("is-valid");
        }

        $(this)
            .find(".choice-input")
            .each(function () {
                if ($(this).val().trim() === "") {
                    isValid = false;
                    $(this).addClass("is-invalid");
                } else {
                    $(this).addClass("is-valid");
                }
            });

        if ($(this).find(".correct-answer").val().trim() === "") {
            isValid = false;
            $(this).find(".correct-answer").addClass("is-invalid");
        } else {
            $(this).find(".correct-answer").addClass("is-valid");
        }
    });

    if (!isValid) {
        return;
    }

    $.ajax({
        url: "../phpscripts/admin/update-quiz-questions.php",
        type: "POST",
        dataType: "json",
        data: {
            quiz_id: quizId,
            questions: JSON.stringify(questions),
        },
        success: function (response) {
            console.log("Update response:", response);
            if (response.status === "success") {
                $("#liveToast .toast-body p")
                    .text(response.message)
                    .addClass("text-success")
                    .removeClass("text-danger");
                $("#liveToast").toast("show");
                $("#editQuizModal").modal("hide");
                displayQuizzes();
            } else {
                $("#liveToast .toast-body p")
                    .text(response.message)
                    .addClass("text-danger")
                    .removeClass("text-success");
                $("#liveToast").toast("show");
            }
        },
        error: function (xhr, status, error) {
            console.error("AJAX error:", error);
        },
    });
}

function addNewQuizQuestion() {
    var quizTopic = $("#newQuizTopic").val();
    var questions = [];

    $(".question-container").each(function () {
        var questionText = $(this)
            .find("input[type='text']")
            .first()
            .val()
            .trim();
        var choices = [];

        $(this)
            .find(".choice-input")
            .each(function () {
                choices.push($(this).val().trim());
            });

        var correctAnswer = $(this).find(".correct-answer").val().trim();

        questions.push({
            question_text: questionText,
            choices: choices,
            correct_answer: correctAnswer,
        });
    });

    $.ajax({
        url: "../phpscripts/admin/add-quiz-question.php",
        type: "POST",
        dataType: "json",
        data: {
            quiz_title: quizTopic,
            questions: JSON.stringify(questions),
        },
        success: function (response) {
            console.log("Create Quiz response:", response);
            if (response.status === "success") {
                $("#liveToast .toast-body p")
                    .text(response.message)
                    .addClass("text-success")
                    .removeClass("text-danger");
                $("#liveToast").toast("show");
                $("#addQuizQuestionModal").modal("hide");
                displayQuizzes();
            } else {
                $("#liveToast .toast-body p")
                    .text(response.message)
                    .addClass("text-danger")
                    .removeClass("text-success");
                $("#liveToast").toast("show");
            }
        },
        error: function (xhr, status, error) {
            console.error("AJAX error:", error);
        },
    });
}
