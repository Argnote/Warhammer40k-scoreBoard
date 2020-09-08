jQuery(function ($) {
    $('form').bind('submit', function () {
        $(this).find(':selected',':input').prop('disabled', false);
    });
});