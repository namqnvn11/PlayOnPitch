
<div class="modal fade" id="modal-edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ 'Detail Yard Schedule' }}</h4>
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
                        <input type="text" name="yard_name" class="form-control" placeholder="Yard Name" readonly>
                    </div>

                    <div class="form-group">
                        <label for="reservation_date">Reservation Date</label>
                        <input type="text" name="reservation_date" class="form-control" placeholder="Reservation Date" readonly>
                    </div>

                    <div class="form-group">
                        <label for="time_slot">Reservation Time Slot</label>
                        <input type="text" name="time_slot" class="form-control" placeholder="Time Slot" readonly>
                    </div>

                    <div class="form-group">
                        <label for="reservation_status">Status</label>
                        <input type="text" name="reservation_status" class="form-control" placeholder="Status" readonly>
                    </div>

                    <div class="form-group">
                        <label for="full_name">Name</label>
                        <input type="text" name="full_name" class="form-control" placeholder="Name" readonly>
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" name="phone" class="form-control" placeholder="Phone" readonly>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" name="email" class="form-control" placeholder="Email" readonly>
                    </div>

                    <div class="form-group">
                        <label for="total_price">Total Amount</label>
                        <input type="text" name="total_price" class="form-control" placeholder="Total Amount" readonly>
                    </div>

                    <div class="form-group">
                        <label for="email">Paid</label>
                        <input type="text" name="email" class="form-control" placeholder="Paid" readonly>
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
