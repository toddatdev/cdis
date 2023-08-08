$(function () {

    $('body').on('click', '.btn-update-status', function (e) {
        e.preventDefault();

        var btn = $(this);


        var btn_text = btn.text();
        console.log(btn_text);

        if (btn_text.toLowerCase() === 'activate') {

            btn_text = 'Deactivate';
            btn.removeClass('btn-success').addClass('btn-danger').text('Deactivate');

        } else {

            btn_text = 'Activate';
            btn.removeClass('btn-danger').addClass('btn-success').text('Activate');

        }

        showSpiner(btn);

        $.ajax({
            url: btn.attr('href'),
            type: 'get',
            dataType: "json",
            success: function (response) {

                if (!response.error) {

                    notify(response.title, response.message);
                }
            },
            error: function (response) {

            },
            complete: function () {
                hideSpinner(btn, btn_text);
            }
        });
    });
});
