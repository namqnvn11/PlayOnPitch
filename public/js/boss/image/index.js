
//phần xử lý hình ảnh
function generalImageSaveOnchange(event) {
    const file = event.target.files[0];
    if (file && file.type.startsWith('image/')) {
        const reader = new FileReader();

        reader.onload = function (e) {
            const oldImg = document.getElementById('generalImageSave');
            oldImg.src = e.target.result;
            oldImg.classList.remove('hidden');

            // Ẩn icon và text
            document.getElementById('uploadIcon').classList.add('hidden');
            document.getElementById('uploadText').classList.add('hidden');

            // Hiện nút Save và Cancel
            document.getElementById('actionButtons').classList.remove('hidden');
        };

        reader.readAsDataURL(file);
    } else {
        Notification.showError('Please upload a valid image. ')
        resetForm();
    }
}

function resetForm() {
    document.getElementById('generalImageSaveInput').value = '';
    document.getElementById('generalImageSave').classList.add('hidden');
    document.getElementById('uploadIcon').classList.remove('hidden');
    document.getElementById('uploadText').classList.remove('hidden');
    document.getElementById('actionButtons').classList.add('hidden');
}


//xử lý kéo file
function handleDragOverNew(event) {
    event.preventDefault();
    const dropZone = event.currentTarget;
    dropZone.style.backgroundColor = '#ececec';
    dropZone.style.borderColor = '#4caf50';
}


//thả file
function handleDropNew(event) {
    event.preventDefault();
    const dropZone = event.currentTarget;
    dropZone.style.backgroundColor = 'white'; // Reset lại màu nền sau khi thả file
    dropZone.style.borderColor = '#d1d5db'; // Reset lại màu viền (mặc định xám)

    const file = event.dataTransfer.files[0];
    let fileInput=$('#generalImageSaveInput')[0];
    if (file && file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = (e) => {
            // Cập nhật src của thẻ img và hiển thị ảnh
            const oldImg = document.getElementById('generalImageSave');
            oldImg.src = e.target.result;
            oldImg.classList.remove('hidden');

            // Ẩn icon và text
            document.getElementById('uploadIcon').classList.add('hidden');
            document.getElementById('uploadText').classList.add('hidden');

            // Hiện nút Save và Cancel
            document.getElementById('actionButtons').classList.remove('hidden');
        };
        reader.readAsDataURL(file);
        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);
        fileInput.files = dataTransfer.files;
    } else {
        // Thông báo lỗi và đặt lại form
        Notification.showError('Please upload a valid image.');
        resetForm();
    }
}

function callSubmit(){
    $('form#form-save-general-image').submit();
}

function prepareSubmitSave(event){
    event.preventDefault();
    const file = $('#generalImageSave').attr('src');
    const generalImageSaveInput = $('#generalImageSaveInput').val();
    const MAX_FILE_SIZE = 2 * 1024 * 1024; // Giới hạn dung lượng: 2MB
    if (file!=='') {
        //đã có hình cũ => can submit
        //kiểm tra có cập nhật hình mới
        if (generalImageSaveInput!==''){
            // Kiểm tra dung lượng hình ảnh mới
            if ($('#generalImageSaveInput')[0].files[0].size > MAX_FILE_SIZE) {
                Notification.showError('File size exceeds 2MB. Please upload a smaller file.');
                return;
            }
            event.target.submit();
        }else {
            Notification.showError('Nothing Change');
        }
    } else {
        // chưa có hình
        Notification.showError('Please upload an Image');
    }
}

function showModalDeleteImage(imageId) {
    $('#modal-confirm-delete').modal('show');
    let form=$('form#form-delete-image')
    form.attr('action', DELETE_IMAGE_URL + '/' + imageId);
}



// phần update======================

function showModalUpdateImage(imageId){
    let modal=$('#modal-update-general-image');
    $('#imageInputUpdate').val('');
    $('#imageUpdate').attr('src','');
    let form=modal.find('form#form-update-image');
    form.attr('action',UPDATE_IMAGE_URL+'/'+ imageId);
    modal.modal('show');
}


function prepareSubmitUpdateGeneralImage(event){
    event.preventDefault();
    const file = $('#imageUpdate').attr('src');
    const MAX_FILE_SIZE = 2 * 1024 * 1024; // Giới hạn dung lượng: 2MB
    if (file!=='') {
        // Kiểm tra dung lượng hình ảnh mới
        if ($('#imageInputUpdate')[0].files[0].size > MAX_FILE_SIZE) {
            Notification.showError('File size exceeds 2MB. Please upload a smaller file.');
            return;
        }
        // console.log(event.target)
        event.target.submit();
    } else {
        // chưa có hình
        Notification.showError('Please upload an Image');
    }
}


function handleDragOverUpdate(event) {
    event.preventDefault();
    event.currentTarget.style.backgroundColor = '#ececec';
}

//thả file
function handleDropUpdate(event) {
    event.preventDefault();
    const dropZone = event.currentTarget;
    dropZone.style.backgroundColor = 'white';

    const file = event.dataTransfer.files[0]; // Lấy file đầu tiên
    let fileInput=$('#imageInputUpdate')[0];
    if (file && file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = function (e) {
            $('#imageUpdate').attr('src', e.target.result); // Cập nhật src của thẻ img
        };
        reader.readAsDataURL(file); // Đọc file để hiển thị
        // Gắn file vào input để chuẩn bị submit
        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);
        fileInput.files = dataTransfer.files;
    } else {
        Notification.showError('Please upload an valid Image')
        $('#imageInputUpdate').val('');
    }
}
function imageOnchangeUpdate(event) {
    const file = event.target.files[0];
    // Kiểm tra nếu file không rỗng và MIME type là hình ảnh
    if (file && file.type.startsWith('image/')) {
        const reader = new FileReader();

        reader.onload = function(e) {
            $('#imageUpdate').attr('src', e.target.result);
        };
        reader.readAsDataURL(file);
    } else {
        Notification.showError('Please upload an valid Image')
        $('#imageInputUpdate').val('');
    }
}
