$(document).ready(function () {
    const changePasswordForm = $('#changePasswordForm');
    const modalEditProfile=$('#modal-edit-user-profile');
    // Submit Change Password Form
    changePasswordForm.submit(function (e) {
        e.preventDefault(); // Ngừng việc gửi form
        const formData = new FormData(this); // Lấy dữ liệu từ form

        $.ajax({
            beforeSend: function () {
                $('#changePasswordForm button[type="submit"]').prop('disabled', true);
            },
            complete: function () {
                $('#changePasswordForm button[type="submit"]').prop('disabled', false);
            },
            url: $(this).attr('action'),
            type: 'POST',
            dataType: "json",
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                console.log(response)
                if (response.success) {
                    $('#changePasswordModal').modal('hide');
                    window.location.reload();
                }
            },
            error: function (xhr) {
                handleFormErrors(xhr);
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });

    // Submit Edit Form
    $('#form-edit-user-profile').submit(function (event) {
        event.preventDefault();
        const form = this;
        const url = form.getAttribute('action');
        const formData = new FormData(form);

        $.ajax({
            url: url,
            type: 'POST',
            dataType: "json",
            data: formData,
            success: function (response) {
                if (response.success) {
                    modalEditProfile.modal('hide');
                    window.location.reload();
                }
            },
            error: function (xhr) {
                handleFormErrors(xhr);
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });

    // Handle form errors
    function handleFormErrors(xhr) {
        if (xhr.status === 422) {
            const errors = xhr.responseJSON.errors;
            $('.text-danger').remove();  // Remove old error messages

            // Loop through errors and display below the corresponding input field
            for (const [field, messages] of Object.entries(errors)) {
                messages.forEach(message => {
                    $(`input[name="${field}"], select[name="${field}"]`).after(
                        `<div class="text-danger">${message}</div>`
                    );
                });
            }
        } else {
            Notification.showError(xhr.responseJSON.message || 'Đã xảy ra lỗi.');
        }
    }
});
function provinceOnchange (event) {
    var provinceId = event.currentTarget.value
    fetchDistricts(provinceId)
}

function fetchDistricts(provinceId) {
    return new Promise((resolve,reject)=>{
        if (provinceId) {
            $.ajax({
                url: GET_DISTRICT_URL,
                type: 'GET',
                data: { province_id: provinceId },
                success: function (data) {
                    $('#district_id').empty();
                    $('#district_id').append('<option value="">Select District</option>');
                    $.each(data, function (key, district) {
                        console.log(district)
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

function openEditProfileForm(){
    let modalEditProfile = $('#modal-edit-user-profile');

    // Gửi yêu cầu AJAX để lấy dữ liệu và hiển thị modal
    $.ajax({
        url: GET_USER_INFO_URL,
        type: 'GET',
        dataType: "json",
        success: function (response) {
            if (response.success) {
                const data = response.data;
                // Cập nhật dữ liệu vào form
                modalEditProfile.find('input[name="id"]').val(data.id);
                modalEditProfile.find('input[name="full_name"]').val(data.full_name);
                modalEditProfile.find('input[name="email"]').val(data.email);
                modalEditProfile.find('input[name="phone"]').val(data.phone);
                modalEditProfile.find('input[name="address"]').val(data.address);
                // Hiển thị modal
                modalEditProfile.modal('show');
            }
        },
        error: function () {
        }
    });
}


// phần hình ảnh ======================
function showModalUpdateImage(){
    let modal=$('#modal-image');
    modal.find('#image').attr('src','');
    modal.find('#imageInput');
    modal.find('#errorMessage').addClass('hidden')
    modal.modal('show');
}

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
            $('#image').attr('src', e.target.result);
        };
        reader.readAsDataURL(file);
        // Gắn file vào input để chuẩn bị submit
        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);
        fileInput.files = dataTransfer.files;
    } else {
        showError('Please upload an valid Image')
        $('#imageInput').val('');
    }
}
function imageOnchange(event) {
    const file = event.target.files[0];
    // Kiểm tra nếu file không rỗng và MIME type là hình ảnh
    if (file && file.type.startsWith('image/')) {
        const reader = new FileReader();

        reader.onload = function(e) {
            $('#image').attr('src', e.target.result);
        };
        reader.readAsDataURL(file);
    } else {
        showError('Please upload an valid Image')
        $('#imageInput').val('');
    }
}

function prepareSubmit(event){
    event.preventDefault();
    const file = $('#image').attr('src');
    const MAX_FILE_SIZE = 2 * 1024 * 1024; // Giới hạn dung lượng: 2MB
    if (file!=='') {
        // Kiểm tra dung lượng hình ảnh mới
        if ($('#imageInput')[0].files[0].size > MAX_FILE_SIZE) {
            showError('File size exceeds 2MB. Please upload a smaller file.');
            return;
        }
        event.target.submit();
    } else {
        // chưa có hình
       showError('Please upload an Image');
    }
}

function showError(message) {
    let error = $('#errorMessage');
    error.text(message);
    error.removeClass('hidden');
}



//phần hiển thij hình ảnh=======================
const imageLayer = document.getElementById('imageLayer');

// Open the image layer
function openImageLayer(imgSrc) {
    const zoomedImage = document.getElementById('zoomedImage');
    zoomedImage.src = imgSrc;

    imageLayer.classList.remove('hidden');
    setTimeout(() => {
        imageLayer.classList.add('opacity-100'); // Tăng opacity
        imageLayer.firstElementChild.classList.add('scale-100'); // Phóng to từ scale-90 về scale-100
    }, 10); // Nhỏ delay để hiệu ứng hoạt động
}

// Close the image layer
function closeImageLayer() {
    imageLayer.classList.remove('opacity-100'); // Giảm opacity
    imageLayer.firstElementChild.classList.remove('scale-100'); // Thu nhỏ về scale-90

    setTimeout(() => {
        imageLayer.classList.add('hidden');
    }, 300); // Đợi hiệu ứng transition kết thúc trước khi ẩn
}

// Close the image layer on ESC key press
document.addEventListener('keydown', function(event) {
    if (event.key === "Escape" && !imageLayer.classList.contains('hidden')) {
        closeImageLayer();
    }
});
