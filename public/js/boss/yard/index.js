$(document).ready(function () {


    $(document).on('click', '.js-on-create', function () {
        var _modal = $('#modal-edit');
        $('#form-data')[0].reset();
        $('.error-message').remove();
        _modal.find('h4').text('Add new');
        fetchDistricts($('#province_id').attr('province-id')).then(()=>{
                $('select[name="district"]').val($('#district_id').attr('district-id'));
        }
        );

        _modal.modal('show');
    });

    $(document).on('click', '.js-on-delete', function () {
        var _modal = $('#modal-confirm');
        var _form = $('#form-delete');
        var id = $(this).attr('data-id');
        _form.find('input[name="id"]').val(id);
        _modal.modal('show');
    });

    $(document).on('keydown', function(event) {
        if (event.key === "Escape" || event.keyCode === 27) {
            $('#modal-confirm').modal('hide');
            $('#modal-edit').modal('hide');
        }
    });

    $(document).ready(function () {
        $('#province_id').on('change', function () {
            var provinceId = $(this).val();
            fetchDistricts(provinceId);
        });
    });

    function fetchDistricts(provinceId) {
        return new Promise((resolve,reject)=>{
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
                        resolve();
                    },
                    error: function () {
                        Notification.showError('Error when retrieving district data.');
                        reject();
                    }
                });
            } else {
                $('#district_id').empty();
                $('#district_id').append('<option value="">Select District</option>');
            }
        })
    }

    $(document).on('click', '.js-on-edit', function () {
        var _modal = $('#modal-edit');
        var url = $(this).attr('data-url');
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
                    $('select[name="yard_name"]').val(data.yard_name);
                    $('select[name="yard_type"]').val(data.yard_type);
                    $('textarea[name="description"]').val(data.description);
                    $('select[name="province"]').val(response.province.id);
                    fetchDistricts($('#province_id').val())
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

            cache: false,
            contentType: false,
            processData: false
        });

        _modal.modal('show');
    });

    saveData();
    deleteData();

});

function loadBossAddress(){

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
                    // Xóa các thông báo lỗi cũ
                    $('.error-message').remove();

                    // Hiển thị các lỗi mới
                    $.each(errors, function(field, messages) {
                        messages.forEach(function(message) {
                            $(`textarea[name="${field}"]`).after(`<span class="error-message" style="color: red;">${message}</span>`);
                            $(`select[name="${field}"]`).after(`<span class="error-message" style="color: red;">${message}</span>`);
                        });
                    });
                } else {
                    // Các lỗi khác
                    console.error("AJAX error:", xhr);
                    Notification.showError("An error occurred: " + xhr.statusText);
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
}

function showModalBlock(yardId) {
    const form = document.getElementById('form-block');
    document.getElementById('confirmLabel').innerHTML='Are you sure you want to block this Yard?'
    document.getElementById('modalTitle').innerHTML='Block Yard';
    document.getElementById('yardId').value= yardId;
    form.action = `/boss/yard/block/${yardId}`;
    $('#modal-confirm').modal('show');
}
function showModalUnBlock(yardId){
    const form = document.getElementById('form-block');
    form.action = `/boss/yard/unblock/${yardId}`;
    document.getElementById('confirmLabel').innerHTML='Are you sure you want to unblock this Yard?'
    document.getElementById('modalTitle').innerHTML='Unblock Yard';
    document.getElementById('yardId').value= yardId;
    $('#modal-confirm').modal('show');
}
function filter(){
    document.getElementById('filterForm').submit();
}

function blockUnBlockSubmit(event){
    event.preventDefault();
    const form = document.getElementById('form-block');
    var formData = new FormData(form);
    let yardId= document.getElementById('yardId').value;
    let submitURL= document.getElementById('modalTitle').innerHTML==='Block Yard' ? BLOCK_URL : UNBLOCK_URL;
    submitURL= submitURL+'/'+yardId;
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


