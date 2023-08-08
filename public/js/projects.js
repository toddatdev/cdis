$(function () {

    $body = $('body');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="token"]').attr('content')
        }
    });


    $('#modal-add-co-permittee').on('hidden.bs.modal', function (e) {

        $('#modal-add-co-permittee').find('.dirty').removeClass('dirty');

    });

    $('#modal-search-contact').on('shown.bs.modal', function (e) {

        $(this).find('input').focus();

    });

    $('#modal-close-plan').on('shown.bs.modal', function (e) {

        $(this).find('input[name=box_number]').focus();

    });

    $('#modal-record-time').on('hidden.bs.modal', function (e) {

        $('#modal-record-time').find('.dirty').removeClass('dirty');

    });

    $('#modal-edit-record-time').on('hidden.bs.modal', function (e) {

        $('#modal-edit-record-time').find('.dirty').removeClass('dirty');

    });


    //add time record implementation
    $('#btn-view-time-record').on('click', function (e) {
        e.preventDefault();

        var timeId = $(this).data('id');

        var btn = $(this);

        showSpiner(btn, 'Fetching...');

        if (timeId === '' || isNaN(timeId)) {

            console.log(timeId);

            $('#modal-view-time-record .modal-body').html('<h3 class="text-center">No time recorded for this project.</h3>');

            $('#modal-view-time-record').modal('show');

            hideSpinner(btn, 'View All Time For This Project');

            return;
        }

        var url = getBaseUrl() + '/projects/time/' + timeId;


        $.get(url, function (response) {

            hideSpinner(btn, 'View All Time For This Project');

            if ($(response).find('table').length > 1) {
                $('#btn-export-excel').removeClass('disabled');
                $('#btn-export-pdf').removeClass('disabled');
            }

            $('#modal-view-time-record .modal-body').html(response);

            $('#modal-view-time-record').modal('show');
        });

    });


    $('#btn-add-time-record').on('click', function (e) {
        e.preventDefault();

        $('#modal-record-time').modal('show');

    });


    var btnEditTime = '';
    $body.on('click', '.btn-edit-time', function (e) {
        e.preventDefault();

        btnEditTime = $(this);

        var form = $('#form-edit-record-time');
        var id = parseInt($(this).data('id'));

        //reset form
        resetForm(form);

        if (id > 0) {

            $.ajax({
                url: '/projects/time/single/' + id,
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

                }
            });
        }


        $('#modal-edit-record-time').modal();

    });


    $body.on('click', '#btn-time-update', function (e) {
        e.preventDefault();

        var btn = $(this);

        var submit_type_cb = $(this).parents('form').find('#submit-type');

        var is_submit_type_validated = validateSingleField(submit_type_cb);

        if (!is_submit_type_validated) {
            return 0;
        }


        var timeId = btnEditTime.data('id');
        var projectId = parseInt($('#form-step-0').find('.project-id').val());

        var form = $('#form-edit-record-time');

        var url = getBaseUrl() + '/projects/time/' + timeId + '/update';

        showSpiner(btn);

        $.ajax({
            url: url,
            type: 'post',
            data: form.serialize(),
            dataType: "json",
            success: function (response) {

                var url = getBaseUrl() + '/projects/time/' + projectId;

                $.get(url, function (response) {

                    $('#modal-view-time-record .modal-body').html(response);

                });

            },
            error: function (response) {

            }, complete: function () {
                hideSpinner(btn, 'Update');
                $('#modal-edit-record-time').modal('hide');
            }
        });
    });


//Delete fee implementation
    $body.on('click', '.btn-delete-time', function (e) {
        e.preventDefault();

        //clicked btn
        var btn = $(this);

        swal({
            title: "Are you sure?",
            text: "selected recorded row will be deleted!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false

        }, function () {

            var project_id = $('#form-step-0').find('.project-id').val();
            var time_id = btn.data('id');

            var url = `/projects/${project_id}/time/${time_id}/destroy`;

            //send ajax delete request
            $.get(url, function (response) {

                btn.parents('tr').remove();

                if ($body.find('#table-new-time-record > tbody > tr').length === 1 &&
                    $body.find('#table-resubmit-time-record > tbody > tr').length === 1) {

                    $('#btn-export-excel').addClass('disabled');
                    $('#btn-export-pdf').addClass('disabled');
                    $('#modal-view-time-record .modal-body').html('<h3 class="text-center">No time recorded for this project.</h3>')

                }

                //updates the total and grad total hrs
                updateTotalRecordedHrs();

                swal("Deleted!", "Row has been deleted.", "success");
            });
        });
    });


