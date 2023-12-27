$(document).ready(function () {
    // Browse Page Content

    // Filter Drop Down Menus
    $(".browse-filter h2").on("click", function () {
        $(this).next().slideToggle(250);
    });
    // Sort Drop Down Menu
    $(".browse-items-order>div:nth-of-type(1) span").on("click", function () {
        $(this).next().toggle();
    });

    // Place a Hold Button Script

});