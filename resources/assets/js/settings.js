$(function () {


    $('#form-user-settings').on('submit', function (e) {
        e.preventDefault();

        var form = $(this);

        var btn = form.find('#btn-update');

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
                hideSpinner(btn, '<strong>Update Info</strong>');
            }
        });
    });
});
