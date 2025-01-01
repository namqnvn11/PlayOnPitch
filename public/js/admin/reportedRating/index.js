function toggleAll(source) {
    var checkboxes = document.querySelectorAll('#check-item');
    for (var i = 0; i < checkboxes.length; i++) {
    checkboxes[i].checked = source.checked;
}
}
document.addEventListener("DOMContentLoaded", function() {
    var checkAllElement= document.getElementById('checkAll');
    checkAllElement.checked=false;

    const checkboxes = document.querySelectorAll('#check-item');
    checkboxes.forEach((checkbox)=>{
        checkbox.checked=false;
    })

    function areAllChecked(checkboxes) {
        for (const checkbox of checkboxes) {
            if (!checkbox.checked) {
                return false;
            }
        }
        return true;
    }

    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            if (checkbox.checked){
                let isAllCheck= areAllChecked(checkboxes);
                if (isAllCheck){
                    checkAllElement.checked=true;
                }
            }else {
                checkAllElement.checked=false;
            }
        });
    });


});


function submitBlock() {
    ajaxSubmit('block');
}

function submitUnblock() {
    ajaxSubmit('unblock');
}

function ajaxSubmit(actionType) {
    let url = actionType === 'block' ? BLOCK_RATING : UNBLOCK_RATING;
    let data = $('#reported-rating-form').serialize();

    $.ajax({
        type: 'POST',
        url: url,
        data: data,
        success: function(response) {
            if (response.success){
                Notification.showSuccess(response.message);
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            }else {
                Notification.showError(response.message)
            }
        },
        error: function(error) {
            // Handle error
            alert('Error: ' + error.responseJSON.message);
        }
    });
}

function showContentModal(ratingId,text){
    let modal=$('#modal-rating-content');
    modal.find('#rating_content').text(text);
    //fetch dữ liệu
    let url = GET_REPORTS_URL +'/'+ratingId;
    $.ajax({
        url: url,
        type: 'get',
        dataType: "json",
        success: function(response) {
            if (response.success) {
                let groupedReports = response.groupedReports;
                let htmlContent = '';

                for (const userId in groupedReports) {
                    const data = groupedReports[userId];
                    let commentsHtml = '';

                    // Duyệt qua danh sách reports của từng user và tạo nội dung
                    data.reports.forEach(report => {
                        commentsHtml += `
                                          <div class="flex">
                                             <i class="bi bi-arrow-return-right"></i>
                                             <div class="ml-2">
                                                <div class="text-gray-700">${report.comment}</div>
                                                <div class="text-sm text-gray-500">${formatDateTime(report.created_at)}</div>
                                             </div>
                                          </div>
                         `;
                    });

                    // Tạo HTML cho từng user
                    htmlContent += `
                    <div class="border-t pt-2">
                       <div class="form-group space-y-2">
                            <div id="userName" class="text-lg font-semibold text-gray-800"><i class="bi bi-person"></i> ${data.user.full_name}</div>
                            <div id="comments-container" class="space-y-2">
                                ${commentsHtml}
                            </div>
                        </div>
                    </div>
                `;
                }

                // Gắn nội dung HTML vào phần tử cha
                $('#reportList').html(htmlContent);
                modal.modal('show');
            } else {
                Notification.showError(response.message);
            }
        },
        error: function(xhr) {
            if (xhr) {
                Notification.showError("An error occurred: " + xhr.statusText);
            }
        },
        cache: false,
        contentType: false,
        processData: false
    });

}

function formatDateTime(isoString) {
    const date = new Date(isoString);

    // Lấy giờ, phút, ngày, tháng, năm
    const hours = date.getHours().toString().padStart(2, '0');
    const minutes = date.getMinutes().toString().padStart(2, '0');
    const day = date.getDate().toString().padStart(2, '0');
    const month = (date.getMonth() + 1).toString().padStart(2, '0'); // Tháng bắt đầu từ 0
    const year = date.getFullYear();

    // Định dạng thành "HH:mm DD/MM/YYYY"
    return `${hours}:${minutes} ${day}/${month}/${year}`;
}
