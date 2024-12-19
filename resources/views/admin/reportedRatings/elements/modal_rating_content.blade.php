<div class="modal fade" id="modal-rating-content">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalTitle">Rating content</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$(`#${'modal-rating-content'}`).modal('hide')">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <input type="hidden" value="" id="userId">
            <form method="POST" id="form-block">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                       <div id="rating_content" class="w-full text-justify">Bảng này dùng để hiển thị danh sách đánh giá từ người dùng với các cột như Tác giả, Điểm, Bình luận, Thời gian đánh giá và Hành động. Để tạo một checkbox "Chọn tất cả", bạn cần một vài điều chỉnh trong HTML và thêm JavaScript để điều khiển các checkbox. Dưới đây là cách bạn có thể cập nhật mã của mình</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default mr-1" data-dismiss="modal" onclick="$(`#${'modal-rating-content'}`).modal('hide')">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
