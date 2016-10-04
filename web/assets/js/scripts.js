$(function() {
    $('.show').click(function() {
        $(this).next().slideDown();
        $(this).hide();
    });
});
