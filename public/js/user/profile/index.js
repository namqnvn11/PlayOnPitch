$(document).ready(function () {
    const $modalEdit = $('#modal-edit');
    const $formData = $('#form-data');
    const $formDelete = $('#form-delete');
    const $provinceSelect = $('#province_id');
    const $districtSelect = $('#district_id');
    const $changePasswordForm = $('#changePasswordForm');

    // Load Districts on Province Change
    $provinceSelect.on('change', function () {
        const provinceId = $(this).val();
        $districtSelect.empty().append('<option value="">Chọn Huyện</option>');

        if (provinceId) {
            $.ajax({
                url: '/user/profile/get-districts',
                type: 'GET',
                data: { province_id: provinceId },
                success: function (data) {
                    if (data.length > 0) {
                        data.forEach(district => {
                            $districtSelect.append(`<option value="${district.id}">${district.name}</option>`);
                        });
                    } else {
                        $districtSelect.append('<option value="">Không có huyện nào</option>');
                    }
                },
                error: function () {
                    Notification.showError('Lỗi khi lấy dữ liệu huyện.');
                }
            });
        }
    });

    // Open Edit Modal and Load Data
    $(document).on('click', '.js-on-edit', function () {
        const url = $(this).data('url');
        $('#form-data')[0].reset();
        $modalEdit.find('h4').text('Chỉnh sửa');

        // Gửi yêu cầu AJAX để lấy dữ liệu và hiển thị modal
        $.ajax({
            url: url,
            type: 'GET',
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    const data = response.data;

                    // Cập nhật dữ liệu vào form
                    $formData.find('input[name="id"]').val(data.id);
                    $formData.find('input[name="full_name"]').val(data.full_name);
                    $formData.find('input[name="email"]').val(data.email);
                    $formData.find('input[name="phone"]').val(data.phone);
                    $formData.find('input[name="address"]').val(data.address);
                    $('#district_id').val(data.district_id); // Cập nhật district_id nếu có

                    // Hiển thị modal
                    $modalEdit.modal('show');
                } else {
                    Notification.showError(response.message);
                }
            },
            error: function () {
                Notification.showError('Lỗi khi lấy dữ liệu người dùng.');
            }
        });
    });

    // Submit Change Password Form
    $changePasswordForm.submit(function (e) {
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
                if (response.success) {
                    Notification.showSuccess(response.message);
                    $('#changePasswordModal').modal('hide');
                    setTimeout(function () {
                        window.location.href = '/user/profile/index';
                    }, 1200);
                } else {
                    Notification.showError(response.message || 'Đã xảy ra lỗi.');
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
    $('#form-edit').submit(function (event) {
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
                    Notification.showSuccess(response.message);
                    $modalEdit.modal('hide');
                    setTimeout(function () {
                        window.location.reload();
                    }, 1200);
                } else {
                    Notification.showError(response.message);
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
