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
        $('.a-tag').toggle();
        $('.add_activity').toggle('slide');
        $('.add_city').toggle('slide');
    });

    $('.a-tag').click(function() {
        // $(this).next().show();
        // $(this).addClass('hidden-form');
        $(this).parent().next().next().next().toggle();
        // $('.a-tag').hide();
    });



/* ------- Introduction page -------- */

  $(".background_image").fadeIn(3000);

  setTimeout(function(){
    $("#pop-up").fadeIn("fast");
    $("#pop-up").animate({
      "width": "450px",
      "height":"200px",
  },700);
  },900);

  setTimeout(function(){
   $(".intro").fadeIn("slow");
 },1800);

  setTimeout(function(){
    $(".title").fadeOut("200");
    $( ".subtitle" ).slideUp("slow");
  },3600);

  setTimeout(function(){
    $("#pop-up").animate({
        "height":"0px",
        "border-style":"none",
        "transition":"0.5s ease"});
    $(".background_image").fadeOut(900);
    },4200);

  setTimeout(function(){
    $('#wrapper').addClass('hide');
    $('.hidden-homepage').fadeIn('800');
  },5100);

  setTimeout(function(){
    $(".intro_slides, .overlay").fadeIn(1500);
  },6100);

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
});
