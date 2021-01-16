// js fine for Eminence global
$(document).ready( function(){
    // code changes the main image in view property to side image
    $(document).on('click', '#side_image', function(){
        var main_img = $('#main-img'); // gets the main image
        var main_img_src = main_img.attr('src'); // stores main img src
        var side_img = $(this).attr('src');  // gets the img source of side image
        main_img.fadeOut('fast', function(){
            main_img.attr('src', side_img);
            main_img.fadeIn('fast');
        });
        $(this).attr('src', main_img_src);
    });

    $(document).on('click', '#back_image', function(){
        var main_img = $('#main-img'); // gets the main image
    var main_img_src = main_img.attr('src'); // stores main img src
        var back_img = $(this).attr('src');  // gets the img source of back image
        main_img.fadeOut('fast', function(){
            main_img.attr('src', back_img);
            main_img.fadeIn('slow');
        });
        $(this).attr('src', main_img_src);
    });
});