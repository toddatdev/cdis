$(function () {


    $('.datepicker').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        changeYear: true,
        changeMonth: true,
        calendarWeeks: true,
        autoclose: true
    });

    //updates ymd input dates to HTML 5 date inputs
    update_ymd_dates();

    $('.datepicker').on('change', function () {

        if ($(this).val().length) {

            var ymd_date_input = $(this).closest('.form-group').find('.ymd-date-input');

            //converts and gets mysql formatted date
            var ymd_formatted_date = toSqlDate($(this).val());

            ymd_date_input.val(ymd_formatted_date);
        }
    });


    //start on page load
    startIdleInterval();

    var idleTimeInterval = false;

    function startIdleInterval() {

        var idleTime = 0;

        //timer interval is not false (means it's already stop)
        if (!idleTimeInterval) {

            //Increment the idle time counter every minute.
            idleTimeInterval = setInterval(timerIncrement, 60000); // 1 minute

            //Zero the idle timer on mouse movement.
            $(this).mousemove(function (e) {
                idleTime = 0;
            });
            $(this).keypress(function (e) {
                idleTime = 0;
            });

            function timerIncrement() {
                idleTime = idleTime + 1;
                if (idleTime > 10) { // 15 minutes
                    initTimer();
                }
                console.log(idleTime);
            }
        }
    }


    var timerInterval = '';

    function initTimer() {

        var timer = "04:59";

        //timer interval is not false (means it's already stop)
        if (!timerInterval) {

            timerInterval = setInterval(function () {

                timer = timer.split(':');

                //by parsing integer, I avoid all extra string processing
                var minutes = parseInt(timer[0], 10);
                var seconds = parseInt(timer[1], 10);

                --seconds;

                minutes = (seconds < 0) ? --minutes : minutes;
                // if (minutes < 0) clearInterval(timerInterval);
                seconds = (seconds < 0) ? 59 : seconds;
                seconds = (seconds < 10) ? '0' + seconds : seconds;

                //minutes = (minutes < 10) ?  minutes : minutes;

                if (seconds < 32) {

                    console.log('shown');
                    $('#modal-timer-logout').modal('show');
                }

                if (minutes <= 0 && parseInt(seconds) <= 1) {

                    resetTimer();

                    document.location.href = '/logout';
                }

                $('#minutes').text(String(minutes).padStart(2, '0'));
                $('#seconds').text(String(seconds).padStart(2, '0'));
                timer = minutes + ':' + seconds;

                console.log(timer);

            }, 1000);
        }

    }


    function resetTimer() {
        clearInterval(timerInterval);
        clearInterval(idleTimeInterval);
        timerInterval = false;
        idleTimeInterval = false;
    }


    $('#btn-rest-timer').on('click', function (e) {
        e.preventDefault();

        console.log('rest btn clicked!');

        //stop the timer
        resetTimer();

        $('#modal-timer-logout').modal('hide');
    });

});


//show the spinner
function showSpiner(clicked_btn) {
    clicked_btn.prop('disabled', true);
    clicked_btn.html('Processing <span class="fa fa-spinner fa-spin" style="position:relative; top:2px; font-family: FontAwesome !important;"></span>');
}

//hide the spinner by adding hide_spinner class
function hideSpinner(clicked_btn, btn_text = 'Save & Continue') {
    clicked_btn.prop('disabled', false);
    clicked_btn.html(btn_text);
}

function notify(title, message) {

    setTimeout(function () {
        toastr.options = {
            closeButton: true,
            progressBar: true,
            showMethod: 'slideDown',
            timeOut: 4000
        };
        toastr.success(message, title);

    }, 100);
}


function addMarkers(whose) {
    // me = { { Auth::id() } } ;
    //
    for (var i = 0; i < markers.length; i++) {
        markers[i].setMap(null);
    }

    // markme = { !!json_encode($markers) !! } ;

    for (var i = 0; i < markme.length; i++) {
        var mark = markme[i];

        // if (whose == "mine" && mark[4] != me) {
        //     continue;
        // }
        var marker = new google.maps.Marker({
            position: {lat: mark[1], lng: mark[2]},
            map: map,
            title: mark[0],
            url: mark[3]
        });
        markers.push(marker);
        console.log(markers);
        google.maps.event.addListener(marker, 'click', function () {
            window.location.href = this.url;
        });
    }
}

//add leading zero to single number to 01
Number.prototype.pad = function (size) {
    var s = String(this);
    while (s.length < (size || 2)) {
        s = "0" + s;
    }
    return s;
};

//
// function showMine() {
//     addMarkers("mine");
// }
//
// function showAll() {
//     addMarkers("all");
// }

//converts to Y-m-d formats which is acceptable by MYSQL
function toSqlDate(htmlDate) {

    if (htmlDate.length) {
        var jsDate = new Date(htmlDate);
        //converts to Y-m-d formats which is acceptable by MYSQL
        return jsDate.getFullYear() + '-' + (jsDate.getMonth() + 1).pad(2) + '-' + jsDate.getDate().pad(2);
    }
}

//converts to MM/DD/YYYY formats which is US format in UI
function toHtmlDate(sqlDate) {

    if (sqlDate.length) {

        var dateParts = sqlDate.split("-");

        var jsDate = new Date(dateParts[0], dateParts[1] - 1, dateParts[2].substr(0, 2));

        //converts to MM/DD/YYYY formats which is acceptable by MYSQL
        return (jsDate.getMonth() + 1).pad(2) + '/' + jsDate.getDate().pad(2) + '/' + jsDate.getFullYear();
    }
}

function resetForm(form) {

    //reset HTML form [will not reset project-name field in permit info record time)
    form.find('select,input:text,radio').not('.project-name').not('project-id').val('');
}

//updates ymd dates to html date format
function update_ymd_dates() {
    var ymd_date_inputs = $('.ymd-date-input');

    ymd_date_inputs.each(function (index, input) {

        if (input.value.length) {

            var html_date_input = $(input).parents('.form-group').find('input.datepicker');

            //converts and gets mysql formatted date
            var html_formatted_date = toHtmlDate(input.value);

            html_date_input.val(html_formatted_date);
        }

    });
}

