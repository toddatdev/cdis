$(function () {

    $('.clockpicker').clockpicker({});

    $('.datepicker').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true
    });

    var mem = $('#data_1 .input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true
    });

    $('.i-checks').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green',
    });

    // Toolbar extra buttons
    var btnFinish = $('<button></button>').text('Finish')
        .addClass('btn btn-info d-none')
        .attr('id', 'btn-finish')
        .on('click', function () {
            if (!$(this).hasClass('disabled')) {

                var form = $('#form-step-2');

                var btn = $(this);

                showSpiner(btn);

                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: form.serialize(),
                    dataType: "json",
                    success: function (response) {

                        if (!response.error) {

                            notify(response.title, response.message);

                            swal({
                                title: "Email Report",
                                text: "Do you want to email generated report?",
                                type: "warning",
                                showCancelButton: true,
                                confirmButtonColor: "#DD6B55",
                                confirmButtonText: "Yes, Email it!",
                                closeOnConfirm: false

                            }, function (confirm) {

                                if (confirm) {
                                    swal("Done!", "Site Inspection report has been emailed", "success");
                                    $('#smartwizard').smartWizard('reset');
                                } else {
                                    swal("Cancelled", "Report has not been emailed", "error");
                                    $('#smartwizard').smartWizard('reset');
                                }
                            });

                        }
                    },
                    error: function (response) {

                    },
                    complete: function () {
                        hideSpinner(btn, 'Finish');
                        changed = false;
                    }
                });

            }
        });

    // Smart Wizard
    $('#smartwizard').smartWizard({
        selected: 0,
        theme: 'default',
        transitionEffect: 'slide',
        theme: 'arrows',
        keyNavigation: false,
        showStepURLhash: false,
        lang: {  // Language variables
            next: 'Save & Continue',
            previous: 'Back'
        },
        toolbarSettings: {
            toolbarPosition: 'bottom',
            toolbarButtonPosition: 'center',
            toolbarExtraButtons: [btnFinish]
        }
    });


    var changed = false;

    $('input, select, input:radio, checkbox').on('change', function () {
        changed = true;
    });


    $("#smartwizard").on("leaveStep", function (e, anchorObject, stepNumber, stepDirection) {

        //scroll to top
        $("html, body").animate({scrollTop: 0}, "slow");

        var form = $("#form-step-" + stepNumber);
        // stepDirection === 'forward' :- this condition allows to do the form validation
        // only on forward navigation, that makes easy navigation on backwards still do the validation when going next

        if (stepDirection === 'forward' && stepNumber === 1) {
            $('#btn-finish').removeClass('d-none');
        } else {
            $('#btn-finish').addClass('d-none');
        }

        if (stepDirection === 'forward' && form) {
            form.validator('validate');
            var elmErr = form.find('.with-errors').find('ul');

            if (elmErr.hasClass('list-unstyled')) {
                // Form validation failed
                return false;

            } else {

                //if user changes a input then send an AJAX request
                if (!changed) {
                    return 0;
                }

                var btn = $('button.sw-btn-next');

                showSpiner(btn);

                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: form.serialize(),
                    dataType: "json",
                    success: function (response) {

                        console.log(response);

                        hideSpinner(btn);

                        if (!response.error) {

                            notify(response.title, response.message);
                        }
                    },
                    error: function (response) {

                    },
                    complete: function () {
                        hideSpinner(btn);
                        changed = false;
                    }
                });

                return true;
            }
        }
        return true;
    });


    $("#smartwizard").on("showStep", function (e, anchorObject, stepNumber, stepDirection) {
        // Enable finish button only on last step
        if (stepNumber == 3) {
            $('.btn-finish').removeClass('disabled');
        } else {
            $('.btn-finish').addClass('disabled');
        }
    });

    // External Button Events
    $("#reset-btn").on("click", function () {
        // Reset wizard
        $('#smartwizard').smartWizard("reset");
        return true;
    });

    $("#prev-btn").on("click", function () {
        // Navigate previous
        $('#smartwizard').smartWizard("prev");
        return true;
    });

    $("#next-btn").on("click", function () {
        // Navigate next
        $('#smartwizard').smartWizard("next");
        return true;
    });

});
