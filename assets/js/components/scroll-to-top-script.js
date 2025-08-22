$(document).ready(function () {
    var $mybutton = $("#backToTop");

    $(window).scroll(function () {
        if ($(this).scrollTop() > 20) {
            $mybutton.fadeIn();
        } else {
            $mybutton.fadeOut();
        }
    });

    $mybutton.click(function () {
        $("html, body").animate({ scrollTop: 0 }, "fast");
    });
});
