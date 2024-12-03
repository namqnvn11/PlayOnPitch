document.addEventListener('DOMContentLoaded', function() {
    const selectableCells = document.querySelectorAll('.selectable');
    document.getElementById('totalPrice-hidden').value=0;

    selectableCells.forEach(cell => {
        cell.addEventListener('click', function() {
            // Lấy dữ liệu từ ô được click
            const scheduleId = this.getAttribute('scheduleId');
            const timeSlot = this.getAttribute('timeSlot');
            const date = this.getAttribute('date');
            const price =  this.getAttribute('price');
            const selectedYard =  this.getAttribute('yard');

            // Cập nhật các phần tử trên trang
            document.getElementById('scheduleId').value = scheduleId;
            document.getElementById('selected-timeslot').innerText = timeSlot;
            document.getElementById('totalPrice').innerText = price + ' đ';
            document.getElementById('selectedDate').innerText = 'Ngày: ' + date;
            document.getElementById('selected-yard').innerText = 'Sân: ' + selectedYard;
            document.getElementById('totalPrice-hidden').value=price;
            selectableCells.forEach(c => c.classList.remove('active'));
            this.classList.add('active');
            //xóa thoong báo lỗi nếu có
            clearError();
        });
    });
});


// hàm thay lựa chọn ngày để chọn đặt sân
function ChangeSelectTime(thisSelect) {
    // Lấy giá trị được chọn từ select
    let time = thisSelect.value;

    // Lấy phần tử form cần thay đổi
    let form = document.getElementById('selectedTime');

    // Thay đổi URL trong thuộc tính 'action' của form hoặc 'src' nếu đó là iframe/image
    form.setAttribute('src', CHOICE_YARD_INDEX_URL + "?selectTime=" + time);
    form.submit();
}

//hàm chặn submit nếu chưa đủ thông tin
function preparePayment(event){
    event.preventDefault();
    const userName = document.getElementById('userName').value.trim();
    const phone = document.getElementById('userPhone').value.trim();
    const totalPrice = document.getElementById('totalPrice-hidden').value.trim();
    const errorElement= document.getElementById('errorText');

    // Kiểm tra nếu input rỗng
    if (!userName || !phone) {
        errorElement.innerText='Vui lòng nhập đầy đủ thông tin liên hệ';
        return;
    }
    if (totalPrice==='0'){
        errorElement.innerText='Vui lòng thời gian muốn đặt sân';
        return;
    }
    // Nếu muốn kiểm tra thêm điều kiện khác (vd: số điện thoại hợp lệ)
    const phoneRegex = /^[0-9]{10}$/; // Ví dụ: số điện thoại có 10 chữ số
    if (!phoneRegex.test(phone)) {
        errorElement.innerText='Vui lòng nhập số điện thoại hợp lệ';
        return;
    }

    event.target.submit();
}

function clearError(){
    document.getElementById('errorText').innerText='';
}
