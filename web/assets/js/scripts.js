$(function() {
    $('.show-form').click(function() {
        $(this).next().slideDown();
        $(this).addClass('hidden-form');
    });

    $('.show-review-form').click(function() {
        $('.review_form').slideDown();
        $(this).hide();
    });

    $('.fa-times').click(function() {
        $('.review_form').slideUp();
        $('.show-review-form').addClass('show');
    });

    $('.add_new_form_button').click(function() {
        $('.hidden-city').slideDown();
        $('.add_city').slideUp();
        $(this).hide();
    });

    $('.edit_past').click(function() {
        $('.edit__trip').toggle('show');
        $('.a-tag').toggle();
    });

    $('.a-tag').click(function() {
        $(this).parent().next().next().next().toggle();
    });


/* ------ slideshow ----- */
  // var index=0;
  // setTimeout(function mySlideshow(event){
  //   var i;
  //   var x=document.getElementsByClassName("my_slides");
  //   for (i=0 ; i < x.length; i++){
  //     x[i].style.display="none";
  //   }
  //   index++;
  //     if (index > x.length) {index=1}
  //       x[index-1].style.display="block";
  //     setTimeout(mySlideshow,5000)
  //
  //   },6100);

  /* ------- user dashboard ------- */
  $('.user-edit-button').click(function(){
      $('.user-info-to-hide').toggle();
      $('.hidden-form').toggle();
  });
});
