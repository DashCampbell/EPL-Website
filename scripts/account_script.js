$(document).ready(function () {
    // Checkout Items Page

    $(".browse-items-order>div>span").on('click', function () {
        $(this).next().toggle();
    });


    // Select All Checkboxes Box
    $(".accountItemsList>form>label input").on('click', function () {
        var bChecked = this.checked;
        $(".accountCheckBox input").each(function () {
            this.checked = bChecked;
        });
        $(".account-footer-menu").slideToggle();
    });
    // Clear Checkboxes button
    $(".account-footer-menu button").on('click', function () {
        $(".accountCheckBox input").each(function () {
            this.checked = false;
        });
        $(this).parent().slideUp();
    });

    // Renew/Hold Button
    $(".accountItem-right-description input").on('click', function () {
        $(this).parent().parent().parent().find('label input')[0].checked = true;
    });
});