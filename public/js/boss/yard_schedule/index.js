// $(document).ready(function () {
//
//     $(document).on('click', '.js-on-create', function () {
//         var _modal = $('#modal-edit');
//         $('#form-data')[0].reset();
//         $('.error-message').remove();
//         _modal.find('h4').text('Detail Yard Schedule');
//         _modal.modal('show');
//         viewYardScheduleDetail({ currentTarget: this });
//     });
// });
//
// function viewYardScheduleDetail(event) {
//     var _modal = $('#modal-edit');
//     var url = event.currentTarget.getAttribute('data-url');
//
//     $('.error-message').remove();
//     $('#form-data')[0].reset();
//     _modal.find('h4').text('Detail Yard Schedule');
//
//     $.ajax({
//         url: url,
//         type: 'GET',
//         dataType: "json",
//         success: function (response) {
//             console.log("API Response:", response);
//             if (response.success) {
//                 var data = response.data;
//
//                 $('input[name="yard_name"]').val(data.yard.yard_name || 'N/A');
//                 $('input[name="reservation_date"]').val(
//                     moment(data.reservation.reservation_date).locale('vi').format('dddd, DD/MM/YYYY') || 'N/A'
//                 );
//                 $('input[name="time_slot"]').val(data.yard_schedule.time_slot || 'N/A');
//                 $('input[name="reservation_status"]').val(data.reservation.reservation_status || 'N/A');
//                 $('input[name="full_name"]').val(data.user.full_name || '0');
//                 $('input[name="phone"]').val(data.user.phone);
//                 $('input[name="email"]').val(data.user.email);
//                 $('input[name="total_price"]').val(
//                     new Intl.NumberFormat('vi-VN').format(data.reservation.total_price || 0)
//                 );
//                 console.log(data.yard.boss.company_name);
//
//                 _modal.modal('show');
//             } else {
//                 Notification.showError(response.message);
//             }
//         },
//         error: function (xhr, status, error) {
//             console.error("AJAX error:", error);
//             Notification.showError("An error occurred while fetching data: " + error);
//         },
//         cache: false,
//         contentType: false,
//         processData: false
//     });
// }


$(document).ready(function() {
    // Khi nhấn vào "Create all yard schedule"
    $('#createAllSchedule').on('click', function(e) {
        e.preventDefault();
        $.ajax({
            url: createAllUrl, // URL từ controller
            method: 'GET',
            success: function(response) {
                Notification.showSuccess(response.message)
            },
            error: function(xhr, status, error) {
                // Xử lý lỗi nếu có
               Notification.showError('some thing went wrong');
            }
        });
    });

    // Khi nhấn vào "Delete all schedule"
    $('#deleteAllSchedule').on('click', function(e) {
        e.preventDefault();
        $.ajax({
            url: deleteAllUrl, // URL từ controller
            method: 'GET',
            success: function(response) {
                if (response.success){
                    Notification.showSuccess(response.message)
                }else {
                    Notification.showError(response.message)
                }
            },
            error: function() {
                Notification.showError('some thing went wrong');
            }
        });
    });

    // Khi nhấn vào "Create this yard schedule"
    $('#createOneSchedule').on('click', function(e) {
        e.preventDefault();
        var yardId = yardIdValue; // yard_id từ Blade
        $.ajax({
            url: createOneUrl + '/' + yardId,
            method: 'GET',
            success: function(response) {
                Notification.showSuccess(response.message)
            },
            error: function(xhr, status, error) {
                Notification.showError('some thing went wrong');
            }
        });
    });

    // Khi nhấn vào "Delete this yard schedule"
    $('#deleteOneSchedule').on('click', function(e) {
        e.preventDefault();
        var yardId = yardIdValue; // yard_id từ Blade
        $.ajax({
            url: deleteOneUrl + '/' + yardId,
            method: 'GET',
            success: function(response) {
                if (response.success){
                    Notification.showSuccess(response.message)
                    setTimeout(() => {
                        window.location.reload();
                    }, 1200);
                }else {
                    Notification.showError(response.message)
                }
            },
            error: function() {
                Notification.showError('some thing went wrong');
            }
        });
    });
});

