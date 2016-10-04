$(function() {
    $('.show').click(function() {
        $(this).next().slideDown();
        $(this).hide();
    });

    $('.show-review-form').click(function() {
        $('.review_form').slideDown();
        $(this).hide();
    });

    $('.fa-times').click(function() {
        $('.review_form').slideUp();
    });
});
