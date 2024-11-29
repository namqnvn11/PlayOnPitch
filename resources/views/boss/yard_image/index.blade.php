@extends("layouts.appboss")
@section('title', $title ?? 'Yard Image')
@section("content")
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Yards Images</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Admin</a></li>
                        <li class="breadcrumb-item active">{{ $title ?? 'Yard Image' }}</li>
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
                            @foreach($yardList as $yard)
                                <div class="w-full h-full">
                                    <div class="w-full text-center my-1 text-bold">{{$yard->yard_name}}</div>
                                    <div class="group relative" id="imgGroup">
                                        <div class="rounded-lg shadow overflow-hidden relative h-60 mx-auto">
                                            <img class="w-full h-full object-cover group-hover:opacity-75 transition border-gray-700" src="{{$yard->image->img??asset('img/sanbong.jpg')}}" alt="yard img" id="yard-{{$yard->id}}">
                                            <div class="absolute inset-0 bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300" >
                                                @if($yard->image)
                                                    {{--nút update--}}
                                                    <button class="text-white" onclick="updateYardImage({{$yard->image->id}})">
                                                        <i class="bi bi-pencil-square text-[20px] hover:text-gray-400"></i>
                                                    </button>
                                                    {{--nút xóa--}}
                                                    <button class="ml-2 text-white" onclick="deleteYardImage({{$yard->image->id}})">
                                                        <i class="bi bi-trash3 text-[20px] hover:text-red-500"></i>
                                                    </button>
                                                @else
                                                    {{--nút add new--}}
                                                    <button class="text-white" onclick="addNewYardImage({{$yard->id}})">
                                                        <i class="bi bi-plus-circle text-[20px] hover:text-gray-400"></i>
                                                    </button>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <script>
        const DELETE_IMAGE_URL='{{url('boss/yard/image/delete')}}';
        const UPDATE_IMAGE_URL='{{url('boss/yard/image/update')}}';
        const ADD_NEW_IMAGE_URL='{{url('boss/yard/image/save')}}'
    </script>

    @include('boss.yard_image.elements.confirm_delete')
    @include('boss.yard_image.elements.modal_image')

    <script src="{{ asset('js/boss/yard_image/index.js?t='.config('constants.app_version') )}}"></script>
{{--    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"--}}
{{--            integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"--}}
{{--            crossorigin="anonymous"></script>--}}
{{--    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"--}}
{{--            integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"--}}
{{--            crossorigin="anonymous"></script>--}}

@endsection
