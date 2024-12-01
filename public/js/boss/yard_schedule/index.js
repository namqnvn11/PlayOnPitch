$(document).ready(function () {

    $(document).on('click', '.js-on-create', function () {
        var _modal = $('#modal-edit');
        $('#form-data')[0].reset();
        $('.error-message').remove();
        _modal.find('h4').text('Detail Yard Schedule');
        _modal.modal('show');
        viewYardScheduleDetail({ currentTarget: this });
    });
});

function viewYardScheduleDetail(event) {
    var _modal = $('#modal-edit');
    var url = event.currentTarget.getAttribute('data-url');

    $('.error-message').remove();
    $('#form-data')[0].reset();
    _modal.find('h4').text('Detail Yard Schedule');

    $.ajax({
        url: url,
        type: 'GET',
        dataType: "json",
        success: function (response) {
            console.log("API Response:", response); // Log dữ liệu API trả về
            if (response.success) {
                var data = response.data;

                // Điền dữ liệu vào các input trong modal
                $('input[name="yard_name"]').val(data.yard.yard_name || 'N/A');
                $('input[name="reservation_date"]').val(
                    moment(data.reservation.reservation_date).locale('vi').format('dddd, DD/MM/YYYY') || 'N/A'
                );
                $('input[name="reservation_time_slot"]').val(data.reservation.reservation_time_slot || 'N/A');
                $('input[name="reservation_status"]').val(data.reservation.reservation_status || 'N/A');
                $('input[name="full_name"]').val(data.user.full_name || '0');
                $('input[name="phone"]').val(data.user.phone);
                $('input[name="email"]').val(data.user.email);
                $('input[name="total_price"]').val(
                    new Intl.NumberFormat('vi-VN').format(data.reservation.total_price || 0)
                );
                // $('input[name="email"]').val(data.time_slot);
                console.log(data.yard.boss.company_name);

                // Hiển thị modal
                _modal.modal('show');
            } else {
                Notification.showError(response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error("AJAX error:", error);
            Notification.showError("An error occurred while fetching data: " + error);
        },
        cache: false,
        contentType: false,
        processData: false
    });
}
