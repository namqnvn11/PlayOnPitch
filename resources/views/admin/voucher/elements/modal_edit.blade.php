
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
                        <label for="name">Name</label>
                        <select name="name" id="name" class="form-control rounded-md border-gray-400">
                            <option value="">Select name</option>
                            <option value="Giảm giá 100% tối đa 10.000" data-price="10000">Giảm giá 100% tối đa 10.000</option>
                            <option value="Giảm giá 100% tối đa 20.000" data-price="20000">Giảm giá 100% tối đa 20.000</option>
                            <option value="Giảm giá 100% tối đa 30.000" data-price="30000">Giảm giá 100% tối đa 30.000</option>
                            <option value="Giảm giá 100% tối đa 40.000" data-price="40000">Giảm giá 100% tối đa 40.000</option>
                            <option value="Giảm giá 100% tối đa 50.000" data-price="50000">Giảm giá 100% tối đa 50.000</option>
                            <option value="Giảm giá 100% tối đa 60.000" data-price="60000">Giảm giá 100% tối đa 60.000</option>
                            <option value="Giảm giá 100% tối đa 70.000" data-price="70000">Giảm giá 100% tối đa 70.000</option>
                            <option value="Giảm giá 100% tối đa 80.000" data-price="80000">Giảm giá 100% tối đa 80.000</option>
                            <option value="Giảm giá 100% tối đa 90.000" data-price="90000">Giảm giá 100% tối đa 90.000</option>
                            <option value="Giảm giá 100% tối đa 100.000" data-price="100000">Giảm giá 100% tối đa 100.000</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" name="price" id="price" class="form-control rounded-md border-gray-400" placeholder="Enter price" readonly>
                    </div>

                    <div class="form-group">
                        <label for="release_date">Release Date</label>
                        <input type="date" name="release_date" class="form-control rounded-md border-gray-400" placeholder="Enter release date">
                    </div>

                    <div class="form-group">
                        <label for="end_date">End Date</label>
                        <input type="date" name="end_date" class="form-control rounded-md border-gray-400" placeholder="Enter end date">
                    </div>

                    <div class="form-group">
                        <label for="conditions_apply">Conditions Apply</label>
                        <input type="number" name="conditions_apply" id="conditions_apply" class="form-control rounded-md border-gray-400" placeholder="Enter conditions apply" readonly>
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

