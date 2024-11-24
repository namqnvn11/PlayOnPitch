<div class="modal fade" id="modal-confirm">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalTitle">Block Voucher</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$(`#${'modal-confirm'}`).modal('hide')">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <input type="hidden" value="" id="voucherId">
            <form method="POST" id="form-block">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="" id="confirmLabel">Are you sure you want to block this voucher?</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default mr-1" data-dismiss="modal" onclick="$(`#${'modal-confirm'}`).modal('hide')" >Close</button>
                    <button type="submit" class="btn btn-danger" onclick="blockUnBlockSubmit(event)">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>
