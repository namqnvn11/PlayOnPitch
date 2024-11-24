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
                    Notification.showError(response.message);
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;

                    $('.error-message').remove();

                    $.each(errors, function(field, messages) {
                        messages.forEach(function(message) {
                            $(`input[name="${field}"]`).after(`<span class="error-message" style="color: red;">${message}</span>`);
                        });
                    });

                    Notification.showError("Please correct the errors in the form.");
                } else {
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
