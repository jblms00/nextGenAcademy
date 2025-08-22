$(document).ready(function () {
    displayLessons();
});

function displayLessons() {
    $.ajax({
        url: "../phpscripts/fetch-lessons.php",
        method: "GET",
        dataType: "json",
        success: function (response) {
            if (response.status === "success") {
                var lessons = response.lessons;
                var lessonsHtml = "";

                lessons.forEach(function (lesson) {
                    lessonsHtml += `
                    <div class="card" data-lesson-id="${lesson.lesson_id}" data-week-number="${lesson.week_number}">
                        <img src="../assets/images/lessonsBanner/${lesson.lesson_image_banner}" class="card-img-top" alt="img">
                        <div class="card-body text-center">
                            <h5 class="card-title fw-bold mb-4">Week ${lesson.week_number}: ${lesson.lesson_title}</h5>
                            <p class="card-text">${lesson.lesson_description}</p>
                        </div>
                    </div>`;
                });

                $(".container-lessons").html(lessonsHtml);

                $(".container-lessons").on("click", ".card", function () {
                    var weekNumber = $(this).data("week-number");
                    var lessonId = $(this).data("lesson-id");
                    window.location.href = `lecture?weekNumber${weekNumber}&id${lessonId}`;
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
