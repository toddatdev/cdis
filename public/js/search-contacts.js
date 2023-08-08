$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    $('body').on('click', '.btn-mark-old', function (e) {
        e.preventDefault();

        var btn = $(this);

        showSpiner(btn);

        $.ajax({
            url: btn.attr('href'),
            type: 'get',
            dataType: "json",
            success: function (response) {

                if (!response.error) {

                    notify(response.title, response.message);

                    btn.parents('tr').remove();
                }
            },
            error: function (response) {

            },
            complete: function () {
                hideSpinner(btn, 'Mark As Old');
            }
        });
    });

    $('body').on('click', '.btn-create-contact', function (e) {

        e.preventDefault();

        var btn = $(this);
        var modal = null;
        var contactType = null;

        if (btn.attr('type') === 'engineer') {
            modal = $('#modal-edit-engineer');
            modal.find('.btn-update-contact').text('Create');
            modal.find('.modal-title').text('Create Engineer');
            contactType = 'engineer';
        }


        if (btn.attr('type') === 'applicant') {
            modal = $('#modal-edit-applicant');
            modal.find('.btn-update-contact').text('Create');
            modal.find('.modal-title').text('Create Applicant');
            contactType = 'applicant';
        }

        if (btn.attr('type') === 'coapplicant') {
            modal = $('#modal-edit-co-applicant');
            modal.find('.btn-update-contact').text('Create');
            modal.find('.modal-title').text('Create Co-Applicant');
            contactType = 'coapplicant';
        }

        if (btn.attr('type') === 'copermittee') {
            modal = $('#modal-edit-co-perm');
            modal.find('.btn-update-contact').text('Create');
            modal.find('.modal-title').text('Create Co-Permittee');
            contactType = 'copermittee';
        }

        var form = modal.find('form');

        form.find('.us-phone').inputmask({"mask": "(999) 999-9999"});

        resetForm(form);

        modal.find('#TYPE').val(contactType);

        modal.modal('show');

    });

    $('body').on('click', '.btn-edit-contact', function (e) {
        e.preventDefault();

        var btn = $(this);

        var url = btn.attr('href');

        var form = '';

        var modal = '';


        $.get(url, function (response) {

            if (btn.attr('type') === 'engineer') {
                modal = $('#modal-edit-engineer');
                form = modal.find('form');
            }

            if (btn.attr('type') === 'applicant') {

                modal = $('#modal-edit-applicant');
                form = modal.find('form');

            }

            if (btn.attr('type') === 'coapplicant') {
                modal = $('#modal-edit-co-applicant');
                form = modal.find('form');
            }

            if (btn.attr('type') === 'copermittee') {

                modal = $('#modal-edit-co-perm');
                form = modal.find('form');
            }

            form.find('.us-phone').inputmask({"mask": "(999) 999-9999"});

            resetForm(form);

            populateContactForm(form, response);

            modal.modal('show');
        });

    });

    $('#btn-search-contact').on('click', function (e) {
        e.preventDefault();


        var input = $(this).parents('.ibox').find('[name=type]');

        var is_validated = validateSingleField(input);

        if (!is_validated) {
            return 0;
        }

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

                    var htmlTemplate = getHtmlTemplate();

                    if (response.data.length !== 0) {

                        var rows = fillHtmlTemplate(htmlTemplate, response.data);

                        $('#search-results-container').removeClass('d-none');
                        $('#search-table').removeClass('d-none');
                        $('#not-found-message').addClass('d-none');

                        $('#table-search-body').empty().html(rows);

                        $('body').find('[data-toggle="tooltip"]').tooltip();

                        var links = getPaginationLinks(response);

                        $('#pagination').html(links);

                    } else {

                        $('#search-results-container').removeClass('d-none');
                        $('#search-table').addClass('d-none');
                        $('#not-found-message').removeClass('d-none');
                    }


                }
            }, error: function (response) {

            }, complete: function () {
                hideSpinner(btn, '<strong>Search Contact</strong>');
            }
        });

    });


    $('.btn-update-contact').on('click', function (e) {
        e.preventDefault();

        var btn = $(this);

        var form = btn.parents('form');

        showSpiner(btn);

        $.ajax({
            url: form.attr('action'),
            type: 'post',
            data: form.serialize(),
            dataType: "json",
            success: function (response) {
                console.log(response);

                if (!response.error) {

                    notify(response.title, response.message);
                    $('.modal').modal('hide');
                }
            },
            error: function (response) {

            },
            complete: function () {
                hideSpinner(btn, 'Update');
            }
        });
    });


    //get data for second page & check the filters as well
    $('body').on('click', '.pagination a', function (e) {
        e.preventDefault();

        var page = $(this).attr('href').split('page=')[1];

        $('ul.pagination').find('li').removeClass('active');

        $(this).parent('li').addClass('active');

        filter(page);
    });


});

function filter(page = 1) {

    $.ajax({
        url: '/contacts/search?page=' + page,
        type: 'post',
        data: $('#search-form').serialize(),
        dataType: "json",
        success: function (response) {

            var data = response.data;

            var htmlTemplate = getHtmlTemplate();

            console.log(data);

            var rows = fillHtmlTemplate(htmlTemplate, data);

            $('#table-search-body').empty().html(rows);
            $('#pagination').empty().html(getPaginationLinks(response));


        },
        error: function (response) {

        },
        complete: function () {
        }
    });
}

