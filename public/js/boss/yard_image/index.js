function addNewYardImage(yardId){
    let modal= $('#modal-update-save-yard-image');
    modal.find('#modalTitle').text('Add New Image');
    modal.find('#image').attr('src','');
    modal.find('input#imageInput').val('');
    modal.find('#form-yard-image').attr('action', ADD_NEW_IMAGE_URL+'/'+yardId);
    modal.modal('show');
}

function updateYardImage(yardId){
    let modal= $('#modal-update-save-yard-image');
    modal.find('#modalTitle').text('Update Image');
    modal.find('#image').attr('src','');
    modal.find('input#imageInput').val('');
    modal.find('#form-yard-image').attr('action', UPDATE_IMAGE_URL+'/'+yardId);
    modal.modal('show');
}

function deleteYardImage(imageId){
    $('#modal-confirm-delete').modal('show');
    $('#form-delete-image').attr('action',DELETE_IMAGE_URL+'/'+imageId);
}

function handleDragOverUpdateSave(event) {
    event.preventDefault();
    event.currentTarget.style.backgroundColor = '#ececec';
}

//thả file
function handleDropUpdateSave(event) {
    event.preventDefault();
    const dropZone = event.currentTarget;
    dropZone.style.backgroundColor = 'white';

    const file = event.dataTransfer.files[0];
    const fileInput = $('#yardImageInput')[0];

    if (file && file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = function (e) {
            $('#yardImage').attr('src', e.target.result); // Cập nhật src của thẻ img
        };
        reader.readAsDataURL(file);
        // Gắn file vào input để chuẩn bị submit
        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);
        fileInput.files = dataTransfer.files;
    } else {
        Notification.showError('Please upload an valid Image')
        $('#yardImageInput').val('');
    }
}

function prepareSubmitYardImage(event){
    event.preventDefault();
    const file = $('#yardImage').attr('src');
    const MAX_FILE_SIZE = 2 * 1024 * 1024; // Giới hạn dung lượng: 2MB
    if (file!=='') {
        // Kiểm tra dung lượng hình ảnh mới
        if ($('#yardImageInput')[0].files[0].size > MAX_FILE_SIZE) {
            Notification.showError('File size exceeds 2MB. Please upload a smaller file.');
            return;
        }
        event.target.submit();
    } else {
        // chưa có hình
        Notification.showError('Please upload an Image');
    }
}
function imageOnchangeUpdateSave(event) {
    const file = event.target.files[0];
    // Kiểm tra nếu file không rỗng và MIME type là hình ảnh
    if (file && file.type.startsWith('image/')) {
        const reader = new FileReader();

        reader.onload = function(e) {
            $('#yardImage').attr('src', e.target.result);
        };
        reader.readAsDataURL(file);
    } else {
        Notification.showError('Please upload an valid Image')
        $('#yardImageInput').val('');
    }
}
