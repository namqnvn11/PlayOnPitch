<div class="modal fade" id="modal-confirm">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalTitle"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <input type="hidden" value="" id="yardId">
            <form method="POST" id="form-block">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="" id="confirmLabel"></label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default mr-1" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger" onclick="blockUnBlockSubmit(event)">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>