$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    var btn_triggered_contact_modal = '';

    $('#modal-search-contact').on('show.bs.modal', function (event) {

        btn_triggered_contact_modal = $(event.relatedTarget); // Button that triggered the modal

        var modal = $(this);
        var title = btn_triggered_contact_modal.data('title');
        var type = btn_triggered_contact_modal.data('type');

        modal.find('#btn-search-contact').html('<strong>Search ' + type.capitalize() + '</strong>');
        modal.find('.modal-title').text(title);
        modal.find('#input-contact-type').val(type);
    });

    $('#modal-search-contact').on('hidden.bs.modal', function (event) {
        var modal = $(this);

        modal.find('form')[0].reset();
        modal.find('#search-results-container').addClass('d-none');

    });

    $('body').on('click', '.btn-add-contact', function (e) {
        e.preventDefault();

        var btn = $(this);
        var btnTxt = $(this).text();

        var url = btn.attr('href');

        showSpiner(btn, 'Fetching...');

        $.get(url, function (response) {

            var form = btn_triggered_contact_modal.parents('.ibox');

            hideSpinner(btn, btnTxt);

            resetForm(form);

            populateContactForm(form, response);


            btn.parents('.modal').modal('hide');

        });
    });

    $('#btn-search-contact').on('click', function (e) {
        e.preventDefault();

        var form = $(this).parents('form');
        var btn = $(this);
        var modal = btn.parents('.modal');

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

                        modal.find('#search-results-container').removeClass('d-none');
                        modal.find('#search-table').removeClass('d-none');
                        modal.find('#not-found-message').addClass('d-none');

                        modal.find('#table-search-body').empty().html(rows);

                        $('body').find('[data-toggle="tooltip"]').tooltip();

                        var links = getPaginationLinks(response);

                        modal.find('#pagination').removeClass('d-none').html(links);

                    } else {

                        modal.find('#search-results-container').removeClass('d-none');
                        modal.find('#search-table').addClass('d-none');
                        modal.find('#not-found-message').removeClass('d-none');
                        modal.find('#pagination').addClass('d-none');
                    }


                }
            }, error: function (response) {

            }, complete: function () {
                hideSpinner(btn, '<strong>Search ' + btn_triggered_contact_modal.data('type').capitalize() + '</strong>');
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
        '<td class="text-navy company" ></td>' +
        '<td class="name" ></td>' +
        '<td class="city" >' +
        '<td class="text-center"><a href="#" class="btn btn-primary btn-xs btn-add-contact">Add Contact</a></td>' +
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

        htmlTemplate.find('.company').text(company);
        htmlTemplate.find('.name').text(name);
        htmlTemplate.find('.city').text(csz);

        var btn_add_contact_url = getBaseUrl() + '/contacts/' + value.type + '/' + value.id;

        htmlTemplate.find('.btn-add-contact').text('Add ' + value.type.capitalize());
        htmlTemplate.find('.btn-add-contact').attr('href', btn_add_contact_url);

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

String.prototype.capitalize = function () {
    return this.charAt(0).toUpperCase() + this.slice(1)
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

    resetForm(form);

    switch (type) {
        case 'applicant':
            fillFormInputs(form, data);
            break;
        case 'engineer':
            form = $('#form-step-4');
            fillFormInputs(form, data);
            form.find('[name=name]').val(data.SENTBY);
            break;

        case 'coapplicant':
            form.find('#APPLIC').val(data.Name).trigger('change');
            form.find('#APP_COMPANY').val(data.Company);
            form.find('#APP_ADD1').val(data.Address1);
            form.find('#APP_ADD2').val(data.Address2);
            form.find('#APP_CITY').val(data.City);
            form.find('#APP_ZIP').val(data.Zip);
            form.find('#APP_STATE').val(data.State);

            form.find('#APP_PHONE').val(data.Phone);
            form.find('#APP_EXT').val(data.PhoneExt);
            form.find('#APP_FAX').val(data.Fax);
            form.find('#APP_EMAIL').val(data.Email);
            break;
        case 'copermittee':

            form = $('#form-co-permittee-save');

            //check uncheck acknowledged check box based on db value
            if (parseInt(data.Ack) === 1) {
                form.find('#acknowledged').prop('checked', true).val(1);
            } else {
                form.find('#acknowledged').prop('checked', false).val(1);
            }

            console.log('date is ' + data.DATE_ACQUIRED);

            form.find('#received-date').val(data.DATE_ACQUIRED).trigger('change');
            form.find('#reviewed-date').val(data.Ack_Date);
            form.find('#title').val(data.title);
            form.find('#company').val(data.COMPANY);
            form.find('#email').val(data.Email);
            form.find('#address-1').val(data.ADDRESS1);
            form.find('#address-2').val(data.ADDRESS2);
            form.find('#city').val(data.CITY);
            form.find('#state').val(data.STATE);

            form.find('#zipcode').val(data.ZIP);
            form.find('#PHONE').val(data.PHONE);
            form.find('#FAX').val(data.FAX);

            //update ymd dates
            update_ymd_dates();
            break;
    }
}

function fillFormInputs(form, data) {

    var inputs = form.find('input, select');

    inputs.each(function (index, input) {

        console.log(input.id + ' ' + data[input.id]);
        //check if input exists
        if (input.id.length > 0) {

            if (data[input.id] !== undefined) {

                input.value = data[input.id];
            }
        }

        $(input).trigger('change');

    });
}
