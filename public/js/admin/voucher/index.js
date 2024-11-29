$(document).ready(function () {

    $(document).on('click', '.js-on-create', function () {
        var _modal = $('#modal-edit');
        $('#form-data')[0].reset();
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

    $(document).on('keydown', function(event) {
        if (event.key === "Escape" || event.keyCode === 27) {
            $('#modal-confirm').modal('hide');
        }
    });



    saveData();
    deleteData();
    initializePriceAndConditionsUpdater();

});

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
                $('select[name="name"]').val(data.name);
                $('input[name="price"]').val(data.price);
                $('input[name="release_date"]').val(data.release_date);
                $('input[name="end_date"]').val(data.end_date);
                $('input[name="conditions_apply"]').val(data.conditions_apply);
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

function showModalBlock(voucherId) {
    const form = document.getElementById('form-block');
    document.getElementById('confirmLabel').innerHTML='Are you sure you want to block this Voucher?'
    document.getElementById('modalTitle').innerHTML='Block Voucher';
    document.getElementById('voucherId').value= voucherId;
    form.action = `/admin/voucher/block/${voucherId}`;
    $('#modal-confirm').modal('show');
}
function showModalUnBlock(voucherId){
    const form = document.getElementById('form-block');
    form.action = `/admin/voucher/unblock/${voucherId}`;
    document.getElementById('confirmLabel').innerHTML='Are you sure you want to unblock this Voucher?'
    document.getElementById('modalTitle').innerHTML='Unblock Voucher';
    document.getElementById('voucherId').value= voucherId;
    $('#modal-confirm').modal('show');
}
function filter(){
    document.getElementById('filterForm').submit();
}

function blockUnBlockSubmit(event){
    event.preventDefault();
    const form = document.getElementById('form-block');
    var formData = new FormData(form);
    let voucherId= document.getElementById('voucherId').value;
    let submitURL= document.getElementById('modalTitle').innerHTML==='Block Voucher' ? BLOCK_URL : UNBLOCK_URL;
    submitURL= submitURL+'/'+voucherId;
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

function initializePriceAndConditionsUpdater() {
    const selectElement = document.getElementById('name');
    const priceInput = document.getElementById('price');
    const conditionsApplyInput = document.getElementById('conditions_apply');

    function updateValues() {
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        const price = parseInt(selectedOption.getAttribute('data-price'), 10) || 0;

        priceInput.value = price;
        conditionsApplyInput.value = price / 100;
    }

    selectElement.addEventListener('change', updateValues);
    updateValues();
}


//phần xử lý hình ảnh
function  showModalImage(voucherId){
    $('#imageInput').val('');
    $('#oldImg').attr('src','');
    $('input#voucherId').val(voucherId);
    $.ajax({
        url: GET_IMAGE_URL+'/'+voucherId,
        type: 'get',
        success: function(response) {
            $('#oldImg').attr('src',response.data);
        },
        cache: false,
        contentType: false,
        processData: false
    });

    $('#modal-image').modal('show');
}

function imageOnchange(event) {
    const file = event.target.files[0]; // Lấy tệp đầu tiên được chọn
    // Kiểm tra nếu file không rỗng và MIME type là hình ảnh
    if (file && file.type.startsWith('image/')) {
        const reader = new FileReader();

        reader.onload = function(e) {
            $('#oldImg').attr('src', e.target.result); // Cập nhật src của thẻ img
        };

        reader.readAsDataURL(file); // Đọc file dưới dạng Data URL
    } else {
        Notification.showError('Please upload an valid Image')
        $('#imageInput').val('');
    }
}

//xử lý kéo file
function handleDragOver(event) {
    event.preventDefault();
    event.currentTarget.style.backgroundColor = '#ececec';
}

//thả file
function handleDrop(event) {
    event.preventDefault();
    const dropZone = event.currentTarget;
    dropZone.style.backgroundColor = 'white';

    const file = event.dataTransfer.files[0];
    const fileInput = $('#imageInput')[0];
    if (file && file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = function (e) {
            $('#oldImg').attr('src', e.target.result);
        };
        reader.readAsDataURL(file);
        // Gắn file vào input để chuẩn bị submit
        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);
        fileInput.files = dataTransfer.files;
    } else {
        Notification.showError('Please upload an valid Image')
        $('#imageInput').val('');
    }
}

function prepareSubmit(event){
    event.preventDefault();
    const file = $('#oldImg').attr('src');
    const imageInput = $('#imageInput').val();
    const voucherId = $('#voucherId').val();
    const MAX_FILE_SIZE = 2 * 1024 * 1024; // Giới hạn dung lượng: 2MB
    if (file!=='') {
        //đã có hình cũ => can submit
        //kiểm tra có cập nhật hình mới
        if (imageInput!==''){
            // Kiểm tra dung lượng hình ảnh mới
            if ($('#imageInput')[0].files[0].size > MAX_FILE_SIZE) {
                Notification.showError('File size exceeds 2MB. Please upload a smaller file.');
                return;
            }
            if (voucherId) {
                $(event.target).attr('action', SAVE_IMAGE_URL + '/' + voucherId);
                event.target.submit();
            }
        }else {
            Notification.showError('Nothing Change')
        }
    } else {
        // chưa có hình
        Notification.showError('Please upload an Image')
    }
}
