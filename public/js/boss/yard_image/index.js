function showModalDeleteYardImage(imageId) {
    let modal=  $('#modal-confirm-delete-yard-image');
    modal.modal('show');
    let form=modal.find('form#form-delete-image')
    form.attr('action', DELETE_YARD_IMAGE_URL + '/' + imageId);
}

//phaanf add new

function yardImageNewOnchange(event,yardId) {
    const file = event.target.files[0];
    if (file && file.type.startsWith('image/')) {
        const reader = new FileReader();

        reader.onload = function (e) {
            const oldImg = document.getElementById('YardImageSave'+yardId);
            oldImg.src = e.target.result;
            oldImg.classList.remove('hidden');

            // Ẩn icon và text
            document.getElementById('uploadIcon'+yardId).classList.add('hidden');
            document.getElementById('uploadText'+yardId).classList.add('hidden');

            // Hiện nút Save và Cancel
            document.getElementById('actionButtons'+yardId).classList.remove('hidden');
        };

        reader.readAsDataURL(file);
    } else {
        Notification.showError('Please upload a valid image. ')
        resetForm(yardId);
    }
}

function resetForm(yardId) {
    document.getElementById('YardImageSaveInput'+yardId).value = '';
    document.getElementById('YardImageSave'+yardId).classList.add('hidden');
    document.getElementById('uploadIcon'+yardId).classList.remove('hidden');
    document.getElementById('uploadText'+yardId).classList.remove('hidden');
    document.getElementById('actionButtons'+yardId).classList.add('hidden');
}


//xử lý kéo file
function handleDragOverNew(event) {
    event.preventDefault();
    const dropZone = event.currentTarget;
    dropZone.style.backgroundColor = '#ececec';
    dropZone.style.borderColor = '#4caf50';
}


//thả file
function handleDropNew(event,yardId) {
    console.log(yardId)
    event.preventDefault();
    const dropZone = event.currentTarget;
    dropZone.style.backgroundColor = 'white'; // Reset lại màu nền sau khi thả file
    dropZone.style.borderColor = '#d1d5db'; // Reset lại màu viền (mặc định xám)

    const file = event.dataTransfer.files[0];
    let fileInput=$('#YardImageSaveInput'+yardId)[0];
    if (file && file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = (e) => {
            // Cập nhật src của thẻ img và hiển thị ảnh
            const oldImg = document.getElementById('YardImageSave'+yardId);
            oldImg.src = e.target.result;
            oldImg.classList.remove('hidden');

            // Ẩn icon và text
            document.getElementById('uploadIcon'+yardId).classList.add('hidden');
            document.getElementById('uploadText'+yardId).classList.add('hidden');

            // Hiện nút Save và Cancel
            document.getElementById('actionButtons'+yardId).classList.remove('hidden');
        };
        reader.readAsDataURL(file);
        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);
        fileInput.files = dataTransfer.files;
    } else {
        // Thông báo lỗi và đặt lại form
        Notification.showError('Please upload a valid image.');
        resetForm(yardId);
    }
}


function prepareSubmitSaveNewYardImage(event,yardId){
    console.log(yardId)
    event.preventDefault();
    const file = $('#YardImageSave'+yardId).attr('src');
    const yardImageSaveInput = $('#YardImageSaveInput'+yardId).val();
    const MAX_FILE_SIZE = 2 * 1024 * 1024; // Giới hạn dung lượng: 2MB
    if (file!=='') {
        //đã có hình cũ => can submit
        //kiểm tra có cập nhật hình mới
        if (yardImageSaveInput!==''){
            // Kiểm tra dung lượng hình ảnh mới
            if ($('#YardImageSaveInput'+yardId)[0].files[0].size > MAX_FILE_SIZE) {
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


///phần update =======================
function showModalUpdateYardImage(imageId){
    let modal=$('#modal-update-yard-image');
    modal.find('#yardImageUpdateInput').val('');
    modal.find('#yardImageUpdate').attr('src','');
    let form=modal.find('form#form-yard-image-update');
    form.attr('action',UPDATE_YARD_IMAGE_URL+'/'+ imageId);
    modal.modal('show');
}


function prepareSubmitUpdateYardImage(event){
    event.preventDefault();
    const file = $('#yardImageUpdate').attr('src');
    const MAX_FILE_SIZE = 2 * 1024 * 1024; // Giới hạn dung lượng: 2MB
    if (file!=='') {
        // Kiểm tra dung lượng hình ảnh mới
        if ($('#yardImageUpdateInput')[0].files[0].size > MAX_FILE_SIZE) {
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


function handleDragOverUpdateYardImage(event) {
    event.preventDefault();
    event.currentTarget.style.backgroundColor = '#ececec';
}

//thả file
function handleDropUpdateYardImage(event) {
    event.preventDefault();
    const dropZone = event.currentTarget;
    dropZone.style.backgroundColor = 'white';

    const file = event.dataTransfer.files[0]; // Lấy file đầu tiên
    let fileInput=$('#yardImageUpdateInput')[0];
    if (file && file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = function (e) {
            $('#yardImageUpdate').attr('src', e.target.result); // Cập nhật src của thẻ img
        };
        reader.readAsDataURL(file); // Đọc file để hiển thị
        // Gắn file vào input để chuẩn bị submit
        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);
        fileInput.files = dataTransfer.files;
    } else {
        Notification.showError('Please upload an valid Image')
        $('#yardImageUpdateInput').val('');
    }
}
function yardImageOnchangeUpdate(event) {
    const file = event.target.files[0];
    // Kiểm tra nếu file không rỗng và MIME type là hình ảnh
    if (file && file.type.startsWith('image/')) {
        const reader = new FileReader();

        reader.onload = function(e) {
            $('#yardImageUpdate').attr('src', e.target.result);
        };
        reader.readAsDataURL(file);
    } else {
        Notification.showError('Please upload an valid Image')
        $('#yardImageUpdateInput').val('');
    }
}
