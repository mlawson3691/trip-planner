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

    // handle star clicks
    $('#star-one').click(function() {
        $('#star-one').attr('src', '/assets/img/star-gold.svg');
        $('#star-two').attr('src', '/assets/img/star-empty.svg');
        $('#star-three').attr('src', '/assets/img/star-empty.svg');
        $('#star-four').attr('src', '/assets/img/star-empty.svg');
        $('#star-five').attr('src', '/assets/img/star-empty.svg');
    });

    $('#star-two').click(function() {
        $('#star-one').attr('src', '/assets/img/star-gold.svg');
        $('#star-two').attr('src', '/assets/img/star-gold.svg');
        $('#star-three').attr('src', '/assets/img/star-empty.svg');
        $('#star-four').attr('src', '/assets/img/star-empty.svg');
        $('#star-five').attr('src', '/assets/img/star-empty.svg');
    });

    $('#star-three').click(function() {
        $('#star-one').attr('src', '/assets/img/star-gold.svg');
        $('#star-two').attr('src', '/assets/img/star-gold.svg');
        $('#star-three').attr('src', '/assets/img/star-gold.svg');
        $('#star-four').attr('src', '/assets/img/star-empty.svg');
        $('#star-five').attr('src', '/assets/img/star-empty.svg');
    });

    $('#star-four').click(function() {
        $('#star-one').attr('src', '/assets/img/star-gold.svg');
        $('#star-two').attr('src', '/assets/img/star-gold.svg');
        $('#star-three').attr('src', '/assets/img/star-gold.svg');
        $('#star-four').attr('src', '/assets/img/star-gold.svg');
        $('#star-five').attr('src', '/assets/img/star-empty.svg');
    });

    $('#star-five').click(function() {
        $('#star-one').attr('src', '/assets/img/star-gold.svg');
        $('#star-two').attr('src', '/assets/img/star-gold.svg');
        $('#star-three').attr('src', '/assets/img/star-gold.svg');
        $('#star-four').attr('src', '/assets/img/star-gold.svg');
        $('#star-five').attr('src', '/assets/img/star-gold.svg');
    });

    // // handle star hovers
    // $('#star-one').hover(function() {
    //     $('#star-one').attr('src', '/assets/img/star-gold.svg');
    // }, function() {
    //     $('#star-one').attr('src', '/assets/img/star-empty.svg');
    // });
    //
    // $('#star-two').hover(function() {
    //     $('#star-one').attr('src', '/assets/img/star-gold.svg');
    //     $('#star-two').attr('src', '/assets/img/star-gold.svg');
    // }, function() {
    //     $('#star-one').attr('src', '/assets/img/star-empty.svg');
    //     $('#star-two').attr('src', '/assets/img/star-empty.svg');
    // });
    //
    // $('#star-three').hover(function() {
    //     $('#star-one').attr('src', '/assets/img/star-gold.svg');
    //     $('#star-two').attr('src', '/assets/img/star-gold.svg');
    //     $('#star-three').attr('src', '/assets/img/star-gold.svg');
    // }, function() {
    //     $('#star-one').attr('src', '/assets/img/star-empty.svg');
    //     $('#star-two').attr('src', '/assets/img/star-empty.svg');
    //     $('#star-three').attr('src', '/assets/img/star-empty.svg');
    // });
    //
    // $('#star-four').hover(function() {
    //     $('#star-one').attr('src', '/assets/img/star-gold.svg');
    //     $('#star-two').attr('src', '/assets/img/star-gold.svg');
    //     $('#star-three').attr('src', '/assets/img/star-gold.svg');
    //     $('#star-four').attr('src', '/assets/img/star-gold.svg');
    // }, function() {
    //     $('#star-one').attr('src', '/assets/img/star-empty.svg');
    //     $('#star-two').attr('src', '/assets/img/star-empty.svg');
    //     $('#star-three').attr('src', '/assets/img/star-empty.svg');
    //     $('#star-four').attr('src', '/assets/img/star-empty.svg');
    // });
    //
    // $('#star-five').hover(function() {
    //     $('#star-one').attr('src', '/assets/img/star-gold.svg');
    //     $('#star-two').attr('src', '/assets/img/star-gold.svg');
    //     $('#star-three').attr('src', '/assets/img/star-gold.svg');
    //     $('#star-four').attr('src', '/assets/img/star-gold.svg');
    //     $('#star-five').attr('src', '/assets/img/star-gold.svg');
    // }, function() {
    //     $('#star-one').attr('src', '/assets/img/star-empty.svg');
    //     $('#star-two').attr('src', '/assets/img/star-empty.svg');
    //     $('#star-three').attr('src', '/assets/img/star-empty.svg');
    //     $('#star-four').attr('src', '/assets/img/star-empty.svg');
    //     $('#star-five').attr('src', '/assets/img/star-empty.svg');
    // });


});
