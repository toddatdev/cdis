$(function () {

    $body = $('body');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="token"]').attr('content')
        }
    });


    var btn_record_time = '';

    //edit time record implementation
    $('#btn-edit-time-record').on('click', function (e) {
        e.preventDefault();


        var form = $('#form-project-time-save');
        var id = parseInt($(this).data('id'));
        btn_record_time = $(this);

        //reset form
        resetForm(form);

        if (id > 0) {

            showSpiner(btn_record_time);

            $.ajax({
                url: '/projects/time/' + id,
                type: 'get',
                dataType: "json",
                success: function (response) {

                    if (response) {

                        var inputs = form.find('input,select');

                        inputs.each(function (index, input) {

                            if (input.id.length > 0) {

                                input.value = response[input.id.replace('-', '_')];
                            }

                        });

                        //update ymd dates on the form
                        update_ymd_dates();
                    }
                },
                error: function (response) {

                },
                complete: function () {
                    hideSpinner(btn_record_time, 'Edit Record Time For This Project');
                }
            });
        }

        $('#modal-record-time').modal();
    });


    var btn_co_permittee = '';
    //edit co-permittee form
    $('#btn-edit-permittee').on('click', function (e) {
        e.preventDefault();

        //select co-permittee form
        var form = $('#form-co-permittee-save');

        //reset co-permittee form
        resetForm(form);

        var id = parseInt($(this).data('id'));

        btn_co_permittee = $(this);


        if (id > 0) {

            showSpiner(btn_co_permittee);

            $.ajax({
                url: '/projects/permittee/' + id,
                type: 'get',
                dataType: "json",
                success: function (response) {

                    //get all form inputs
                    var inputs = form.find('input');

                    //iterate over form input
                    inputs.each(function (index, input) {

                        if (input.id.length > 0) {

                            //check if it's a checkbox
                            if (input.id === 'acknowledged') {

                                //if input has value of one in database then check it
                                if (response[input.name] === 1) {

                                    $(input).prop('checked', true);
                                }

                            } else if (response[input.name] !== undefined) {

                                input.value = response[input.name];
                            }
                        }
                    });

                    //updates ymd input dates to HTML 5 date inputs
                    update_ymd_dates();

                },
                error: function (response) {

                },
                complete: function () {

                    hideSpinner(btn_co_permittee, 'Edit Co-Permittee');
                }
            });
        }

        $('#modal-add-co-permittee').modal();
    });

    //co-permittee save implementation
    $('#btn-co-permittee-save').click(function (e) {
        e.preventDefault();

        var btn = $(this);

        var form = btn.parents('form');

        showSpiner(btn);

        $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: form.serialize(),
            dataType: "json",
            success: function (response) {

                if (!response.error) {
                    $('#modal-add-co-permittee').modal('hide');
                    notify(response.title, response.message);
                }
            },
            error: function (response) {

            },
            complete: function () {
                hideSpinner(btn, 'Update');

                btn_co_permittee.data('id', $('.project-id').val());
                hideSpinner(btn_co_permittee, 'Edit Co-Permittee');
            }
        });
    });

    // Record time forms save implementation
    $('#btn-project-time-save').click(function (e) {
        e.preventDefault();

        var btn = $(this);

        var form = btn.parents('form');

        showSpiner(btn);

        $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: form.serialize(),
            dataType: "json",
            success: function (response) {

                if (!response.error) {
                    $('#modal-record-time').modal('hide');
                    notify(response.title, response.message);
                }
            },
            error: function (response) {

            },
            complete: function () {
                hideSpinner(btn, 'Update');

                btn_record_time.data('id', $('.project-id').val());
                hideSpinner(btn_record_time, 'Edit Record Time For This Project');
            }
        });
    });

    $('#btn-activate-plan').click(function (e) {
        e.preventDefault();

        var btn = $(this);

        showSpiner(btn);

        $.ajax({
            url: btn.data('url'),
            type: 'get',
            dataType: "json",
            success: function (response) {

                if (!response.error) {
                    $('.plan-alert').remove();
                    var btn = '<a href="#modal-close-plan" data-toggle="modal" class="btn btn-danger my-2"' +
                        ' id="btn-toggle-plan-modal"><strong>CLOSE PLAN</strong></a>';

                    $('#action-buttons').html('').html(btn);

                    notify(response.title, response.message);
                }
            },
            error: function (response) {

            },
            complete: function () {
                hideSpinner(btn, 'ACTIVATE PLAN');
            }
        });
    });

    $('body').on('click', '#btn-close-plan', function (e) {
        e.preventDefault();

        var btn = $(this);

        var form = btn.parents('form');

        showSpiner(btn);

        $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: form.serialize(),
            dataType: "json",
            success: function (response) {

                if (!response.error) {
                    $('#modal-close-plan').modal('hide');
                    notify(response.title, response.message);
                    $('#btn-toggle-plan-modal').addClass('disabled');
                }
            },
            error: function (response) {

            },
            complete: function () {
                hideSpinner(btn, 'Close Plan');
            }
        });
    });

    $body.on('click', '#btn-clone-files-row', function (e) {
        e.preventDefault();

        $tbody = $(this).closest('table').find('tbody');

        $tr = $tbody.find('tr').first().clone();

        clearTrInputs($tr);

        $tr.find('.file-upload-wrapper').show()
            .closest('td').find('.btn-file-download').remove();

        var today = new Date();

        var todayDate = today.getDate() + '/' + (today.getMonth() + 1).pad(2) + '/' + today.getFullYear();

        $tr.find('.date').val(todayDate);
        $tr.find('.memo').attr('readonly', false);
        $tr.find('.btn-delete').addClass('disabled');

        $tbody.append($tr);
    });


    $('#project-name').on('keyup', function () {

        if ($(this).val().length !== 0) {

            $('#project-breadcrumb-name').text($(this).val());
            $('.project-name, #form-project-time-save .project-name').val($(this).val());

        } else {

            $('#project-breadcrumb-name').text('Create Project');
        }

    });


    $body.on('click', '.btn-delete', function (e) {
        e.preventDefault();

        var btn = $(this);

        var count = $('#table-files tbody tr').length;

        swal({
            title: "Are you sure?",
            text: "Selected row files will be deleted",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false

        }, function () {

            var project_id = btn.parents('#step-9').find('.project-id').val();
            var project_file_id = btn.data('id');

            var url = `/projects/${project_id}/file/${project_file_id}/destroy`;

            //send ajax delete request
            $.get(url);

            if (count > 1) {

                btn.parents('tr').remove();
                swal("Deleted!", "Your files has been deleted.", "success");

            } else {

                clearTrInputs(btn.parents('tr'));
                swal("Deleted!", "Your files has been deleted.", "success");

                btn.parents('tr').find('.file-upload-wrapper').show()
                    .closest('td').find('.btn-file-download').remove();
                btn.addClass('disabled');
                btn.parents('tr').find('.memo').attr('readonly', false);
            }
        });
    });

    $body.on("change", ".file-upload-field", function () {
        $(this).parent(".file-upload-wrapper").attr("data-text", $(this).val().replace(/.*(\/|\\)/, ''));
    });


    $(".us-phone").inputmask({"mask": "(999) 999-9999"});


    //convert negative values to positive on paste
    $(".long-lat-input").on('paste', function (e) {

        e.preventDefault();

        var content = '';

        if (isIE()) {
            //IE allows to get the clipboard data of the window object.
            content = window.clipboardData.getData('text');
        } else {
            //This works for Chrome and Firefox.
            content = e.originalEvent.clipboardData.getData('text/plain');
        }

        content = Math.abs(content);

        $(this).val(content);
    });

    /**
     *  Jquery Validation for Project Details Form
     */
    $(".long-lat-input").on('keydown', function (event) {

        if (event.shiftKey == true) {
            event.preventDefault();
        }

        if ((event.keyCode >= 48 && event.keyCode <= 57) ||
            (event.keyCode >= 96 && event.keyCode <= 105) ||
            event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 ||
            event.keyCode == 39 || event.keyCode == 46 ||
            event.keyCode == 190 || event.keyCode == 110) {

        } else {
            event.preventDefault();
        }

        if ($(this).val().indexOf('.') !== -1 && event.keyCode == 190 || $(this).val().indexOf('.') !== -1 && event.keyCode == 110)
            event.preventDefault();

    });

    /**
     * US Phone Number Formatter
     */

    $('.phone-number-formatter').on('keyup', function () {

        $(this).val(function (i, text) {
            text = text.replace(/(\d{3})(\d{3})(\d{4})/, "($1) $2-$3");
            return text;
        });
    });


    $('.date-range-picker').daterangepicker({
        opens: 'left'
    }, function (start, end, label) {
        console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
    });

    $('.datepicker').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true
    });

    $('.summernote').summernote({
        height: 160
    });

    $('.i-checks').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green',
    });

    // Toolbar extra buttons
    var btnFinish = $('<button></button>').text('Finish')
        .addClass('btn btn-info')
        .on('click', function () {
                if (!$(this).hasClass('disabled')) {

                    //make all the tabs clickable on btn finish click
                    $('#smartwizard .step-anchor li.nav-item').addClass('done');

                    var step = parseInt($('#smartwizard').find('li.nav-item.active .nav-link').attr('href').substring(7, 6));

                    step = step - 1;

                    var form = $('#form-step-' + step);

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

                                $("#modal-finish-wizard").modal();


                                //if user clicks finish on first step then add IDS
                                //otherwise they will be added by save & continue
                                if (step === 0) {

                                    $('.project-id').val(response.project_id);

                                    $('.btn-breadcrumb').removeClass('disabled');

                                    //append id to generate letter Url after new project creation
                                    updateUrl($('#btn-generate-letter'), response);
                                    updateUrl($('#btn-site-inspection'), response);
                                }
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
            }
        );

    // Smart Wizard
    $('#smartwizard').smartWizard({
        selected: 0,
        theme: 'default',
        transitionEffect: 'slide',
        theme: 'arrows',
        showStepURLhash: false,
        lang: {  // Language variables
            next: 'Save & Continue',
            previous: 'Back'
        },
        toolbarSettings: {
            toolbarPosition: 'bottom',
            toolbarButtonPosition: 'center',
            toolbarExtraButtons: [btnFinish]
        },
        // anchorSettings: {
        //     anchorClickable: true, // Enable/Disable anchor navigation
        //     enableAllAnchors: true, // Activates all anchors clickable all times
        //     markDoneStep: true, // add done css
        //     enableAnchorOnDoneStep: true // Enable/Disable the done steps navigation
        // },
    });

    var changed = false;

    $body.on('change', 'input, select', function () {
        changed = true;
    });

    $('#smartwizard').on('showStep', function (e, anchorObject, stepNumber, stepDirection) {

        var form = $("#form-step-" + stepNumber);

        //load all fees for current edited project if fees info tab clicked
        if (stepNumber === 6) {

            //get the project id
            var project_id = form.find('.project-id').val();
            var url = '/projects/fees/' + project_id;

            //load table body with database data
            $('#fees-table-body').load(url)
        }

        //load all reviews for current edited project if reviews tab clicked
        if (stepNumber === 7) {

            //get the project id
            var project_id = form.find('.project-id').val();
            var url = '/projects/reviews/' + project_id;

            //load table body with database data
            $('#reviews-table-body').load(url)
        }

    });

    $("#smartwizard").on("leaveStep", function (e, anchorObject, stepNumber, stepDirection) {

        var form = $("#form-step-" + stepNumber);
        // stepDirection === 'forward' :- this condition allows to do the form validation
        // only on forward navigation, that makes easy navigation on backwards still do the validation when going next

        //if it's reviews or fees tab then don't do anything because
        //it's handled by Internal AJAX Insertion
        if (stepNumber === 6 || stepNumber === 7) {
            return;
        }


        if (stepDirection === 'forward' && form) {
            form.validator('validate');

            var elmErr = form.find('.with-errors').find('ul');

            if (elmErr.hasClass('list-unstyled')) {
                // Form validation failed
                return false;

            } else {

                //Don't send ajax request unless user has changed something
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

                        hideSpinner(btn);

                        if (!response.error) {

                            notify(response.title, response.message);

                        }


                        if (stepNumber === 0) {

                            //update project id for updating next time
                            //update project id for updating next time
                            $('.project-id').val(response.project_id);

                            //fill in the record time for this project modal project name


                            $('.btn-breadcrumb').removeClass('disabled');

                            //remove plan type and make project name input full width
                            $('#plan-type-box').remove();
                            $('#project-name-box').removeClass('col-md-6').addClass('col-md-12');


                            //populate NPDES number in permit info tab
                            $('#npdes-number-input').val(response.npdes_number);


                            //append id to generate letter Url after new project creation
                            updateUrl($('#btn-generate-letter'), response);
                            updateUrl($('#btn-site-inspection'), response);
                        }

                        if (stepNumber === 7) {
                            alert('step 7 !');
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

        $("html, body").animate({scrollTop: 0}, "slow").stop();

        // Enable finish button only on last step
        if (stepNumber == 3) {
            $('.btn-finish').removeClass('disabled');
        } else {
            $('.btn-finish').addClass('disabled');
        }
    });


    /*    $("#prev-btn").on("click", function () {
            // Navigate previous
            $('#smartwizard').smartWizard("prev");
            return true;
        });

        $("#next-btn").on("click", function () {
            // Navigate next
            $('#smartwizard').smartWizard("next");
            return true;
        });*/


    /**
     * Clone Co-Applicant section
     */

    $('.btn-add-co-applicant').on('click', function (evt) {
        evt.preventDefault();

        var ibox = $('#form-step-3 .ibox').first().clone();

        var projectId = $('.project-id').val();

        //count total applicants and add 1 to it which will be the id for next applicant.
        var applicantId = $('.applicant-box').length + 1;

        //generate url for applicant deletion
        var url = (projectId.length > 0) ? '/projects/' + projectId + '/applicant/' + applicantId + '/destroy' : '';

        ibox.find(".us-phone").inputmask({"mask": "(999) 999-9999"});

        ibox.find('.form-control').val('');
        ibox.find('select').prop('selectedIndex', 0);

        ibox.find('.btn')
            .removeClass('btn-success')
            .addClass('btn-danger btn-remove-co-applicant')
            .text('Remove Co-Applicant')
            .data('url', url);

        $('#form-step-3').append(ibox);

    });

    $('body').on('click', '.btn-remove-co-applicant', function (evt) {
        evt.preventDefault();

        var btn = $(this);
        var url = btn.data('url');

        showSpiner(btn);

        //if there URL is empty simple remove the box otherwise remove it from database
        if (url !== undefined && url.length > 0) {

            $.ajax({
                url: btn.data('url'),
                type: 'get',
                success: function (response) {

                    if (!response.error) {

                        notify(response.title, response.message);

                        btn.closest('.ibox').remove();
                    }
                },
                complete: function () {

                    hideSpinner(btn, 'Remove Co-Applicant');
                }
            });

        } else {

            btn.closest('.ibox').remove();
        }
    });


    /**
     * Clone Naics Field
     */
    $('#btn-add-naics').on('click', function (evt) {
        evt.preventDefault();

        var item = $('.naics-item').first().clone();

        item.find('input.form-control').val('');

        $('.naics-group').append(item);

    });


    $("#generate-map").on("click", function (e) {
        e.preventDefault();

        latdeg = Number($("#lat_degrees").val());
        lngdeg = Number($("#lng_degrees").val());

        if (isNaN(latdeg) || isNaN(lngdeg)) {
            return false;
        }
        latmin = Number($("#lat_minutes").val());
        lngmin = Number($("#lng_minutes").val());

        if (isNaN(latmin) || isNaN(lngmin)) {
            return false;
        }

        latsec = Number($("#lat_seconds").val());
        lngsec = Number($("#lng_seconds").val());

        if (isNaN(latsec) || isNaN(lngsec)) {
            return false;
        }
        var coordinates = {};
        coordinates.latdeg = latdeg;
        coordinates.latmin = latmin;
        coordinates.latsec = latsec;
        coordinates.lngdeg = lngdeg;
        coordinates.lngmin = lngmin;
        coordinates.lngsec = lngsec;
        coordinates._token = $('[name=_token]').val();
        $.post("/coordinates", coordinates, function (data) {
            iframe = "<iframe width='1078' height='400' frameborder='0'";
            iframe += " src='https://www.google.com/maps/embed/v1/view?key=";
            iframe += "AIzaSyAvDaFE_p98XQixjEqfFrbuimsT0oDR5es";
            iframe += "&center=" + data.latitude + "," + data.longitude + "' ";
            iframe += "allowfullscreen></iframe>";
            $("#map").html(iframe).show();
        });
    });


    /************************************
     * FEES Tab
     * ***********************************/
    //new and update fee entry implementation
    $('.btn-add-fee-entry').on('click', function (e) {
        e.preventDefault();

        var btn = $(this);
        var form = btn.closest('#form-step-6');
        var formMode = form.data('mode');
        var url = form.attr('action');

        //check if user is updating form
        if (formMode === 'edit') {

            var project_id = form.find('.project-id').val();
            var fee_id = btn.data('fee_id');

            url = '/projects/' + project_id + '/fees/' + fee_id + '/update';
        }

        showSpiner(btn);

        $.ajax({
            url: url,
            type: 'post',
            cache: false,
            data: form.serialize(),
            dataType: "json",
            success: function (response) {

                if (!response.error) {

                    notify(response.title, response.message);

                    //reset current form
                    resetForm(form);

                    //get the project id
                    var project_id = form.find('.project-id').val();
                    var url = '/projects/fees/' + project_id;


                    //load table body with database data
                    $('#fees-table-body').load(url)
                }
            },
            complete: function () {

                //update form mode to create
                form.data('mode', 'create');

                hideSpinner(btn, 'Add Fee Entry');
            }
        });
    });


    //Edit fee implementation
    $body.on('click', '.btn-edit-fee', function (e) {
        e.preventDefault();

        //clicked btn
        var btn = $(this);

        //get the form and all it's inputs
        var form = btn.parents('.ibox').find('form');
        var inputs = form.find('input,select');


        //change btn text from (new fee entry) to (update fee entry)
        var btn_fee_entry = form.find('.btn-add-fee-entry');
        btn_fee_entry.text('Update Fee Entry');

        //set data-fee-id to fee id for later update
        btn_fee_entry.data('fee_id', btn.data('id'));


        //set form mode to  edit
        form.data('mode', 'edit');


        //reset form before editing a row
        resetForm(form);

        //reviews table row (tr)
        var tr = btn.parents('tr');

        inputs.each(function (index, input) {

            //check if input exists
            if (input.id.length > 0) {

                //check if user is an admin
                if (input.id === 'is-admin') {

                    //get is admin data value from review table row
                    var is_admin = tr.find('.' + input.id).data('admin');

                    //check if reviewer is admin
                    if (is_admin) {
                        $(input).prop('checked', true);
                    }

                } else if (input.name === 'submission_type') {

                    //get the radio value from table row
                    var radioValue = tr.find('.' + input.name.replace('_', '-')).text();

                    //select the specific radio based on it's value
                    if ($(input).is('[name=submission_type][value="' + radioValue + '"]')) {

                        //check the specific radio box
                        $(input).iCheck('check');
                    }

                } else {

                    input.value = tr.find('.' + input.id.replace('_', '-')).text();
                }
            }
        });
    });


    //Delete fee implementation
    $body.on('click', '.btn-delete-fee', function (e) {
        e.preventDefault();

        //clicked btn
        var btn = $(this);

        swal({
            title: "Are you sure?",
            text: "selected fee will be deleted!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false

        }, function () {

            var project_id = btn.parents('#step-7').find('.project-id').val();
            var fee_id = btn.data('id');

            var url = `/projects/${project_id}/fees/${fee_id}/destroy`;

            //send ajax delete request
            $.get(url);

            btn.parents('tr').remove();
            swal("Deleted!", "Your fee has been deleted.", "success");
        });
    });


    /************************************
     * Reviews Tab
     * ***********************************/

    //new and update review entry implementation
    $('.btn-add-review-entry').on('click', function (e) {
        e.preventDefault();

        var btn = $(this);
        var form = btn.closest('#form-step-7');
        var formMode = form.data('mode');
        var url = form.attr('action');

        //check if user is updating form
        if (formMode === 'edit') {

            var project_id = form.find('.project-id').val();
            var review_id = btn.data('review_id');

            url = '/projects/' + project_id + '/reviews/' + review_id + '/update';
        }

        showSpiner(btn);

        $.ajax({
            url: url,
            type: 'post',
            cache: false,
            data: form.serialize(),
            dataType: "json",
            success: function (response) {

                if (!response.error) {

                    notify(response.title, response.message);

                    //reset current form
                    resetForm(form);

                    //get the project id
                    var project_id = form.find('.project-id').val();
                    var url = '/projects/reviews/' + project_id;


                    //load table body with database data
                    $('#reviews-table-body').load(url)
                }
            },
            complete: function () {

                //update form mode to create
                form.data('mode', 'create');

                hideSpinner(btn, 'Add Review Entry');
            }
        });
    });

    //Edit review implementation
    $body.on('click', '.btn-edit-review', function (e) {
        e.preventDefault();

        //clicked btn
        var btn = $(this);

        //get the form and all it's inputs
        var form = btn.parents('.ibox').find('form');
        var inputs = form.find('input,select');


        //change btn text from (new review entry) to (update review entry)
        var btn_review_entry = form.find('.btn-add-review-entry');
        btn_review_entry.text('Update Review Entry');

        //set data-review-id to review id for later update
        btn_review_entry.data('review_id', btn.data('id'));


        //set form mode to  edit
        form.data('mode', 'edit');


        //reset form before editing a row
        resetForm(form);

        //reviews table row (tr)
        var tr = btn.parents('tr');

        inputs.each(function (index, input) {

            //check if input exists
            if (input.id.length > 0) {

                //check if user is an admin
                if (input.id === 'is-admin') {

                    //get is admin data value from review table row
                    var is_admin = tr.find('.' + input.id.replace('_', '-')).data('admin');

                    //check if reviewer is admin
                    if (is_admin) {

                        $(input).prop('checked', true);
                    }

                } else {

                    input.value = tr.find('.' + input.id.replace('_', '-')).text();
                }
            }
        });
    });

    //Delete review implementation
    $body.on('click', '.btn-delete-review', function (e) {
        e.preventDefault();

        //clicked btn
        var btn = $(this);

        swal({
            title: "Are you sure?",
            text: "selected review will be deleted!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false

        }, function () {

            var project_id = btn.parents('#step-8').find('.project-id').val();
            var review_id = btn.data('id');

            var url = `/projects/${project_id}/reviews/${review_id}/destroy`;

            //send ajax delete request
            $.get(url);

            btn.parents('tr').remove();
            swal("Deleted!", "Your review has been deleted.", "success");
        });
    });

    /********************
     * Project File upload
     ********************/

    $body.on('click', '.btn-upload', function (e) {
        e.preventDefault();

        var btn = $(this);
        var tr = btn.closest('tr');
        var fileInput = tr.find('.file');
        var project_id = btn.parents('#step-9').find('.project-id').val();

        var formData = new FormData();

        formData.append('_token', fileInput.data('token'));
        formData.append('file', fileInput.prop('files')[0]);
        formData.append('project_id', project_id);
        formData.append('memo', tr.find('.memo').val());

        showSpiner(btn);

        $.ajax({
            url: fileInput.data('url'),
            type: 'post',
            processData: false, // important
            contentType: false, // important
            cache: false,
            data: formData,
            dataType: "json",
            success: function (response) {

                if (!response.error) {

                    notify(response.title, response.message);

                    tr.find('.file-upload-wrapper').hide()
                        .closest('td')
                        .append('<a href="' + response.path + '" target="_blank" class="btn-file-download" >' + response.key + '</a>');

                    //disable memo input
                    tr.find('.memo').attr('readonly', true);
                    tr.find('.btn-delete').removeClass('disabled').data('id', response.project_file_id);
                }
            },
            error: function (response) {

            },
            complete: function () {
                hideSpinner(btn, 'Upload!');
                btn.addClass('disabled').removeClass('btn-primary').addClass('btn-secondary');
                // changed = false;
            }
        });

    });


    $body.on('change', '.file-upload-field', function () {

        $(this).closest('tr')
            .find('.btn-upload')
            .removeClass('disabled')
            .removeClass('btn-secondary')
            .addClass('btn-primary');
    })


})
;

function isIE() {
    var ua = window.navigator.userAgent;

    return ua.indexOf('MSIE ') > 0 || ua.indexOf('Trident/') > 0 || ua.indexOf('Edge/') > 0
}

function clearTrInputs(row) {
    row.find('input.memo').val('');
    row.find('input.date').val('');
    row.find('.file-upload-wrapper').attr('data-text', 'Select your file!');
    row.find('input.file').val('');
}

function updateUrl(btn, response) {

    var url = btn.attr('href');

    //check if url don't have project id? append id to it
    if (!url.includes(response.project_id)) {

        url += '/' + response.project_id;

    }

    btn.attr('href', url);
}
