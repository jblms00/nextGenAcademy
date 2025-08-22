$(document).ready(function () {
    let sidebar = $(".sidebar");
    let closeBtn = $("#btn");
    let capIcon = $(".fa-graduation-cap");

    function adjustSidebar() {
        if (window.innerWidth <= 768) {
            // Adjust the threshold as needed
            if (sidebar.hasClass("open")) {
                sidebar.css("width", "89%");
            }
        } else {
            if (sidebar.hasClass("open")) {
                sidebar.css("width", "275px");
            } else {
                sidebar.css("width", "78px");
            }
        }
    }

    closeBtn.on("click", function () {
        sidebar.toggleClass("open");

        if (sidebar.hasClass("open")) {
            capIcon.removeClass("d-none");
            adjustSidebar(); // Adjust sidebar width based on screen size
        } else {
            capIcon.addClass("d-none");
            sidebar.css("width", "78px");
        }
    });

    $(window).on("resize", function () {
        adjustSidebar();
    });

    // Initial adjustment
    adjustSidebar();
});
