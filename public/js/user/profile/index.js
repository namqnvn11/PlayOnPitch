$(document).ready(function () {
    const $modalEdit = $('#modal-edit');
    const $formData = $('#form-data');
    const $formDelete = $('#form-delete');
    const $provinceSelect = $('#province_id');
    const $districtSelect = $('#district_id');
    const $changePasswordForm = $('#changePasswordForm');

    // Hàm submit form chung cho việc lưu và xóa
    function submitForm(formSelector, url, successMessage, errorMessage) {
        $(formSelector).submit(function (e) {
            e.preventDefault();
            const formData = new FormData(this);

            $.ajax({
                url: url,
                type: 'POST',
                dataType: "json",
                data: formData,
                success: function (response) {
                    if (response.success) {
                        Notification.showSuccess(successMessage || response.message);
                        $modalEdit.modal('hide'); // Đóng modal khi lưu thành công
                        setTimeout(() => window.location.reload(), 1200); // Tải lại trang sau khi lưu hoặc xóa thành công
                    } else {
                        Notification.showError(response.message);
                    }
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        // Hiển thị lỗi từ server (lỗi validate)
                        const errors = xhr.responseJSON.errors;
                        $('.error-message').remove(); // Xóa thông báo lỗi cũ
                        for (const [field, messages] of Object.entries(errors)) {
                            messages.forEach(message => {
                                $(`input[name="${field}"], select[name="${field}"]`).after(
                                    `<span class="error-message" style="color: red;">${message}</span>`
                                );
                            });
                        }
                    } else {
                        Notification.showError(xhr);
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });
        });
    }

    // Load Districts on Province Change
    $provinceSelect.on('change', function () {
        const provinceId = $(this).val();
        $districtSelect.empty().append('<option value="">Chọn Huyện</option>');

        if (provinceId) {
            $.ajax({
                url: '/get-districts',
                type: 'GET',
                data: { province_id: provinceId },
                success: function (data) {
                    data.forEach(district => {
                        $districtSelect.append(`<option value="${district.id}">${district.name}</option>`);
                    });
                },
                error: function () {
                    Notification.showError('Lỗi khi lấy dữ liệu huyện.');
                }
            });
        }
    });

    // Open Edit Modal and Load Data
    $(document).on('click', '.js-on-edit', function () {
        const url = $(this).data('url'); // Lấy URL từ thuộc tính data-url của nút

        // Xóa dữ liệu cũ và thiết lập tiêu đề modal
        $formData[0].reset();
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

    // Gọi hàm submit form cho cả hai trường hợp lưu và xóa
    submitForm('#form-data', 'user/profile/update', 'Lưu thành công', 'Lỗi khi lưu dữ liệu');
    submitForm('#form-delete', 'user/profile/delete', 'Xóa thành công', 'Lỗi khi xóa dữ liệu');

    // Submit change password form
    $changePasswordForm.submit(function (e) {
        e.preventDefault(); // Ngừng việc gửi form
        const formData = new FormData(this); // Lấy dữ liệu từ form

        $.ajax({
            beforeSend: function () {
                $('#changePasswordForm button[type="submit"]').prop('disabled', true); // Disable button submit khi gửi
            },
            complete: function () {
                $('#changePasswordForm button[type="submit"]').prop('disabled', false); // Enable lại button khi đã hoàn thành request
            },
            url: $(this).attr('action'), // Đường dẫn gửi yêu cầu (POST)
            type: 'POST',
            dataType: "json",  // Trả về dữ liệu dưới dạng JSON
            data: formData,
            success: function (response) {

                if (response.success) {Notification.showSuccess(response.message)
                    $('#changePasswordModal').modal('hide');  // Đóng modal khi thành công
                }else {
                    Notification.showError(response.message)
                }
            },
            error: function (xhr) {
                if (xhr.status === 422) {

                    const errors = xhr.responseJSON.errors;
                    console.log(errors);
                    $('.text-danger').remove();  // Xóa các thông báo lỗi cũ

                    // Hiển thị thông báo lỗi dưới mỗi input
                    for (const [field, messages] of Object.entries(errors)) {
                        messages.forEach(message => {
                            $(`input[name="${field}"]`).after(
                                `<div class="text-danger">${message}</div>`
                            );
                        });
                    }
                } else {
                    Notification.showError(xhr.message);                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
});