//Add co-permittee form
    $('#btn-add-permittee').on('click', function (e) {
        e.preventDefault();


        //select co-permittee form
        var form = $('#form-co-permittee-save');

        //reset co-permittee form
        resetForm(form);

        $('#modal-add-co-permittee').modal();
    });


//edit co-permittee form
    $('#btn-see-permittee').on('click', function (e) {
        e.preventDefault();

        var btn_see_permittee = $(this);
        var id = parseInt($(this).data('id'));

        if (id > 0 && !isNaN(id)) {

            showSpiner(btn_see_permittee);

            $.ajax({
                url: '/projects/permittee/' + id,
                type: 'get',
                success: function (response) {

                    if (response.length === 0) {

                        $('#modal-edit-co-permittee .modal-body').html('<h3 class="text-center" id="permittee-error">Co-Permittee not found!</h3>');
                    }

                    var tabContainer = $('body').find('.tabs-container');

                    if (tabContainer.length > 0) {

                        tabContainer.replaceWith(response);
                    }

                    if (response.length > 0) {
                        $('#modal-edit-co-permittee-body').replaceWith(response);
                        $('body').find('#permittee-error').replaceWith(response);
                    }


                    var permitteeEditModal = $('#modal-edit-co-permittee');

                    permitteeEditModal.find('.us-phone').inputmask({"mask": "(999) 999-9999"});

                    if (permitteeEditModal.find(".datepicker").length > 0) {
                        permitteeEditModal.find(".datepicker").datepicker({}).position({
                            my: "left top",
                            at: "left bottom",
                            of: permitteeEditModal.find(".datepicker"),
                        }).hide();

                        permitteeEditModal.find(".datepicker").show();

                        permitteeEditModal.find('.datepicker').on('change', function () {

                            if ($(this).val().length) {

                                var ymd_date_input = $(this).closest('.form-group').find('.ymd-date-input');

                                //converts and gets mysql formatted date
                                var ymd_formatted_date = toSqlDate($(this).val());

                                ymd_date_input.val(ymd_formatted_date);
                            }
                        });
                    }

                    permitteeEditModal.modal();

                    //updates ymd input dates to HTML 5 date inputs
                    update_ymd_dates();
                },
                error: function (response) {
                },
                complete: function () {

                    hideSpinner(btn_see_permittee, 'See Co-Permittee');
                }
            });

        } else {
            $('#modal-edit-co-permittee .modal-body').html('<h3 class="text-center" id="permittee-error">Co-Permittee not found!</h3>');
            $('#modal-edit-co-permittee').modal();
        }
    });


//co-permittee save implementation
    $('body').on('click', '.btn-co-permittee-update', function (e) {
        e.preventDefault();

        var form = $(this).parents('form');
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
                }
            },
            error: function (response) {

            },
            complete: function () {

                hideSpinner(btn, 'Update');
                // btn_see_permittee.data('id', $('.project-id').val());

            }
        });


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

                    $('#btn-see-permittee').data('id', $('#form-step-0').find('.project-id').val());
                    notify(response.title, response.message);
                }
            },
            error: function (response) {

            },
            complete: function () {


                hideSpinner(btn, 'Save');

            }
        });
    });


