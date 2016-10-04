$(function() {
    $('.show-form').click(function() {
        $(this).next().slideDown();
        $(this).addClass('hidden-form');
    });
});