function getHtmlTemplate() {
    return $('<tr>' +
        '<td class="entry-number"></td>' +
        '<td class="company" ></td>' +
        '<td class="text-navy name" ><a href="#" class="text-navy btn-edit-contact"></a></td>' +
        '<td class="address"></td>' +
        '<td class="city" >' +
        '<td class="text-center"><a href="#" class="btn btn-primary btn-xs btn-edit-contact mr-1">Edit</a>' +
        '<a href="#" class="btn btn-danger btn-xs btn-mark-old">Mark As Old</a></td>' +
        '</tr>');
}


function fillHtmlTemplate(htmlTemplate, data) {

    var rows = '';

    $.each(data, function (index, value) {

        //csz => city + state + zip
        var name = '', company = '', csz  = '';

        switch (value.data.TYPE) {

            case 'engineer':

                name = value.data.SENTBY;
                company = value.data.ENGINEER;
                //city + state + zip
                csz = [value.data.ENG_CITY, value.data.ENG_STATE, value.data.ENG_ZIP].filter(Boolean).join(", ");
                break;
            case 'applicant':

                name = value.data.APPLIC;
                company = value.data.APP_COMPANY;
                //city + state + zip
                csz = [value.data.APP_CITY, value.data.APP_STATE, value.data.APP_ZIP].filter(Boolean).join(", ");
                break;
            case 'coapplicant':

                name = value.data.Name;
                company = value.data.Company;
                //city + state + zip
                csz = [value.data.City, value.data.State, value.data.Zip].filter(Boolean).join(", ");
                break;

            case 'copermittee':

                name = value.data.title;
                company = value.data.COMPANY;
                //city + state + zip
                csz = [value.data.CITY, value.data.STATE, value.data.ZIP].filter(Boolean).join(", ");
                csz = [value.data.CITY, value.data.STATE, value.data.ZIP].filter(Boolean).join(", ");
                break;
        }


        htmlTemplate.find('.entry-number').text(value.id.pad(2));
        htmlTemplate.find('.name a').text(name);
        htmlTemplate.find('.company').text(company);
        htmlTemplate.find('.address').text(value.address);
        htmlTemplate.find('.city').text(csz);


        var btn_edit_contact_url = getBaseUrl() + '/contacts/' + value.type + '/' + value.id;
        htmlTemplate.find('.btn-edit-contact').attr('href', btn_edit_contact_url);
        htmlTemplate.find('.btn-edit-contact').attr('type', value.type);

        var mark_old_path = getBaseUrl() + '/contacts/status/update/' + value.id;

        htmlTemplate.find('.btn-mark-old').attr('href', mark_old_path);

        rows += htmlTemplate[0].outerHTML;

    });

    return rows;
}

//add leading zero to single number to 01
Number.prototype.pad = function (size) {
    var s = String(this);
    while (s.length < (size || 2)) {
        s = "0" + s;
    }
    return s;
};

function getPaginationLinks(response) {

    var prev_page_url = '<li class="page-item disabled">' + '<a href="#" class="page-link">&laquo;</a>' + '</li>';
    var next_page_url = '<li class="page-item disabled">' + '<a href="#" class="page-link">&raquo;</a>' + '</li>';

    var links = '';

    for (var i = 1; i <= response.last_page; i++) {

        if (response.current_page === i) {
            links += '<li class="page-item active" aria-current="page"><a href="#" class="page-link">' + i + '</a></li>';
        } else {
            links += '<li class="page-item" aria-current="page" ><a href="' + response.path + '?page=' + i + '" class="page-link">' + i + '</a></li>';
        }
    }

    if (response.prev_page_url !== null) {
        prev_page_url = '<li class="page-item">' + '<a href="' + response.prev_page_url + '" class="page-link">&laquo;</a>' + '</li>';
    }


    if (response.next_page_url !== null) {
        next_page_url = '<li class="page-item">' + '<a href="' + response.next_page_url + '" class="page-link">&raquo;</a>' + '</li>';
    }


    return prev_page_url + links + next_page_url;
}


function getBaseUrl() {
    return window.location.protocol + '//' + window.location.hostname
}


function populateContactForm(form, response) {

    var type = response.data.TYPE;
    var data = response.data;

    var action = getBaseUrl() + '/contacts/' + response.id + '/update';

    form.attr('action', action);

    console.log(response.data.TYPE);

    switch (type) {
        case 'applicant':
            fillFormInputs(form, data);
            break;
        case 'engineer':
            form = $('#form-edit-engineer');
            fillFormInputs(form, data);
            break;
        case 'coapplicant':
            form = $('#form-edit-co-applicant');

            fillFormInputs(form, data);
            //update ymd dates
            update_ymd_dates();
            break;
        case 'copermittee':

            form = $('#form-edit-co-perm');

            fillFormInputs(form, data);

            console.log('data is ' + data.Ack);

            //check uncheck acknowledged check box based on db value
            if (parseInt(data.Ack) === 1) {
                form.find('#Ack').prop('checked', true).val(1);
            } else {
                form.find('#Ack').prop('checked', false).val(1);
            }

            //update ymd dates
            update_ymd_dates();
            break;
    }
}

function fillFormInputs(form, data) {

    var inputs = form.find('input, select');

    inputs.each(function (index, input) {


        console.log(data[input.id]);

        //check if input exists
        if (input.id.length > 0) {

            if (data[input.id] !== undefined) {

                input.value = data[input.id];
            }
        }

        $(input).trigger('change');

    });
}
