$(document).ready(function () {
    // Custom Slider
    function cus_ToggleSlide(e) {
        // Checki if 'e' is slid down
        if (e.hasClass("visible-block")) {
            // Slide Up
            e.slideUp(400, function () {
                e.show().removeClass("visible-block");
            });
        } else {
            // Slide Down
            e.hide().addClass("visible-block").slideDown();
        }
    }
    //<-----------  Heading Input   ----------------->
    // Login/Register Button
    $("#login-btn div").on("click", function () {
        $(this).next().toggle();
    });

    // Middle Header Mobile Search Button
    $("#mobile-search-btn").on("click", function () {
        cus_ToggleSlide($("#header-search"));
    });

    // Lower Header Mobile Menu Button
    $("#mobile-nav-btn").on("click", function () {
        // Hide Drop Menu
        $(".bottom-drop-menu").slideUp();
        // Reveal Navigation Menu
        cus_ToggleSlide($("#bottom-header > ul"));
    });

    // Lower Header Drop Menus
    $("#bottom-header > ul li p").on("click", function () {
        let dropMenu = $(".bottom-drop-menu:nth-of-type(" + ($(this).parent().index() + 1) + ")");

        //check if menu is not visible
        if (dropMenu.css("display") == "none") {
            let bShown = false;
            $(".bottom-drop-menu").each(function () {
                if ($(this).css("display") !== 'none') {
                    bShown = true;
                    return false;
                }
            });
            // Hide all drop menus
            $(".bottom-drop-menu").hide();
            // Only show current menu
            if (bShown)
                dropMenu.show();
            else
                dropMenu.slideDown(200);
        } else {
            // Hide all drop menus
            dropMenu.slideUp(200);
        }
    });
});