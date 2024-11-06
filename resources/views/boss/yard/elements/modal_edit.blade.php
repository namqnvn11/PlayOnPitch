
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
                @flasher_render
                <input type="hidden" name="id">

                <div class="modal-body">

                    <div class="form-group">
                        <label for="yard_name">Yard Name</label>
                        <select class="form-control" name="yard_name">
                            <option value="">Select Yard Name</option>
                            <option value="Sân số 1">Sân số 1</option>
                            <option value="Sân số 2">Sân số 2</option>
                            <option value="Sân số 3">Sân số 3</option>
                            <option value="Sân số 4">Sân số 4</option>
                            <option value="Sân số 5">Sân số 5</option>
                            <option value="Sân số 6">Sân số 6</option>
                            <option value="Sân số 7">Sân số 7</option>
                            <option value="Sân số 8">Sân số 8</option>
                            <option value="Sân số 9">Sân số 9</option>
                            <option value="Sân số 10">Sân số 10</option>
                        </select>

                    </div>

                    <div class="form-group">
                        <label for="yard_type">Yard Type</label>
                        <select class="form-control" name="yard_type">
                            <option value="">Select Yard Type</option>
                            <option value="sân 5">Sân 5</option>
                            <option value="sân 7">Sân 7</option>
                            <option value="sân 11">Sân 11</option>
                        </select>

                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <input type="text" name="description" class="form-control" placeholder="Enter Description">

                    </div>

                    <div class="form-group">
                        <label for="province_id">Province</label>
                        <select class="form-control" name="province_id" id="province_id">
                            <option value="">Select Province</option>
                            @foreach($Province as $province)
                                <option value="{{ $province->id }}">{{ $province->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="district_id">District</label>
                        <select class="form-control" name="district_id" id="district_id">
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
