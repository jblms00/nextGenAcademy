$(document).ready(function () {
    updateSystemAppearance();
    previewImages();
});

function updateSystemAppearance() {
    $(document).on("submit", "#appearanceForm", function (event) {
        event.preventDefault();
        var form = this;
        var formData = new FormData(form);

        $.ajax({
            url: "../phpscripts/admin/update-appearance.php",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function (response) {
                if (response.status === "success") {
                    $("#liveToast .toast-body p")
                        .text(response.message)
                        .addClass("text-success")
                        .removeClass("text-danger");
                    location.reload();
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

function previewImages() {
    $("#backgroundImage").on("change", function (event) {
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.onload = function (e) {
            $(".preview-bg-container").html(
                `<img src="${e.target.result}" height="100%" width="80%" alt="Background Preview">`
            );
        };

        if (file) {
            reader.readAsDataURL(file);
        }
    });

    $("#logoImage").on("change", function (event) {
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.onload = function (e) {
            $(".preview-logo-container").html(
                `<img src="${e.target.result}" height="300" width="300" alt="Logo Preview">`
            );
        };

        if (file) {
            reader.readAsDataURL(file);
        }
    });
}
