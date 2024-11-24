<div class="modal fade" id="modal-confirm-reset-password">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalTitle">Reset Password</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$(`#${'modal-confirm-reset-password'}`).modal('hide')">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <input type="hidden" value="" id="resetPasswordUserId">
            <form method="POST" id="form-reset-password">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="" id="confirmLabel">Are you sure you want to reset password of this User?</label>
                    </div>
                    <div class="form-group">
                        <label for="">New Password</label>
                        <input type="text" name="new_password" class="form-control rounded-md border-gray-400" placeholder="Enter password" id="new_password" value="12345678">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default mr-1" data-dismiss="modal" onclick="$(`#${'modal-confirm-reset-password'}`).modal('hide')">Close</button>
                    <button type="submit" class="btn btn-danger" onclick="resetPassword(event)">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>
