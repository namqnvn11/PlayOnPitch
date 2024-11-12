
<div class="modal fade" id="modal-edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ 'Add new' }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>


            <form method="post" id="form-data" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id">

                <div class="modal-body">

                    <div class="form-group">
                        <label for="">Tên</label>
                        <input type="number" name="name" class="form-control" placeholder="Enter price">
                    </div>

                    <div class="form-group">
                        <label for="">Số điện thoại</label>
                        <input type="date" name="phone" class="form-control" placeholder="Enter release date">
                    </div>

                    <div class="form-group">
                        <label for="">Địa chỉ</label>
                        <input type="date" name="address" class="form-control" placeholder="Enter end date">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default mr-1" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
