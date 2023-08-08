$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    //clear to and from inputs if users clears date range
    $('#date-range').on('keyup click', function () {
        if ($(this).val() === '') {
            $('#to, #from').val('');
        }
    });

    $('#btn-search').on('click', function (e) {
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
            }
            ,
            error: function (response) {

            }
            ,
            complete: function () {
                hideSpinner(btn, '<strong>Search Project</strong>');
            }
        });

    });


    //get data for second page & check the filters as well
    $('body').on('click', '.pagination a', function (e) {
        e.preventDefault();

        var page = $(this).attr('href').split('page=')[1];
        event.preventDefault();

        $('ul.pagination').find('li').removeClass('active');

        $(this).parent('li').addClass('active');

        filter(page);
    });

});

function filter(page = 1) {

    $.ajax({
        url: '/project/search?page=' + page,
        type: 'post',
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
        '<td class="text-navy project-name" ><a href="#" class="text-navy "></a></td>' +
        '<td class="project-technician"></td>' +
        '<td class="project-location"></td>' +
        '<td class="text-center project-details" >' +
        '<a href="#" class="text-navy btn btn-white letters-link" data-toggle="tooltip" title="Generate Letter"><i class="fa fa-envelope-open-o"></i></a> ' +
        '<a class="text-navy btn btn-white inspections-link" data-toggle="tooltip" title="Site Inspection"><i class="fa fa-search-plus"></i></a> ' +
        '<a href="#" class="text-navy btn btn-white projects-link" title="Edit Project" data-toggle="tooltip" ><i class="fa fa-edit"></i></a> ' +
        '</td>' +
        '</tr>');
}


function fillHtmlTemplate(htmlTemplate, data) {

    var rows = '';
    var reviewer = '';
    var location = '';

    $.each(data, function (index, value) {

        //checking to see object is not null
        reviewer = (value.project_details && value.project_details.reviewer) ? value.project_details.reviewer : '';
        location = (value.project_location && value.project_location.address_1) ? value.project_location.address_1 : '';

        htmlTemplate.find('.entry-number').text(value.id.pad(2));
        htmlTemplate.find('.project-name a').text(value.name);
        htmlTemplate.find('.project-technician').text(reviewer.name);
        htmlTemplate.find('.project-location').text(location);

        var projects_path = getBaseUrl() + '/projects/' + value.id + '/edit';
        var inspections_path = getBaseUrl() + '/inspections/' + value.id;
        var letters_path = getBaseUrl() + '/letters/' + value.id;

        htmlTemplate.find('.project-name a').attr('href', projects_path);
        htmlTemplate.find('.projects-link').attr('href', projects_path);
        htmlTemplate.find('.inspections-link').attr('href', inspections_path);
        htmlTemplate.find('.letters-link').attr('href', letters_path);

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

    for (i = 1; i <= response.last_page; i++) {

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
