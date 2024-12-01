<!-- Modal Hóa đơn -->
<div id="invoice-modal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Hóa đơn chi tiết</h2>
        <div class="invoice-details">
            <p><strong>Sân:</strong> <span>{{ $yard->boss->company_name }}</span></p>
            <p><strong>Địa chỉ:</strong> <span>{{ $yard->boss->company_address }}</span></p>
            <p><strong>Vị trí:</strong> <span>{{ $yard->yard_name }}</span></p>
            <p><strong>Thời gian:</strong> <span>18h00 ngày 21 tháng 10 năm 2024</span></p>
            <p><strong>Trạng thái:</strong> <span>Đã cọc 20%</span></p>

            <hr>

            <p><strong>Người đặt:</strong> <span>{{ Auth::user()->full_name }}</span></p>
            <p><strong>Số điện thoại:</strong> <span>{{ Auth::user()->phone }}</span></p>
            <p><strong>Email:</strong> <span>{{ Auth::user()->email }}</span></p>

            <hr>

            <p><strong>Tổng tiền:</strong> <span>600.000đ</span></p>
            <p><strong>Đã cọc:</strong> <span>120.000đ</span></p>

            <button id="btn-print-invoice" class="btn btn-primary">Xuất hóa đơn</button>
        </div>
    </div>
</div>
