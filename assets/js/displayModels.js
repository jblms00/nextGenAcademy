$(document).ready(function () {
    getModelNames();
});

function getModelNames() {
    $.ajax({
        url: "../phpscripts/fetch-models.php",
        data: { lessonId: weekNumber },
        method: "POST",
        dataType: "json",
        success: function (response) {
            if (response.status === "success") {
                response.models.forEach(function (model) {
                    var newPageUrl = `viewModel?weekNumber=${model.lesson_id}&id=${model.lesson_id}&modelName=${model.model_name}&mid=${model.model_id}&uid=${model.model_uid}`;
                    var cardModel = `
                        <a href="${newPageUrl}" style="display: block; text-decoration: none; color: inherit;">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title text-center">${model.model_name}</h5>
                                </div>
                            </div>
                        </a>
                    `;
                    $(".contianer-models").append(cardModel);
                });
            } else {
            }
        },
        error: function (xhr, status, error) {
            console.error(error);
        },
    });
}
