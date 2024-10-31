
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
                        <label for="">Full Name</label>
                        <input type="text" name="full_name" class="form-control" placeholder="Enter full name">
                    </div>

                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="text" name="email" class="form-control" placeholder="Enter email">
                    </div>

                    <div class="form-group">
                        <label for="">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Enter password">
                    </div>

                    <div class="form-group">
                        <label for="">Phone</label>
                        <input type="text" name="phone" class="form-control" placeholder="Enter phone number">
                    </div>

                    <div class="form-group">
                        <label for="">Address</label>
                        <input type="text" name="address" class="form-control" placeholder="Enter address">
                    </div>


                    <div class="form-group">
                        <label for="province_id">Province</label>
                        <select class="form-control" name="province_id" id="province_id" required>
                            <option value="">Select Province</option>
                            @foreach($Province as $province)
                                <option value="{{ $province->id }}">{{ $province->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="district_id">District</label>
                        <select class="form-control" name="district_id" id="district_id" required>
                            <option value="">Select District</option>
                        </select>
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