// Record time forms save implementation
    $('#btn-project-time-save').click(function (e) {
        e.preventDefault();

        var submit_type_cb = $(this).parents('form').find('#submit-type');

        var is_submit_type_validated = validateSingleField(submit_type_cb);

        if (!is_submit_type_validated) {
            return 0;
        }

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

                    var projectId = parseInt($('#form-step-0').find('.project-id').val());

                    $('#btn-view-time-record').data('id', projectId);

                    var ExcelExportUrl = '/reports/' + projectId + '/time/xls/download';
                    var pdfExportUrl = '/reports/' + projectId + '/time/pdf/download';

                    $('#btn-export-excel').attr('href', ExcelExportUrl);
                    $('#btn-export-pdf').attr('href', pdfExportUrl);


                    notify(response.title, response.message);
                }
            },
            error: function (response) {

            },
            complete: function () {
                hideSpinner(btn, 'Save');
                resetForm(form);
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
                    $('#modal-close-plan').find('.dirty').removeClass('dirty');
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

        var todayDate = (today.getMonth() + 1).pad(2) + '/' + today.getDate() + '/' + today.getFullYear();


        $tr.find('.date').val(todayDate);
        $tr.find('.memo').attr('readonly', false);
        $tr.find('.btn-delete').removeClass('disabled').addClass('empty');

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

        //if file has not been uploaded through row.
        if (btn.hasClass('empty')) {

            //if row count greater than one then  remove the entire row
            if (count > 1) {
                btn.parents('tr').remove();
            }

            return 0;
        }


        swal({
            title: "Are you sure?",
            text: "Selected row files will be deleted",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false

        }, function () {

            if (confirm) {

                var confirmDeleteBtn = $('button.confirm');

                showSpiner(confirmDeleteBtn, 'Processing');


                var project_id = btn.parents('#step-9').find(".project-id").val();
                var project_file_id = btn.data('id');


                var url = `/projects/${project_id}/file/${project_file_id}/destroy`;


                //send ajax delete request
                $.get(url).done(function () {

                    //if row count greater than one then  remove the entire row
                    if (count > 1) {
                        btn.parents('tr').remove();
                    }

                    //if row count is last only row then don't remove it
                    if (count <= 1) {

                        clearTrInputs(btn.parents('tr'));
                        btn.parents('tr').find('.file-upload-wrapper').show()
                            .closest('td').find('.btn-file-download').remove();
                        btn.addClass('disabled');
                        btn.parents('tr').find('.memo').attr('readonly', false);
                    }

                    swal("Deleted!", "Selected file has been deleted.", "success");
                    hideSpinner(confirmDeleteBtn, 'Close');
                });
            }
        });
    });

    $body.on("change", ".file-upload-field", function () {
        $(this).parent(".file-upload-wrapper").attr("data-text", $(this).val().replace(/.*(\/|\\)/, ''));
    });


    $(".us-phone").inputmask({"mask": "(999) 999-9999"});


