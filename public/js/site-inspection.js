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

                var input = form.find('[name=email]');

                var is_validated = validateSingleField(input);

                if (!is_validated) {
                    return 0;
                }


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
                                text: "Your site inspection report is ready to email!",
                                type: "warning",
                                showCancelButton: true,
                                confirmButtonColor: "#DD6B55",
                                confirmButtonText: "Yes, Email it!",
                                closeOnConfirm: false

                            }, function (confirm) {

                                var smartWizard = $('#smartwizard');

                                if (confirm) {

                                    var emailBtn = $('button.confirm');

                                    showSpiner(emailBtn, 'Processing');

                                    $.ajax({
                                        url: '/inspections/report/email',
                                        type: 'post',
                                        data: response,
                                        dataType: "json",
                                        success: function (response) {
                                            hideSpinner(emailBtn, 'Yes, Email it!');
                                            swal("Done!", "Site Inspection report has been emailed", "success");
                                        },
                                        error: function (response) {
                                            hideSpinner(emailBtn, 'Yes, Email it!');
                                            swal("Cancelled", "There was an issue while emailing report, Try again!", "error");
                                        },
                                        complete: function () {
                                            hideSpinner(btn, 'Finish');
                                        }
                                    });


                                    resetInspectionForm(smartWizard);
                                    smartWizard.smartWizard('reset');

                                } else {

                                    resetInspectionForm(smartWizard);
                                    smartWizard.smartWizard('reset');
                                    swal("Cancelled", "There was a server issue while emailing!", "error");
                                }
                            });

                        }
                    },
                    error: function (response) {

                    },
                    complete: function () {
                        hideSpinner(btn, 'Finish');
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

                var btn = $('button.sw-btn-next');

                showSpiner(btn);

                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: form.serialize(),
                    dataType: "json",
                    success: function (response) {

                        if (stepNumber === 0) {

                            //update inspection id for updating next time
                            $('.inspection-id').val(response.inspection_id);
                            console.log(response.inspection_id);

                        }

                        hideSpinner(btn);

                        if (!response.error) {

                            notify(response.title, response.message);
                        }
                    },
                    error: function (response) {

                    },
                    complete: function () {
                        hideSpinner(btn);

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
function resetInspectionForm(form) {

    //reset HTML form [will not reset project-name field in permit info record time)
    form.find('select,input:text,:input[type="number"]').not('.project-name, .project-id, .entry-number, .technician').val('');
    form.find(':checkbox').iCheck('uncheck');
    form.find('select').not('.technician').val('');
    form.find('textarea').val('');
    form.find(':radio[value=0]').iCheck('check');

}
