$(document).ready(function () {

    $(document).on('click', '.js-on-create', function () {
        var _modal = $('#modal-edit');
        $('#form-data')[0].reset();
        $('#password').attr('placeholder', 'Enter password');
        $('.error-message').remove();
        _modal.find('h4').text('Add new');
        $('input[name="id"]').val(null);
        $('input[name="full_name"]').prop('disabled', false);
        $('input[name="email"]').prop('disabled', false);
        $('#passwordGroup').show();
        $('input[name="phone"]').prop('disabled', false);
        $('input[name="address"]').prop('disabled', false);
        $('select[name="province"]').prop('disabled', false);
        $('select[name="district"]').prop('disabled', false);
        $('#submitAddNewUser').show();
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
        $('#province').on('change', function () {
            var provinceId = $(this).val();
            fetchDistricts(provinceId)
        });
    });

    //sự kiện ấn Esc
    $(document).on('keydown', function(event) {
        if (event.key === "Escape" || event.keyCode === 27) {
          $('#modal-confirm').modal('hide');
          $('#modal-confirm-reset-password').modal('hide');
            $('#modal-edit').modal('hide');
        }
    });
    saveData();
});

function fetchDistricts(provinceId) {
    return new Promise((resolve,reject)=>{
        if (provinceId) {
            $.ajax({
                url: getDistrictsUrl,
                type: 'GET',
                data: { province_id: provinceId },
                success: function (data) {
                    $('#district').empty();
                    $('#district').append('<option value="">Select District</option>');
                    $.each(data, function (key, district) {
                        $('#district').append('<option value="' + district.id + '">' + district.name + '</option>');
                    });
                    resolve();
                },
                error: function () {
                    Notification.showError('Error when retrieving district data.');
                    reject();
                }
            });
        } else {
            $('#district').empty();
            $('#district').append('<option value="">Select District</option>');
        }
    })
}

function viewDetail(event) {
    var _modal = $('#modal-edit');
    var url = event.currentTarget.getAttribute('data-url');
    $('.error-message').remove();
    $('#form-data')[0].reset();
    _modal.find('h4').text('View User Detail');
    $.ajax({
        url: url,
        type: 'GET',
        dataType:"json",
        success: function (response) {
            if (response.success) {
                var data = response.data;
                $('input[name="id"]').val(data.id);
                $('input[name="full_name"]').val(data.full_name).prop('disabled', true);
                $('input[name="email"]').val(data.email).prop('disabled', true);
                $('#passwordGroup').hide();
                $('input[name="phone"]').val(data.phone).prop('disabled', true);
                $('input[name="address"]').val(data.address).prop('disabled', true);
                $('select[name="province"]').val(response.province.id).prop('disabled', true);
                $('#submitAddNewUser').hide();
                fetchDistricts($('#province').val())
                    .then(()=>{
                        $('select[name="district"]').val(response.district.id).prop('disabled', true);
                        $('#modal-edit').modal('show');
                    }).catch(()=>{
                    Notification.showError('Error when retrieving district data.');
                })
            }else{
                Notification.showError(response.message);
            }
        },
        error: function (){
            Notification.showError('Error when retrieving  user data.');
        },
        cache: false,
        contentType: false,
        processData: false
    });

    _modal.modal('show');
}

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
                        console.log(errors);
                    // Xóa các thông báo lỗi cũ
                    $('.error-message').remove();

                    // Hiển thị các lỗi mới
                    $.each(errors, function(field, messages) {
                        messages.forEach(function(message) {
                            $(`input[name="${field}"]`).after(`<span class="error-message" id="error-message" style="color: red;">${message}</span>`);
                            $(`select[name="${field}"]`).after(`<span class="error-message" id="error-message" style="color: red;">${message}</span>`);
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

function showModalBlock(userId,event) {
    event.stopPropagation();
    const form = document.getElementById('form-block');
    document.getElementById('confirmLabel').innerHTML='Are you sure you want to block this User?'
    document.getElementById('modalTitle').innerHTML='Block User';
    document.getElementById('userId').value= userId;
    form.action = `/admin/user/block/${userId}`;
    $('#modal-confirm').modal('show');
}
function showModalUnBlock(userId,event){
    event.stopPropagation();
    const form = document.getElementById('form-block');
    form.action = `/admin/user/unblock/${userId}`;
    document.getElementById('confirmLabel').innerHTML='Are you sure you want to unblock this User?'
    document.getElementById('modalTitle').innerHTML='Unblock User';
    document.getElementById('userId').value= userId;
    $('#modal-confirm').modal('show');
}
function filter(){
    document.getElementById('filterForm').submit();
}

function blockUnBlockSubmit(event){
    event.preventDefault();
    const form = document.getElementById('form-block');
    var formData = new FormData(form);
    let userId= document.getElementById('userId').value;
    let submitURL= document.getElementById('modalTitle').innerHTML==='Block User' ? BLOCK_URL : UNBLOCK_URL;
    submitURL= submitURL+'/'+userId;
    $.ajax({
        url: submitURL,
        type: 'POST',
        dataType: "json",
        data: formData,
        success: function(response) {
            if (response.success) {
                Notification.showSuccess(response.message);
                $('#modal-confirm').modal('hide');
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            } else {
                Notification.showError(response.message);
            }
        },
        error: function(xhr) {
            console.log(xhr.status);
            Notification.showError("An error occurred: " + xhr.statusText);
        },
        cache: false,
        contentType: false,
        processData: false
    });
}

function prepareResetPassword(event,userId){
    //chặn bubble event
    event.stopPropagation();
    document.getElementById('resetPasswordUserId').value=userId;
    var _modal = $('#modal-confirm-reset-password');
    $('.error-message').remove();
    _modal.modal('show');
}

function resetPassword(event){
    event.preventDefault();
    const form = document.getElementById('form-reset-password');
    var formData = new FormData(form);
    let userId= document.getElementById('resetPasswordUserId').value;
    let submitURL= RESET_PASSWORD_URL+ '/'+ userId;
    $.ajax({
        url: submitURL,
        type: 'POST',
        dataType: "json",
        data: formData,
        success: function(response) {
            if (response.success) {
                Notification.showSuccess(response.message);
                $('#modal-confirm-reset-password').modal('hide');
            } else {
                Notification.showError(response.message);
            }
        },
        error: function(xhr) {
            if (xhr.status){
                let errors = xhr.responseJSON.errors;
                console.log(errors);
                // Xóa các thông báo lỗi cũ
                $('.error-message').remove();

                // Hiển thị các lỗi mới
                $.each(errors, function(field, messages) {
                    messages.forEach(function(message) {
                        $(`input[name="${field}"]`).after(`<span class="error-message" id="error-message" style="color: red;">${message}</span>`);
                    });
                });
            }else {
                console.log(xhr.status);
                Notification.showError("An error occurred: " + xhr.statusText);
            }

        },
        cache: false,
        contentType: false,
        processData: false
    });
}
