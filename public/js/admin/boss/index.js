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
                    $('input[name="email"]').val(data.email);
                    $('input[name="password"]').val(data.password);
                    $('input[name="full_name"]').val(data.full_name);
                    $('input[name="phone"]').val(data.phone);
                    $('input[name="company_name"]').val(data.company_name);
                    $('input[name="company_address"]').val(data.company_address);
                    $('input[name="status"]').val(data.status);
                    $('input[name="district_id"]').val(data.district_id);
                    $('#modal-edit').modal('show');
                } else {
                    Notification.showError(response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX error:", error); // Log lỗi vào console để xem chi tiết
                Notification.showError("An error occurred while fetching data: " + error);
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
            dataType:"json",
            data: formData,
            success: function (response) {

                if (response.success) {
                    Notification.showSuccess(response.message);
                    $('#modal-edit').modal('hide');
                    // Reset form
                    $("form#form-data")[0].reset();

                    setTimeout(() => {
                        window.location.reload();
                    }, 1200);


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
