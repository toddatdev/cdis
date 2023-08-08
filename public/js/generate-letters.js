$(function () {

    // //triggering change event if checkbox changed in ICheck
    // $('input:checkbox').on('ifChanged', function (event) {
    //     $(event.target).trigger('change');
    // });

    var spinner_template = '<i id="dependent-list-item-spinner" class="fa ' +
        'fa-spinner fa-spin text-center fa-2x mx-auto d-block" style="color: #2f4050; width: 30px; height:30px;"></i>';

    var triggeredByChild = false;
    var parent;

    $('body').on('ifChecked', '.check-all', function (event) {

        parent = $(this).parents('.dependent-list-item');
        parent.find('.cbi').iCheck('check');

        triggeredByChild = false;
    });

    $('body').on('ifChecked', '.cbic', function (e) {
        let parentId = $(this).data('parent-id');
        console.log(parentId);
        $(`#${parentId}`).iCheck('check');
    });

    $('body').on('ifUnchecked', '.cbic', function (e) {
        let parentId = $(this).data('parent-id');
        let countTotal = 0;
        let countChecked = 0;
        $('.cbic').each(function (i) {
            if ($(this).data('parent-id') === parentId) {
                countTotal += 1;
            }
        });

        $('.cbic').filter(':checked').each(function (i) {
            if ($(this).data('parent-id') === parentId) {
                countChecked += 1;
            }
        });

        if (countChecked === 0)
            $(`#${parentId}`).iCheck('uncheck');
    });

    $('body').on('ifUnchecked', '.check-all', function (event) {
        if (!triggeredByChild) {
            parent.find('.cbi').iCheck('uncheck');
        }
        triggeredByChild = false;
    });

    // Removed the checked state from "All" if any checkbox is unchecked
    $('body').on('ifUnchecked', '.cbi', function (event) {
        triggeredByChild = true;

        parent = (parent === undefined) ? $(this).parents('.dependent-list-item') : parent;

        parent.find('.check-all').iCheck('uncheck');
    });

    $('body').on('ifChecked', '.cbi', function (event) {

        parent = (parent === undefined) ? $(this).parents('.dependent-list-item') : parent;


        if (parent.find('.cbi').filter(':checked').length === parent.find('.cbi').length) {

            parent.find('.check-all').iCheck('check');
        }
    });

    // $("body").tooltip({selector: '[data-toggle=tooltip]', animation: false });


    $('[data-toggle="tooltip"]').tooltip({animation: false});

    //clone deficiency input
    $('body').on('click', '#btn-add-deficiency', function (e) {
        e.preventDefault();

        var item = $('.deficiency-item').first().clone();

        item.find('input.form-control').val('');

        $('.deficiency-group').append(item);

    });


    $('body').on('change', '#letter-type', function () {

        var dependent_list = $('#dependent-list');

        $('#btn-generate-letter').attr('disabled', true);

        dependent_list.empty().html(spinner_template);

        $(this).parents('form').find('#memo').val('');

        var letter_type = $(this).val();

        if (letter_type !== 'select_one') {


            var url = '/get-letter-template/' + letter_type;

            $.get(url, function (response) {

                dependent_list.empty().html(response);

                $('#btn-generate-letter').attr('disabled', false);

                $('.i-checks').iCheck({
                    checkboxClass: 'icheckbox_square-green',
                    radioClass: 'iradio_square-green',

                });

                var datePicker = $('body').find('.datepicker');


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
                };
            });

        } else {
            dependent_list.empty();
        }

        $('input:checkbox').iCheck('uncheck');

        var tab_class = $(this).val();

        dependent_list.find('.dependent-list-item').slideUp();
        dependent_list.find('.' + tab_class).slideDown();
    });

    $('#btn-generate-letter').on('click', function (e) {
        e.preventDefault();


        var input = $(this).parents('.ibox').find('[name=reviewer]');

        var is_validated = validateSingleField(input);

        if (!is_validated) {
            return 0;
        }


        if ($('#inadequate-npdes').length > 0) {

            $('input[name="deficiencies[]"]').change(function () {

                if (this.checked) {
                    $('body').find('.error-msg').remove();
                }
            });

            $('body').on('ifChecked', '.check-all', function (event) {
                $('body').find('.error-msg').remove();
            });

            var checkBoxes = $('input[name="deficiencies[]"]:checked');

            if (checkBoxes.length === 0) {

                if ($('body').find('.error-msg').length === 0) {

                    $('body').find('.ibox-content .check-all').after('<span class="text-danger checkbox-error error-msg ">Please check at least one value.</span>');
                }

                return 0;
            }
        }

        var form = $(this).parents('form');
        var btn = $(this);

        showSpiner(btn);

        $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: form.serialize(),
            success: function (response) {

                console.log('success');
                hideSpinner(btn);

                swal({
                    title: "Your letter is ready!",
                    text: "You will be able to download it by clicking the button below.",
                    type: "success",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: 'Download',
                    closeOnConfirm: false

                }, function (isConfirm) {

                    if (isConfirm) {

                        window.open(response, '_blank');
                        swal.close();

                    } else {
                        swal("Cancelled", "Your imaginary file is safe :)", "error");
                    }
                });

            },
            complete: function () {
                hideSpinner(btn, 'Generate Letter');


            }
        });

    });

    $('.datepicker').datepicker({
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


    $('#btn-add-deficiency').on('click', function (evt) {
        evt.preventDefault();

        var item = $('.deficiency-item').first().clone();

        item.find('input.form-control').val('');

        $('.deficiency-group').append(item);

    });

    $('#scrollable').scroll(function () {
        $(".tooltip").tooltip("hide");
    });
})
;
