<div class="modal fade" id="modal-image">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalTitle">Change Your Avatar</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$(`#${'modal-image'}`).modal('hide')">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <input type="hidden" id="voucherId">
            <form method="POST" id="form-image" enctype="multipart/form-data" onsubmit="prepareSubmit(event)" action="{{url('/user/profile/image-upload')}}">
                @csrf
                <div class="modal-body flex flex-col">
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
                                <img id="image" width="200" class="rounded" />
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
                    <div id="errorMessage" class="text-red-500 mt-2 ml-2 flex hidden">error</div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default mr-1 border hover:bg-gray-100 text-xs font-bold py-[10px] text-gray-500" data-dismiss="modal" onclick="$(`#${'modal-image'}`).modal('hide')" >CLOSE</button>
                    <x-green-button type="submit" class="btn">Confirm</x-green-button>
                </div>
            </form>
        </div>
    </div>
</div>
