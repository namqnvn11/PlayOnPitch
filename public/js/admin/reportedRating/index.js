function toggleAll(source) {
    var checkboxes = document.querySelectorAll('#check-item');
    for (var i = 0; i < checkboxes.length; i++) {
    checkboxes[i].checked = source.checked;
}
}
document.addEventListener("DOMContentLoaded", function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
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
