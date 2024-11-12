$(document).on('click', '.js-on-edit', function () {
    var _modal = $('#modal-edit');
    var url = $(this).attr('data-url');

    $('#form-data')[0].reset();
    _modal.find('h4').text('Edit');

    $.ajax({
        url: url,
        type: 'GET',
        dataType: "json",
        success: function (response) {
            if (response.success) {
                console.log(response.data);
                var data = response.data;
                $('input[name="id"]').val(data.id);
                $('input[name="name"]').val(data.name);
                $('input[name="phone"]').val(data.phone).trigger('change');
                $('input[name="address"]').val(data.address).trigger('change');
                $('#modal-edit').modal('show');
            } else {
                Notification.showError(response.message);
            }
        },

        cache: false,
        contentType: false,
        processData: false
    });

    _modal.modal('show');
});
