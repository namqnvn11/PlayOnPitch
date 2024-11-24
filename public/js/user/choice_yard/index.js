document.addEventListener("DOMContentLoaded", () => {
    const tableCells = document.querySelectorAll(".selectable");
    const selectedDisplayTimeSlot = document.getElementById("selected-timeslot");
    const selectedDisplayYard = document.getElementById("selected-yard");

    const dateSelector = document.getElementById('dateSelector');
    const selectedDate = document.getElementById('selectedDate');

    const totalPriceDisplay = document.getElementById("totalPrice");

    let selectedDateValue = null;
    const selectedFields = []; // Danh sách các lựa chọn

    // Xử lý sự kiện click vào các ô trong bảng
    tableCells.forEach((cell) => {
        cell.addEventListener("click", () => {
            const yardName = cell.parentElement.cells[0].textContent.trim();
            const timeSlot = cell.closest("table").querySelector("thead").rows[0].cells[cell.cellIndex].textContent.trim();

            const selection = { yard: yardName, time: timeSlot };

            if (cell.classList.contains("selected")) {
                // Nếu đã chọn, bỏ chọn
                cell.classList.remove("selected");
                const index = selectedFields.findIndex(
                    (item) => item.yard === yardName && item.time === timeSlot
                );
                if (index !== -1) selectedFields.splice(index, 1);
            } else {
                // Nếu chưa chọn, thêm vào danh sách
                cell.classList.add("selected");
                selectedFields.push(selection);
            }

            // Cập nhật thông tin hiển thị
            selectedDisplayTimeSlot.textContent = selectedFields.map((s) => s.time).join(", ");
            selectedDisplayYard.textContent = selectedFields.map((s) => s.yard).join(", ");

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
        fetch('/user/choice_yard/calculate-price', {
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
