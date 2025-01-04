<div class="modal fade" id="modal-rating-content">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="text-lg font-bold text-gray-800">About Rating</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$(`#${'modal-rating-content'}`).modal('hide')">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <input type="hidden" value="" id="userId">
            <form method="POST" id="form-block">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                       <div id="rating_content" class="w-full text-justify"></div>
                    </div>
                    <div id="reportList" class="space-y-4"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default mr-1" data-dismiss="modal" onclick="$(`#${'modal-rating-content'}`).modal('hide')">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