//convert negative values to positive on paste
    /*    $(".long-lat-input").on('paste', function (e) {

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
        });*/

    function ConvertDMSToDD(degrees, minutes, seconds, direction) {
        var dd = degrees + (minutes/60) + (seconds/3600);
        console.log(dd);
        if (direction == "S" || direction == "W") {
            dd = dd * -1;
        } // Don't do anything for N or E
        return dd;
    }

    /************************************
     * Locations Tab
     * ***********************************/
    $('body').on('keyup', '.lat-long', function(e){

        if($(this).hasClass('latitude')){

            var DMS = toDegreesMinutesAndSeconds($(this).val());

            $('#lat_degrees').val(DMS.degree);
            $('#lat_minutes').val(DMS.minutes);
            $('#lat_seconds').val(DMS.seconds);
        }

        if($(this).hasClass('longitude')){

            var DMS = toDegreesMinutesAndSeconds($(this).val());

            $('#lng_degrees').val(DMS.degree);
            $('#lng_minutes').val(DMS.minutes);
            $('#lng_seconds').val(DMS.seconds);
        }
    });



    $('body').on('keyup', '.lat-dms', function(e){
        let latDMS = $(this);
        let latDEG = parseFloat($('#lat_degrees').val());
        let latMIN = parseFloat($('#lat_minutes').val());
        let latSEC = parseFloat($('#lat_seconds').val());

        $('input#lat').val(ConvertDMSToDD(isNaN(latDEG) ? 0 : latDEG, isNaN(latMIN) ? 0 : latMIN, isNaN(latSEC) ? 0 : latSEC, ''));
    });


    $('body').on('keyup', '.lng-dms', function(e){

        let lngDMS = $(this);

        let lngDEG = parseFloat($('#lng_degrees').val());
        let lngMIN = parseFloat($('#lng_minutes').val());
        let lngSEC = parseFloat($('#lng_seconds').val());

        $('input#lng').val(ConvertDMSToDD(isNaN(lngDEG) ? 0 : lngDEG, isNaN(lngMIN) ? 0 : lngMIN, isNaN(lngSEC) ? 0 : lngSEC, 'W'));

    });

    $('.lat-dms').first().trigger('keyup');
    $('.lng-dms').first().trigger('keyup');
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
            event.keyCode == 190 || event.keyCode == 110 || event.keyCode == 189 || event.keyCode == 109) {

        } else {
            event.preventDefault();
        }
        /*
                if ($(this).val().indexOf('.') !== -1 && event.keyCode == 190 || $(this).val().indexOf('.') !== -1 && event.keyCode == 110)
                    event.preventDefault();*/
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


    $('#btn-update-project-memo').on('click', function (e) {
        e.preventDefault();

        var form = $('#form-step-8');

        var btn = $(this);

        showSpiner(btn);

        $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: form.serialize(),
            dataType: "json",
            success: function (response) {

                $('#step-9').find('.dirty').removeClass('dirty');

                if (!response.error) {

                    notify(response.title, response.message);
                }
            },
            error: function (response) {

            },
            complete: function () {
                hideSpinner(btn, 'Update Memo');
            }
        });
    });


    //Toolbar extra buttons
    var btnFinish = $('<button></button>').text('Finish')
        .addClass('btn btn-info')
        .attr('id', 'btn-finish')
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

                                    $('#btn-view-time-record').data('id', response.project_id);
                                    $('#btn-see-permittee').data('id', response.project_id);

                                    $('.btn-breadcrumb').removeClass('disabled');

                                    if (response.npdes_number !== '') {

                                        //populate NPDES number in permit info tab
                                        $('#npdes-number-input').val(response.npdes_number);

                                    }


                                    //append id to generate letter Url after new project creation
                                    updateUrl($('#btn-generate-letter'), response);
                                    updateUrl($('#btn-site-inspection'), response);
                                }
                            }

                            $('#btn-finish').addClass('disabled, d-none');
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
        },
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

                            $('.dirty').removeClass('dirty');
                            notify(response.title, response.message);
                        }

                        if (stepNumber === 0) {
                            let prefix = response.plan_type === 'project_application' ? 'A' : '';
                            //update project id for updating next time
                            $('.project-id').val(prefix + response.project_id);

                            $('#create-project-heading').remove();
                            $('.breadcrumb').addClass('mt-5');

                            //fill in the record time for this project modal project name
                            $('.btn-breadcrumb').removeClass('disabled');

                            //remove plan type and make project name input full width
                            $('#plan-type-box').remove();
                            $('#project-name-box').removeClass('col-md-6').addClass('col-md-12');


                            if (response.npdes_number !== '') {

                                //populate NPDES number in permit info tab
                                $('#npdes-number-input').val(response.npdes_number);

                            }

                            //append id to generate letter Url after new project creation
                            updateUrl($('#btn-generate-letter'), response);
                            updateUrl($('#btn-site-inspection'), response);
                        }

                        if (stepNumber === 3) {
                            //add destroy url to co-applicant delete btn
                            $('body #form-step-3').find('.btn-remove-co-applicant').data('url', response.applicant_destroy_url);
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
    });


    /**
     * Clone Co-Applicant section
     */

    $('.btn-add-co-applicant').on('click', function (evt) {
        evt.preventDefault();

        if ($('body').find('.co-applicant-box').length > 0) {
            return 0;
        }

        var ibox = $('#form-step-3 .ibox').first().clone();

        var projectId = $('.project-id').val();

        //count total applicants and add 1 to it which will be the id for next applicant.
        var applicantId = $('.applicant-box').length + 1;

        //generate url for applicant deletion
        var url = (projectId.length > 0) ? '/projects/' + projectId + '/applicant/' + applicantId + '/destroy' : '';

        ibox.find(".us-phone").inputmask({"mask": "(999) 999-9999"});

        ibox.find('.form-control').val('');
        ibox.find('select').prop('selectedIndex', 0);

        ibox.find('.ibox-title h3').text('Co-Applicant Information');

        ibox.find('.btn-search-co-applicant')
            .text('Search Co-Applicant')
            .data('title', 'Search Co-Applicant')
            .data('type', 'coapplicant');

        ibox.find('.btn-add-co-applicant').addClass('co-applicant-box')
            .removeClass('btn-success')
            .addClass('btn-danger btn-remove-co-applicant')
            .text('Remove Co-Applicant')
            .data('url', url);

        $('#form-step-3').append(ibox);

        $('#form-step-3 .ibox').first().find('.btn-add-co-applicant').prop('disabled', true);

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

                        $('#form-step-3 .ibox').first().find('.btn-add-co-applicant').prop('disabled', false);

                        //fix height issues after removal of co-applicant
                        $('#form-new-project-wizard').css({'min-height': 'auto'});
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


        // $.post("/coordinates", coordinates, function (data) {

            var src = 'https://maps.google.com/maps?q=' + $('input#lat').val() + ',' + $('input#lng').val() + '&ie=UTF8&t=&z=8&iwloc=B&output=embed';
            iframe = "<iframe style='width:100%; height:600px;' frameborder='0'";
            iframe += 'src="' + src + '"';
            iframe += "allowfullscreen></iframe>";
            $("#map").html(iframe).show();
        //
        //     console.log(src);
        // });
    });


    /************************************
     * FEES Tab
     * ***********************************/
