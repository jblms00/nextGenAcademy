const urlParams = new URLSearchParams(window.location.search);
const uid = urlParams.get("uid");
const mid = urlParams.get("mid");

console.log(uid);

$(document).ready(function () {
    getModel();
    loadSketchfabModel(uid);
});

function getModel() {
    $.ajax({
        url: "../phpscripts/get-model.php",
        type: "GET",
        data: { model_id: mid },
        dataType: "json",
        success: function (response) {
            if (response.status === "success") {
                $("#modelDescription").text(
                    response.modelData.model_description
                        ? response.modelData.model_description
                        : "No descriptions"
                );
            } else {
                console.error(response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error: " + status + " " + error);
        },
    });
}

function loadSketchfabModel(uid) {
    var iframe = document.getElementById("api-frame");
    var client = new Sketchfab(iframe);

    client.init(uid, {
        success: function (api) {
            api.start();
            api.addEventListener("viewerready", function () {
                iframe.classList.remove("hidden");
            });
        },
        error: function () {
            console.log("Viewer error");
        },
    });
}
