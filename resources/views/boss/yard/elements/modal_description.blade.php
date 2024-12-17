<div class="modal fade" id="modal-description">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalTitle">Edit your yard description</h4>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$(`#${'modal-description'}`).modal('hide')">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="form-description" onsubmit="handelSubmitDescription(event)">
                @csrf
                <div class="px-4 py-4">
                    <div class="flex flex-col">
                       <label>Description</label>
                        <input type="hidden" id="inputYardDescription" value="{{$currenBoss->description}}">
                        <textarea class="rounded h-[130px]" name="description" placeholder="Enter your yards description" id="yardDescription" ></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default mr-1" data-dismiss="modal" onclick="$(`#${'modal-description'}`).modal('hide')">Close</button>
                    <button type="submit" class="btn btn-danger">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>


