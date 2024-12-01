document.addEventListener('DOMContentLoaded', function () {
    const items = document.querySelectorAll('.booking-item'); // Lấy tất cả các mục
    const showMoreBtn = document.getElementById('showMoreBtn'); // Nút "Xem thêm"
    const itemsPerPage = 3; // Số lượng mục hiển thị ban đầu
    let visibleCount = itemsPerPage;

    // Hiển thị ban đầu
    function showItems() {
        items.forEach((item, index) => {
            if (index < visibleCount) {
                item.classList.add('visible'); // Thêm class để hiển thị
            } else {
                item.classList.remove('visible'); // Ẩn các mục còn lại
            }
        });

        // Ẩn nút "Xem thêm" nếu không còn mục nào để hiển thị
        if (visibleCount >= items.length) {
            showMoreBtn.style.display = 'none';
        }
    }

    // Xử lý khi nhấn "Xem thêm"
    showMoreBtn.addEventListener('click', function () {
        visibleCount += itemsPerPage; // Tăng số lượng mục hiển thị
        showItems(); // Cập nhật hiển thị
    });

    // Hiển thị 3 mục đầu tiên khi tải trang
    showItems();
});
