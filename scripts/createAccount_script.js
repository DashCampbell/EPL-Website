$(document).ready(function () {
    const paramColors = ['#009b00', '#02729e', '#bb00b2', '#dd6300', '#00488d'];
    $("#createAccount h2").each(function () {
        $(this).css({ 'color': paramColors[Math.floor(Math.random() * paramColors.length)] });
    });
});