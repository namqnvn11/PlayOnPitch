$(document).ready(function () {


    $(document).on('click', '.js-on-create', function () {
        var _modal = $('#modal-edit');
        $('#form-data')[0].reset();
        _modal.find('h4').text('Add new');
        _modal.modal('show');
    });

    $(document).on('click', '.js-on-delete', function () {
        var _modal = $('#modal-confirm');
        var _form = $('#form-delete');
        var id = $(this).attr('data-id');
        _form.find('input[name="id"]').val(id);
        _modal.modal('show');
    });

    $(document).ready(function () {

        $('#province_id').on('change', function () {
            var provinceId = $(this).val();
            if (provinceId) {
                $.ajax({
                    url: getDistrictsUrl,
                    type: 'GET',
                    data: { province_id: provinceId },
                    success: function (data) {
                        $('#district_id').empty();
                        $('#district_id').append('<option value="">Select District</option>');
                        $.each(data, function (key, district) {
                            $('#district_id').append('<option value="' + district.id + '">' + district.name + '</option>');
                        });
                    },

                    error: function () {
                        Notification.showError('Error when retrieving district data.');
                    }
                });
            } else {
                $('#district_id').empty();
                $('#district_id').append('<option value="">Select District</option>');
            }
        });
    });

    $(document).on('click', '.js-on-edit', function () {
        var _modal = $('#modal-edit');
        var url = $(this).attr('data-url');

        $('#form-data')[0].reset();
        _modal.find('h4').text('Edit');

        $.ajax({
            url: url,
            type: 'GET',
            dataType:"json",
            success: function (response) {

                if (response.success) {
                    console.log(response.data);
                    var data = response.data;
                    $('input[name="id"]').val(data.id);
                    $('input[name="full_name"]').val(data.full_name);
                    $('input[name="email"]').val(data.email);
                    $('input[name="password"]').val(data.password);
                    $('input[name="phone"]').val(data.phone);
                    $('input[name="address"]').val(data.address);
                    $('input[name="district_id"]').val(data.district_id);
                    $('#modal-edit').modal('show');
                }else{
                    Notification.showError(response.message);
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });

        _modal.modal('show');
    });

    saveData();
    deleteData();

});

function deleteData() {

    $("form#form-delete").submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: DELETE_URL,
            type: 'POST',
            dataType:"json",
            data: formData,
            success: function (response) {

                if (response.success) {
                    Notification.showSuccess(response.message);
                    // Reset form
                    $("form#form-delete")[0].reset();

                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);


                }else{
                    Notification.showError(response.message);
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
}

function saveData() {
    $("form#form-data").submit(function(e) {
        e.preventDefault();
        console.log("Submit save");
        var formData = new FormData(this);

        $.ajax({
            url: STORE_URL,
            type: 'POST',
            dataType: "json",
            data: formData,
            success: function(response) {
                if (response.success) {
                    Notification.showSuccess(response.message);
                    $('#modal-edit').modal('hide');
                    // Reset form
                    $("form#form-data")[0].reset();

                    setTimeout(() => {
                        window.location.reload();
                    }, 1200);
                } else {
                    Notification.showError(response.message);
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) { // Xử lý lỗi validate
                    let errors = xhr.responseJSON.errors;

                    // Xóa các thông báo lỗi cũ
                    $('.error-message').remove();

                    // Hiển thị các lỗi mới
                    $.each(errors, function(field, messages) {
                        messages.forEach(function(message) {
                            $(`input[name="${field}"]`).after(`<span class="error-message" style="color: red;">${message}</span>`);
                        });
                    });
                } else {
                    // Các lỗi khác
                    console.error("AJAX error:", xhr.statusText);
                    Notification.showError("An error occurred: " + xhr.statusText);
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
}
