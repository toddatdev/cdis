window.addEventListener('beforeunload', function (event) {
    console.log('I am the 1st one.');
    alert('1st one');
});
window.addEventListener('unload', function (event) {
    console.log('I am the 3rd one.');
    alert('second one');
});


$(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var datePicker = $('body').find('.datepicker');


    //adds link to clear the date inputs
    datePicker.after('<a href="#" class="clear-date"><i class="fa fa-times"></i></a>');

    $('body').on('click', '.clear-date', function (e) {
        e.preventDefault();

        $(this).parents('.form-group').find('.datepicker').datepicker('setDate', null);
        $(this).parents('.form-group').find('.ymd-date-input').val('');

    });


    if (datePicker.length > 0) {

        datePicker.datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            changeYear: true,
            changeMonth: true,
            calendarWeeks: true,
            showButtonPanel: true,
            autoclose: true
        });

        $.datepicker._gotoToday = function (id) {
            $(id).datepicker('setDate', new Date()).datepicker('hide').blur();
            datePicker.trigger('change');
        };

        //updates ymd input dates to HTML 5 date inputs
        update_ymd_dates();

        datePicker.on('change', function () {

            if ($(this).val().length) {

                var ymd_date_input = $(this).closest('.form-group').find('.ymd-date-input');

                //converts and gets mysql formatted date
                var ymd_formatted_date = toSqlDate($(this).val());

                ymd_date_input.val(ymd_formatted_date);
            }
        });

    }

    //start on page load
    startIdleInterval();

    var idleTimeInterval = false;

    function startIdleInterval() {

        var idleTime = 0;
        var activityTime = 0;

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
                activityTime = activityTime + 1;

                if (activityTime >= 5) {

                    //get request every five minutes to keep the backend session alive
                    $.get('/');

                    //reset activity time
                    activityTime = 0;
                }

                if (idleTime >= 15) { // 15 minutes

                    initTimer();
                    clearInterval(idleTimeInterval);
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

                if (minutes < 5) {
                    $('#modal-timer-logout').modal('show');
                }

                if (minutes <= 0 && parseInt(seconds) <= 1) {

                    localStorage.setItem('loggedOut', 'true');

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

        clearInterval(idleTimeInterval);
        clearInterval(timerInterval);
        timerInterval = false;
        idleTimeInterval = false;
    }

    $('#btn-rest-timer').on('click', function (e) {
        e.preventDefault();

        //send a dummy request to log the activity
        $.get('/');

        //stop the timer
        resetTimer();

        //start on page load
        startIdleInterval();

        $('#modal-timer-logout').modal('hide');
    });
});


//show the spinner
function showSpiner(clicked_btn, btn_text = 'Processing') {
    clicked_btn.prop('disabled', true);
    clicked_btn.html(btn_text + ' <span class="fa fa-spinner fa-spin" style="position:relative; top:2px; font-family: FontAwesome !important;"></span>');
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

    if (sqlDate.length && sqlDate !== '0000-00-00') {

        var dateParts = sqlDate.split("-");

        var jsDate = new Date(dateParts[0], dateParts[1] - 1, dateParts[2].substr(0, 2));

        //converts to MM/DD/YYYY formats which is acceptable by MYSQL
        return (jsDate.getMonth() + 1).pad(2) + '/' + jsDate.getDate().pad(2) + '/' + jsDate.getFullYear();
    }

    return '';
}

function resetForm(form) {

    //reset HTML form [will not reset project-name field in permit info record time)
    form.find('select,input:text,:input[type="number"]').not('.project-name, .project-id').val('');
    form.find(':checkbox').iCheck('uncheck');
    form.find('select').val('');
    form.find('.ymd-date-input').val('');
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

function validateSingleField(field) {

    $(field).bind('change', function () {

        if (field.val() !== '') {
            field.removeClass('error');
            field.closest('.form-group').find('.error-msg').remove();

            return true;
        }
    });


    if (field.hasClass('error')) {
        return false;
    }

    if (field.val() === '') {
        field.addClass('error');

        if (field.is('select')) {
            field.after('<span class="text-danger error-msg">Please select a value.</span>');
        } else {
            field.after('<span class="text-danger error-msg">Please enter a value.</span>');
        }

        return false;
    }

    return true;
}


