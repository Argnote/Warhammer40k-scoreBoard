jQuery(function ($) {
    $('form').bind('submit', function () {
        $(this).find(':selected').prop('disabled', false);
    });
});