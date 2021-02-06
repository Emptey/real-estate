// js fine for Eminence global
$(document).ready(function() {
    // code changes the main image in view property to side image
    $(document).on('click', '#side_image', function() {
        var main_img = $('#main-img'); // gets the main image
        var main_img_src = main_img.attr('src'); // stores main img src
        var side_img = $(this).attr('src'); // gets the img source of side image
        main_img.fadeOut('fast', function() {
            main_img.attr('src', side_img);
            main_img.fadeIn('fast');
        });
        $(this).attr('src', main_img_src);
    });

    $(document).on('click', '#back_image', function() {
        var main_img = $('#main-img'); // gets the main image
        var main_img_src = main_img.attr('src'); // stores main img src
        var back_img = $(this).attr('src'); // gets the img source of back image
        main_img.fadeOut('fast', function() {
            main_img.attr('src', back_img);
            main_img.fadeIn('slow');
        });
        $(this).attr('src', main_img_src);
    });

    // payment page - rent tab button command
    $('#rent-button').click(function() {
        // off sell-off list button
        $('#sell-off-list').fadeOut('fast', function() {
            // some animation
        });

        // on rent payment list button
        $('#rent-list').fadeIn('slow', function() {
            // some animation
        });


    });

    // payment page -  sell off tab button command
    $('#sell-off-button').click(function() {
        // off rent payment list button
        $('#rent-list').fadeOut('fast', function() {
            // some animation
        });

        // on sell-off payment list button
        $('#sell-off-list').fadeIn('slow', function() {
            // some animation
        });
    });
});

document.onreadystatechange = function(e) {
    if (document.readyState == "interactive") {
        var all = document.getElementsByTagName("*");
        for (var i = 0, max = all.length; i < max; i++) {
            set_ele(all[i]);
        }
    }
}

function check_element(ele) {
    var all = document.getElementsByTagName("*");
    var totalele = all.length;
    var per_inc = 100 / all.length;

    if ($(ele).on()) {
        var prog_width = per_inc + Number(document.getElementById("progress_width").value);
        document.getElementById("progress_width").value = prog_width;
        $("#bar1").animate({ width: prog_width + "%" }, 10, function() {
            if (document.getElementById("bar1").style.width == "100%") {
                $(".progress").fadeOut("slow");
            }
        });
    } else {
        set_ele(ele);
    }
}

function set_ele(set_element) {
    check_element(set_element);
}