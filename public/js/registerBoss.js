$(document).ready(function () {
    saveData();
})

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

                    $("form#form-data")[0].reset();
                    setTimeout(() => {
                        window.location.reload();
                    }, 1200);
                } else {
                    // Hiển thị lỗi từ server nếu có
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
                        });
                    });

                    // Hiển thị lỗi chung
                    Notification.showError("Please correct the errors in the form.");
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
