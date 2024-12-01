@extends("layouts.appboss")
@section('title', $title ?? 'Images')
@section("content")
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Images</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Admin</a></li>
                        <li class="breadcrumb-item active">{{ $title ?? 'Images' }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="bg-gray-100 p-6 min-h-screen">

                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                                <!-- Card hình ảnh -->
                                @foreach($images as $image)
                                    <div class="group relative" id="imgGroup">
                                        <div class="rounded-lg shadow overflow-hidden h-60">
                                            <img
                                                src="{{$image->img}}"
                                                alt="Hình ảnh"
                                                class="w-full h-full object-cover group-hover:opacity-75 transition border-gray-700"
                                            >
                                            <!-- Overlay -->
                                            <div
                                                class="absolute inset-0 bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300">
                                                {{--nút update--}}
                                                <button
                                                    class="text-white"
                                                    onclick="showModalUpdateImage({{$image->id}})"
                                                >
                                                    <i class="bi bi-pencil-square text-[20px] hover:text-gray-400"></i>
                                                </button>
                                                {{--nút xóa--}}
                                                <button
                                                    class="ml-2 text-white"
                                                    onclick="showModalDeleteImage({{$image->id}})"
                                                >
                                                    <i class="bi bi-trash3 text-[20px] hover:text-red-500"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <!-- Drop Zone -->
                                @if($images->count()<5)
                                    <div id="cartUpLoad" class="group relative">
                                        <form class="h-full" method="POST" id="form-save-general-image" onsubmit="prepareSubmitSave(event)"
                                              enctype="multipart/form-data" action="{{url('boss/image/save')}}">
                                            @csrf
                                            <div
                                                class="rounded-lg overflow-hidden relative h-60 border-dashed border-[1px] border-green-600">
                                                <div
                                                    id="dropZone"
                                                    class="w-full h-full text-gray-500 text-center cursor-pointer flex flex-col justify-center items-center"
                                                    ondragover="handleDragOverNew(event)"
                                                    ondrop="handleDropNew(event)"
                                                    onclick="document.getElementById('generalImageSaveInput').click()"
                                                >
                                                    <i class="bi bi-cloud-arrow-up text-[26px]" id="uploadIcon"></i>
                                                    <p id="uploadText" class="mx-1">Drag and drop images here or click to select</p>
                                                    <img id="generalImageSave"
                                                         class="hidden rounded max-w-full max-h-full object-cover"/>
                                                </div>
                                                <input
                                                    type="file"
                                                    name="image"
                                                    id="generalImageSaveInput"
                                                    class="hidden"
                                                    onchange="generalImageSaveOnchange(event)"
                                                >
                                            </div>
                                            <!-- Save & Cancel Buttons -->
                                            <div id="actionButtons" class="mt-4 flex justify-center space-x-4 hidden">
                                                <button
                                                    type="button"
                                                    onclick="callSubmit()"
                                                    class="bg-green-800 text-white px-4 py-2 rounded hover:bg-green-600 transition"
                                                >
                                                    Save
                                                </button>
                                                <button
                                                    type="button"
                                                    class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition"
                                                    onclick="resetForm()"
                                                >
                                                    Cancel
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                @endif

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        const DELETE_IMAGE_URL='{{url('boss/image/delete')}}';
        const UPDATE_IMAGE_URL='{{url('boss/image/update')}}';
    </script>

    @include('boss.image.elements.confirm_delete')
    @include('boss.image.elements.modal_image')

    <script src="{{ asset('js/boss/image/index.js?t='.config('constants.app_version') )}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
            integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
            integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
            crossorigin="anonymous"></script>

@endsection
