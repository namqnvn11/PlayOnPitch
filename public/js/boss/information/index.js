
$(document).ready(function () {
    $('#province').on('change', function () {
        var provinceId = $(this).val();
        fetchDistricts(provinceId)
    });
});

function fetchDistricts(provinceId) {
    return new Promise((resolve,reject)=>{
        if (provinceId) {
            $.ajax({
                url: GET_DISTRICTS_URL,
                type: 'GET',
                data: { province_id: provinceId },
                success: function (data) {
                    $('#district').empty();
                    $('#district').append('<option value="">Select District</option>');
                    $.each(data, function (key, district) {
                        $('#district').append('<option value="' + district.id + '">' + district.name + '</option>');
                    });
                    resolve();
                },
                error: function () {
                    Notification.showError('Error when retrieving district data.');
                    reject();
                }
            });
        } else {
            $('#district').empty();
            $('#district').append('<option value="">Select District</option>');
        }
    })
}

function handleUpdateInformation(event) {
    event.preventDefault();
    const form = document.getElementById('information-form');
    const formData = new FormData(form);
    $.ajax({
        url: UPDATE_INFORMATION_URL,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            if (response.success){
                Notification.showSuccess(response.message)
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            }
        },
        error: function(xhr) {
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;

                $.each(errors, function(field, messages) {
                    messages.forEach(function(message) {
                       Notification.showError(message)
                    });
                });
            } else {
                Notification.showError("An error occurred: " + xhr.statusText);
            }
        },
    });

}


function  handleUpdateBossPassword(event){
    event.preventDefault();
    const form = document.getElementById('password-update-form');
    const formData = new FormData(form);
    const inputs = form.querySelectorAll('input');


    $.ajax({
        url: UPDATE_PASSWORD_URL,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            if (response.success){
                Notification.showSuccess(response.message)
                //xóa giá trị các input
                inputs.forEach((input,index) => {
                    if (index===0) {
                        return
                    }
                    input.value = '';
                });
            }
        },
        error: function(xhr) {
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;

                $.each(errors, function(field, messages) {
                    messages.forEach(function(message) {
                        Notification.showError(message)
                    });
                });
            } else {
                Notification.showError("An error occurred: " + xhr.statusText);
            }
        },
    });
}
