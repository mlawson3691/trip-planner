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

    $('.edit_past').click(function() {
        $('.edit__past').addClass('show');
        $('.past_activities a').toggle('shpw');
        $('.edit_past_form').toggle('slide');
    });

    $('.past_activities a').click(function() {
        $('.edit-past-activity').addClass('show');
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