//new and update fee entry implementation
    $('.btn-add-fee-entry').on('click', function (e) {
        e.preventDefault();

        var fee_type_selectbox = $(this).closest('.ibox-content').find('#fee_type');
        var fee_selectbox = $(this).closest('.ibox-content').find('#fee_amount');

        var is_fee_type_validated = validateSingleField(fee_type_selectbox);
        var is_fee_validated = validateSingleField(fee_selectbox);

        if (!is_fee_validated || !is_fee_type_validated) {
            return 0;
        }


        fee_type_selectbox.attr('disabled', false);

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
                    $.get(url, function (response) {

                        $('#fees-table-body').html(response);

                    });

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


                if (input.id === 'received-date') {

                    input.value = tr.find('.received-date').text();
                    $(input).trigger('change');
                }


                //check if user is an admin
                if (input.id === 'is-admin') {

                    //get is admin data value from review table row
                    var is_admin = tr.find('.' + input.id).data('admin');

                    //check if reviewer is admin
                    if (is_admin) {
                        $(input).prop('checked', true);
                    }

                } else if (input.name === 'nr') {

                    //get the radio value from table row
                    var radioValue = tr.find('.' + input.name.replace('_', '-')).text();

                    //select the specific radio based on it's value
                    if ($(input).is('[name=nr][value="' + radioValue + '"]')) {

                        //check the specific radio box
                        $(input).iCheck('check');
                    }

                } else {

                    if (tr.find('.' + input.id.replace('_', '-')).text().length > 1) {

                        input.value = tr.find('.' + input.id.replace('_', '-')).text();
                        $(input).trigger('change');

                    } else {

                        input.value = '';
                        $(input).trigger('change');
                    }
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

        /*
                var tech_status_selectbox = $(this).closest('.ibox-content').find('#tech-status');

                var is_status_validated = validateSingleField(tech_status_selectbox);

                if (!is_status_validated) {
                    return 0;
                }
        */


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
                    var is_admin = $.trim(tr.find('.' + input.id.replace('_', '-')).data('admin'));

                    console.log(is_admin);

                    //check if reviewer is admin
                    if (parseInt(is_admin) === 1) {

                        $(input).prop('checked', true);
                    }

                } else {

                    input.value = $.trim(tr.find('.' + input.id.replace('_', '-')).text());
                    $(input).trigger('change');
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

                    tr.find('.btn-delete').removeClass('empty').removeClass('disabled').data('id', response.project_file_id);
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


});

function isIE() {
    var ua = window.navigator.userAgent;

    return ua.indexOf('MSIE ') > 0 || ua.indexOf('Trident/') > 0 || ua.indexOf('Edge/') > 0
}

function clearTrInputs(row) {
    row.find('input.memo').val('');
    row.find('input.date').val('');
    row.find('input.creator').val($('#logged-in-user').text());
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

function updateTotalRecordedHrs() {

    var totalResubmitHrs = 0;
    var totalNewHrs = 0;

    var hrsTd = $('body .hrs');

    hrsTd.each(function (index, td) {

        if ($(td).hasClass('resubmit-hrs')) {

            totalResubmitHrs += parseFloat($(td).text());
        }

        if ($(td).hasClass('new-hrs')) {

            totalNewHrs += parseFloat($(td).text());
        }

    });

    $('#total-resubmit-hrs').text(totalResubmitHrs);
    $('#total-new-hrs').text(totalNewHrs);
    $('#total-hrs').text((totalNewHrs + totalResubmitHrs));
}


function toDegreesMinutesAndSeconds(coordinate) {
    var absolute = Math.abs(coordinate);
    var degrees = Math.floor(absolute);
    var minutesNotTruncated = (absolute - degrees) * 60;
    var minutes = Math.floor(minutesNotTruncated);
    var seconds = Math.floor((minutesNotTruncated - minutes) * 60);

    return {'degree': degrees, 'minutes': minutes, 'seconds':  seconds};
}

