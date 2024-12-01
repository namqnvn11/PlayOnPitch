document.addEventListener("DOMContentLoaded", () => {
    const tableCells = document.querySelectorAll(".selectable");
    const selectedDisplayTimeSlot = document.getElementById("selected-timeslot");
    const selectedDisplayYard = document.getElementById("selected-yard");

    const dateSelector = document.getElementById('dateSelector');
    const selectedDate = document.getElementById('selectedDate');

    const totalPriceDisplay = document.getElementById("totalPrice");

    let selectedDateValue = null;
    const selectedFields = []; // Danh sách các lựa chọn

    const currentDate = new Date(); // Lấy thời gian hiện tại
    const timeSlots = document.querySelectorAll('.booking-table1 tbody tr td');
    timeSlots.forEach(cell => {
        const timeSlotText = cell.textContent.trim(); // Giả sử text trong cell là định dạng "HH:mm"
        if (timeSlotText) {
            const [hours, minutes] = timeSlotText.split(':').map(Number);
            const slotTime = new Date();
            slotTime.setHours(hours, minutes, 0, 0); // Thiết lập giờ và phút từ text

            // Nếu thời gian slot đã qua, áp dụng lớp CSS
            if (slotTime < currentDate) {
                cell.classList.add('past-time');
            }
        }
    });
    
    // Xử lý sự kiện click vào các ô trong bảng
    tableCells.forEach((cell) => {
        if (cell.classList.contains("disabled")) return; // Bỏ qua các ô đã bị disable

        cell.addEventListener("click", () => {
            const yardName = cell.parentElement.cells[0].textContent.trim();
            const timeSlot = cell.closest("table").querySelector("thead").rows[0].cells[cell.cellIndex].textContent.trim();

            // Kiểm tra nếu ô đã được chọn
            if (cell.classList.contains("selected")) {
                // Nếu đã chọn, bỏ chọn
                cell.classList.remove("selected");
                selectedFields.length = 0; // Xóa tất cả lựa chọn khỏi danh sách
            } else {
                // Nếu chưa chọn, bỏ chọn các ô khác
                tableCells.forEach((otherCell) => otherCell.classList.remove("selected"));
                cell.classList.add("selected");

                // Cập nhật danh sách chỉ với lựa chọn hiện tại
                selectedFields.length = 0; // Xóa danh sách cũ
                selectedFields.push({ yard: yardName, time: timeSlot });
            }

            // Cập nhật thông tin hiển thị
            if (selectedFields.length > 0) {
                const { yard, time } = selectedFields[0];
                selectedDisplayTimeSlot.textContent = time;
                selectedDisplayYard.textContent = yard;
            } else {
                selectedDisplayTimeSlot.textContent = "";
                selectedDisplayYard.textContent = "";
            }

            // Cập nhật giá trị cho input hidden
            document.getElementById('selected-timeslot-input').value = selectedFields.map((s) => s.time).join(", ");

            // Tính lại giá
            calculatePrice(selectedDateValue, selectedFields);
        });
    });

    // Xử lý sự kiện khi chọn ngày
    dateSelector.addEventListener('change', () => {
        const selectedOption = dateSelector.value;
        if (selectedOption) {
            selectedDate.textContent = `${selectedOption}`;
            selectedDateValue = selectedOption; // Lưu giá trị ngày đã chọn
        } else {
            selectedDate.textContent = "Ngày bạn chọn: chưa chọn ngày";
            selectedDateValue = null;
        }

        // Tính lại giá
        calculatePrice(selectedDateValue, selectedFields);
    });

    // Hàm tính giá tiền
    function calculatePrice(selectedDate, fields) {
        if (!selectedDate || fields.length === 0) {
            totalPriceDisplay.textContent = "Chưa đủ thông tin để tính tiền";
            return;
        }

        // Gửi request AJAX tính tổng tiền
        fetch('/user/choice_yard/calculate-price/{id}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                selected_date: selectedDate,
                fields: fields
            })
        })
            .then(response => response.json())
            .then(data => {
                // Cập nhật giá tiền
                if (data.totalPrice !== null) {
                    const formattedPrice = parseFloat(data.totalPrice).toLocaleString(); // Chuyển số thành chuỗi có dấu phân cách
                    totalPriceDisplay.textContent = `${formattedPrice} đ`;

                    document.getElementById('totalPrice-hidden').value = data.totalPrice;
                } else {
                    totalPriceDisplay.textContent = "Không thể tính tiền";
                }
            })
            .catch(error => {
                console.error('Có lỗi xảy ra khi tính giá:', error);
                totalPriceDisplay.textContent = "Có lỗi xảy ra khi tính tiền";
            });
    }
});
