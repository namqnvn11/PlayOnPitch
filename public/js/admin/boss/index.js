

$(document).ready(function () {


    $(document).on('click', '.js-on-create', function () {
        var _modal = $('#modal-edit');
        $('#form-data')[0].reset();
        $('input[name="email"]').prop('disabled', false);
        $('input[name="id"]').val(null);
        $('#password_group').show();
        $('.error-message').remove();
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
        $('#province').on('change', function () {
            var provinceId = $(this).val();
            fetchDistricts(provinceId)
        });
    });

    $(document).on('keydown', function(event) {
        if (event.key === "Escape" || event.keyCode === 27) {
            $('#modal-confirm').modal('hide');
            $('#modal-confirm-reset-password').modal('hide');
        }
    });
    saveData();
    deleteData();

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

// $(document).on('click', '.js-on-edit', function () {
function viewDetail(event){
    var _modal = $('#modal-edit');
    var url = event.currentTarget.getAttribute('data-url');
    $('.error-message').remove();
    $('#form-data')[0].reset();
    _modal.find('h4').text('Edit');

    $.ajax({
        url: url,
        type: 'GET',
        dataType: "json",
        success: function (response) {
            if (response.success) {
                var data = response.data;
                $('input[name="id"]').val(data.id);
                $('input[name="email"]').val(data.email).prop('disabled', true);
                $('#password_group').hide();
                $('input[name="full_name"]').val(data.full_name);
                $('input[name="phone"]').val(data.phone);
                $('input[name="company_name"]').val(data.company_name);
                $('input[name="company_address"]').val(data.company_address);
                $('select[name="status"]').val(data.status.toString());
                $('select[name="province"]').val(response.province.id);
                fetchDistricts($('#province').val())
                    .then(()=>{
                        $('select[name="district"]').val(response.district.id);
                        $('#modal-edit').modal('show');
                    }).catch(()=>{
                    Notification.showError('Error when retrieving district data.');
                })
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
};

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
                            $(`select[name="${field}"]`).after(`<span class="error-message" style="color: red;">${message}</span>`);
                        });
                    });
                } else {
                    // Các lỗi khác
                    console.log(xhr.status);
                    Notification.showError("An error occurred: " + xhr.statusText);
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
}

function showModalBlock(event,bossId) {
    event.stopPropagation();
    const form = document.getElementById('form-block');
    document.getElementById('confirmLabel').innerHTML='Are you sure you want to block this Boss?'
    document.getElementById('modalTitle').innerHTML='Block Boss';
    document.getElementById('bossId').value= bossId;
    form.action = `/admin/boss/block/${bossId}`;
    $('#modal-confirm').modal('show');
}
function showModalUnBlock(event,bossId){
    event.stopPropagation();
    const form = document.getElementById('form-block');
    form.action = `/admin/boss/unblock/${bossId}`;
    document.getElementById('confirmLabel').innerHTML='Are you sure you want to unblock this Boss?'
    document.getElementById('modalTitle').innerHTML='Unblock Boss'
    document.getElementById('bossId').value= bossId;
    $('#modal-confirm').modal('show');
}
function filter(){
    document.getElementById('filterForm').submit();
}
function blockUnBlockSubmit(event){
    event.preventDefault();
    const form = document.getElementById('form-block');
    var formData = new FormData(form);
    let bossId= document.getElementById('bossId').value;
    let submitURL= document.getElementById('modalTitle').innerHTML==='Block Boss' ? BLOCK_URL : UNBLOCK_URL;
    submitURL= submitURL+'/'+bossId;
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

function prepareResetPassword(event,bossId){
    //chặn bubble event
    event.stopPropagation();
    document.getElementById('resetPasswordBossId').value=bossId;
    document.getElementById('new_password').value='12345678';
    var _modal = $('#modal-confirm-reset-password');
    $('.error-message').remove();
    _modal.modal('show');
}

function resetPassword(event){
    event.preventDefault();
    const form = document.getElementById('form-reset-password');
    var formData = new FormData(form);
    let bossId= document.getElementById('resetPasswordBossId').value;
    let submitURL= RESET_PASSWORD_URL+ '/'+ bossId;
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
