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

    // function to get user chart for investment rate
    function get_user_chart_record(data, label) {
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: label,
                datasets: [{
                    label: '# of Investments',
                    data: data,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgb(61, 146, 118)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgb(61, 146, 118)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
        });
    }

    function set_user_chart_record() {
        var id = $('#active_id').val();
        $.ajax({
            url: '/api/investment-rate/' + id,
            type: 'GET',
            // headers: {
            //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            // },
            dataType: 'json',
            success: function(data) {
                // create array for data and label
                var recieved_data = [];
                var label = [];

                // check if data is empty
                if (data.length == 0) {
                    // display div with warning
                    $('#warning').text('No investment data.');
                } else {
                    // loop through returned data
                    for (var i in data) {
                        label.push(i);
                        recieved_data.push(data[i].length);
                        // console.log(i + "  " + data[i].length);
                    }
                }

                // pass data to chart
                get_user_chart_record(recieved_data, label);
            },
            error: function(data) {
                console.log(data);
            }
        });
    }

    set_user_chart_record();
});

$(document).ready(function() {
    function getMyChart(data, label) {
        var ctx = document.getElementById('myChart2').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: label,
                datasets: [{
                    label: '# return rate',
                    data: data,
                    backgroundColor: [
                        'rgb(61, 146, 118)'
                    ],
                    borderColor: [
                        'rgb(61, 146, 118)'
                    ],
                    borderWidth: 1
                }]
            },
        });
    }

    function getMyChartData() {
        var id = $('#active_id').val();
        $.ajax({
            url: '/api/rentage-rate/' + id,
            type: 'GET',
            // headers: {
            //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            // },
            dataType: 'json',
            success: function(data) {
                // create array for data and label
                var recieved_data = [];
                var label = [];

                // check if data is empty
                if (data.length == 0) {
                    // display div with warning
                    $('#warning').text('No investment data.');
                } else {
                    // loop through returned data
                    for (var i in data) {
                        label.push(i);
                        recieved_data.push(data[i].length);
                    }
                }

                // pass data to chart
                getMyChart(recieved_data, label);
            },
            error: function(received_data) {
                console.log(received_data);
            }
        });
    }

    getMyChartData()
});

$(document).ready(function() {
    var ct = document.getElementById('overview').getContext('2d');
    var overview = new Chart(ct, {
        type: 'doughnut',
        data: {
            labels: ['Red', 'Blue', 'Yellow'],
            datasets: [{
                label: '# of Votes',
                data: [12, 19, 3],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1,
            }]
        },
        options: {
            legend: {
                display: true,
                position: 'bottom',
            },
        },

    });

});

$(document).ready(function() {
    function get_pie_data(data, label) {
        var ct = document.getElementById('status').getContext('2d');
        var overview = new Chart(ct, {
            type: 'pie',
            data: {
                labels: label,
                datasets: [{
                    label: '# of Votes',
                    data: data,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1,
                }]
            },
            options: {
                legend: {
                    display: true,
                    position: 'bottom',
                },
            },

        });
    }

    function set_pie_data() {
        var id = $('#active_id').val();

        $.ajax({
            url: '/api/investment-status/' + id,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                // initialize data and label array
                var data_received = [];
                var label = [];

                // iterate throuhg recieved data
                for (var i in data) {
                    // push recieved data to arrays
                    data_received.push(data[i]);
                    label.push(i);
                }

                get_pie_data(data_received, label);
            },
            error: function(data) {
                console.log(data);
            }
        });
    }

    set_pie_data();

});


// function for page loader
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
// end page loader

// chart js dashboard