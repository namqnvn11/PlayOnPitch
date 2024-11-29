<div class="modal fade" id="modal-image">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalTitle">Voucher Image</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$(`#${'modal-image'}`).modal('hide')">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <input type="hidden" id="voucherId">
            <form method="POST" id="form-image" onsubmit="prepareSubmit(event)" enctype="multipart/form-data">
                @csrf
                <div class="modal-body flex">
                    <div class="form-group w-full px-2 mb-0">
                        <div
                            id="dropZone"
                            class="w-full rounded border-dashed border-[1px] border-green-600 p-4 text-center cursor-pointer"
                            ondragover="handleDragOver(event)"
                            ondrop="handleDrop(event)"
                            onclick="document.getElementById('imageInput').click()"
                        >
                            <i class="bi bi-cloud-arrow-up text-[26px]"></i><br>
                            <p>Drag and drop images here or click to select</p>
                            <div class="w-full flex items-center justify-center mt-3">
                                <img id="oldImg" width="200" class="rounded" />
                            </div>
                        </div>
                        <input
                            type="file"
                            name="image"
                            id="imageInput"
                            class="hidden"
                            onchange="imageOnchange(event)"
                        >
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default mr-1" data-dismiss="modal" onclick="$(`#${'modal-image'}`).modal('hide')" >Close</button>
                    <button type="submit" class="btn btn-danger">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>
