document.addEventListener('DOMContentLoaded', function () {
    const selectableCells = document.querySelectorAll('.selectable');
    const totalPriceHidden = document.getElementById('totalPrice-hidden');
    const selectedTimeSlots = document.getElementById('selected-timeslot');
    const totalPrice = document.getElementById('totalPrice');
    const selectedDate = document.getElementById('selectedDate');
    const selectedYard = document.getElementById('selected-yard');
    const scheduleListContainer = document.getElementById('scheduleListContainer');
    let selectedCells = []; // Lưu trữ các ô được chọn

    function updateSelection() {
        scheduleListContainer.innerHTML = '';
        let total = 0;
        let timeSlots = [];
        let yards = new Set(); // Đảm bảo không bị trùng sân
        let dates = new Set(); // Đảm bảo không bị trùng ngày

        selectedCells.forEach(cell => {
            const timeSlot = cell.getAttribute('timeSlot');
            const price = parseInt(cell.getAttribute('price'), 10);
            const yard = cell.getAttribute('yard');
            const date = cell.getAttribute('date');
            const scheduleId= cell.getAttribute('scheduleId');


            // theem input cho scheduleId
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'scheduleIds[]';
            hiddenInput.value = scheduleId;
            scheduleListContainer.appendChild(hiddenInput);

            total += price;
            timeSlots.push(timeSlot);
            yards.add(yard);
            dates.add(date);
        });

        // Cập nhật giao diện
        totalPrice.innerText = total.toLocaleString();
        selectedTimeSlots.innerText = timeSlots.join(', ');
        selectedDate.innerText = 'Day: ' + Array.from(dates).join(', ');
        selectedYard.innerText = 'Yards: ' + Array.from(yards).join(', ');
        totalPriceHidden.value = total;
    }

    selectableCells.forEach(cell => {
        cell.addEventListener('click', function () {
            const index = selectedCells.indexOf(this);

            if (index === -1) {
                // Thêm ô vào danh sách được chọn
                selectedCells.push(this);
                this.classList.add('active');
            } else {
                // Bỏ chọn ô
                selectedCells.splice(index, 1);
                this.classList.remove('active');
            }

            updateSelection();
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
        errorElement.innerText='Please enter full contact information';
        return;
    }
    if (totalPrice==='0'){
        errorElement.innerText='Please take the time to reserve';
        return;
    }
    // Nếu muốn kiểm tra thêm điều kiện khác (vd: số điện thoại hợp lệ)
    const phoneRegex = /^[0-9]{10}$/; // Ví dụ: số điện thoại có 10 chữ số
    if (!phoneRegex.test(phone)) {
        errorElement.innerText='Please enter a valid phone number';
        return;
    }

    event.target.submit();
}

function clearError(){
    document.getElementById('errorText').innerText='';
}
