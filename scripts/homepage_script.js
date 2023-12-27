$(document).ready(function () {
    //<-----------  Home Page Content      ----------->
    // News Section Input
    var nCurrentPanel = 0;
    const numPanels = $(".newsGallery-container ul li").length

    function switchNewsPanel(newPanel) {
        $(".newsGallery-container ul li:nth-child(" + (nCurrentPanel + 1) + ")").fadeOut(300, function () {
            $(".newsGallery-container ul li:nth-child(" + (newPanel + 1) + ")").fadeIn(300);
        });

        $(".gallery-selector span").css("background-color", "#bbb");
        $(".gallery-selector span:nth-child(" + (newPanel + 1) + ")").css("background-color", "#717171");
        nCurrentPanel = newPanel;
    }
    // Set Default Panel
    $(".newsGallery-container ul li").hide();
    $(".newsGallery-container ul li:nth-child(" + (nCurrentPanel + 1) + ")").show();
    $(".gallery-selector span:nth-child(" + (nCurrentPanel + 1) + ")").css("background-color", "#717171");

    // Input
    $(".prev").on("click", function () {
        switchNewsPanel((nCurrentPanel + (numPanels - 1)) % numPanels);
    });
    $(".next").on("click", function () {
        switchNewsPanel((nCurrentPanel + 1) % numPanels);
    });
    for (let i = 0; i < numPanels; i++) {
        $(".gallery-selector span:nth-child(" + (i + 1) + ")").on("click", function () {
            switchNewsPanel(i);
        });
    }
});