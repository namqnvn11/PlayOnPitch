
<div class="modal fade" id="modal-edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ 'Add new' }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$(`#${'modal-edit'}`).modal('hide')">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>


            <form method="post" id="form-data" enctype="multipart/form-data">
                @csrf
                @flasher_render
                <input type="hidden" name="id" id="id">

                <div class="modal-body">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" name="email" id="email" class="form-control rounded-md border-gray-400" placeholder="Enter email">

                    </div>

                    <div class="form-group" id="password_group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control rounded-md border-gray-400" placeholder="Enter password">

                    </div>

                    <div class="form-group">
                        <label for="full_name">Full Name</label>
                        <input type="text" name="full_name" id="full_name" class="form-control rounded-md border-gray-400" placeholder="Enter full name">

                    </div>

                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" name="phone" id="phone" class="form-control rounded-md border-gray-400" placeholder="Enter phone">
                    </div>

                    <div class="form-group">
                        <label for="company_name">Company Name</label>
                        <input type="text" name="company_name" id="company_name" class="form-control rounded-md border-gray-400" placeholder="Enter company name">
                    </div>

                    <div class="form-group">
                        <label for="company_address">Company Address</label>
                        <input type="text" name="company_address" id="company_address" class="form-control rounded-md border-gray-400" placeholder="Enter company address">
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control rounded-md" name="status" id="status">
                            <option value="">Select status</option>
                            <option value="0">Cũ</option>
                            <option value="1">Mới</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="province">Province</label>
                        <select class="form-control rounded-md" name="province" id="province">
                            <option value="">Select Province</option>
                            @foreach($Province as $province)
                                <option value="{{ $province->id }}">{{ $province->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="district">District</label>
                        <select class="form-control rounded-md" name="district" id="district">
                            <option value="">Select District</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default mr-1" data-dismiss="modal" onclick="$(`#${'modal-edit'}`).modal('hide')">Close</button>
                    <x-green-button type="submit" class="">Save</x-green-button>
                </div>
            </form>
        </div>
    </div>
</div>
