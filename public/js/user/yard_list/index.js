$(document).ready(function () {

    $('#province_id').on('change', function () {
        var provinceId = $(this).val();
        if (provinceId) {
            $.ajax({
                url: getDistrictsUrl,
                type: 'GET',
                data: { province_id: provinceId },
                success: function (data) {
                    console.log(data);
                    $('#district_id').empty();
                    $('#district_id').append('<option value="">Quận/Huyện</option>');
                    $.each(data, function (key, district) {
                        $('#district_id').append('<option value="' + district.id + '">' + district.name + '</option>');
                    });
                    $('#district_id').prop('disabled', false);
                },

                error: function () {
                    Notification.showError('Error when retrieving district data.');
                }
            });
        } else {
            $('#district_id').empty();
            $('#district_id').append('<option value="">Quận/Huyện</option>');

            $('#district_id').prop('disabled', true);
        }
    });
});
