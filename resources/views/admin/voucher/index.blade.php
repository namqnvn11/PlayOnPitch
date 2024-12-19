@extends("layouts.app")
@section('title', $title ?? 'Voucher')
@section("content")
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Voucher</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Admin</a></li>
                        <li class="breadcrumb-item active">{{ $title ?? 'Voucher' }}</li>
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

                        {{-- card header--}}
                        <div class="flex justify-between p-3 border rounded-top align-middle">

                            <div class="search-filter flex">
                                <form action="{{url('admin/voucher/search')}}" method="get" id="filterForm" class="flex">
                                    <div class="">
                                        <div>
                                            <x-text-input placeholder="Search voucher name" name="searchText" value="{{ old('searchText', request('searchText')) }}"/>
                                            <x-green-button type="submit" class="ml-1">search</x-green-button>
                                        </div>

                                        <div class="mt-2 flex ">
                                            <x-select name="block" id="" onchange="filter()" >
                                                <option value="active" {{ old('block', request('block')) == 'active' ? 'selected' : '' }}>Active</option>
                                                <option value="blocked" {{ old('block', request('block')) == 'blocked' ? 'selected' : '' }}>Blocked</option>
                                                <option value="all" {{ old('block', request('block')) == 'all' ? 'selected' : '' }}>All</option>
                                            </x-select>
                                            <x-green-button type="submit" class="ml-1 w-[150px]"><a href="{{url('admin/voucher/index')}}" class="hover:text-white">clear search</a></x-green-button>
                                        </div>
                                    </div>
                                    <div class="">
                                        <div class="flex justify-start items-center rounded px-2">
                                            <div class="ml-2">
                                                <label for="fromReleaseDate">From</label>
                                                <x-timepicker value="{{ old('fromReleaseDate', request('fromReleaseDate')) }}" name="fromReleaseDate" onchange="filter()"/>
                                            </div>
                                            <div class="ml-3">
                                                <label for="toReleaseDate">To</label>
                                                <x-timepicker name="toReleaseDate" value="{{ old('toReleaseDate', request('toReleaseDate')) }}" onchange="filter()"/>
                                            </div>
                                            <div class="font-bold ml-2 self-start">Release Date</div>
                                        </div>

                                        <div class="flex justify-start items-center rounded px-2 mt-2">
                                            <div class="flex">
                                                <div class="ml-2">
                                                    <label for="fromExpireDate">From</label>
                                                    <x-timepicker value="{{ old('fromExpireDate', request('fromExpireDate')) }}" name="fromExpireDate" onchange="filter()"/>
                                                </div>

                                                <div class="ml-3">
                                                    <label for="toExpireDate">To</label>
                                                    <x-timepicker name="toExpireDate" value="{{ old('toExpireDate', request('toExpireDate')) }}" onchange="filter()"/>
                                                </div>
                                            </div>
                                            <div class="font-bold ml-2 self-start">Expire Date</div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="card-tools">
                                <x-green-button role="button" class="btn btn-success js-on-create">
                                    + Add new
                                </x-green-button>
                            </div>
                        </div>
                        {{--end card header--}}

                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Release date</th>
                                    <th>End Date</th>
                                    <th>Conditions Apply</th>
                                    <th class="text-center" style="width: 170px;">Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                @if($vouchers->count()==0)
                                    <tr><td colspan="7">No Voucher Found</td></tr>
                                @endif

                                @foreach($vouchers as $voucher)
                                    <tr
                                        @if($voucher->id!==9999)  onclick="viewDetail(event)"  @endif
                                        data-url="{{ route('admin.voucher.detail', $voucher->id) }}" class="cursor-default">
                                        <td>
                                            @if($voucher->block)
                                                <i class="bi bi-ban mr-1"></i>
                                            @endif
                                            {{ $voucher->name }}
                                        </td>
                                        <td>{{ number_format($voucher->price , 0, ',', '.') }}</td>
                                        <td>{{ $voucher->id===9999?'none':$voucher->release_date }}</td>
                                        <td>{{ $voucher->id===9999?'none': $voucher->end_date }}</td>
                                        <td>{{ number_format($voucher->conditions_apply,0,',','.') }}</td>
                                        <td class="text-center" onclick="event.stopPropagation()">
                                            <div class="dropdown">
                                                <button  type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="bi bi-three-dots-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                    <li>
                                                        @if($voucher->block)
                                                            <div type="button" class="dropdown-item active:bg-green-900" onclick="showModalUnBlock({{ $voucher->id }})">
                                                                UnBlock
                                                            </div>
                                                        @else
                                                            <div type="button" class="dropdown-item active:bg-green-900" onclick="showModalBlock({{ $voucher->id }})">
                                                                Block
                                                            </div>
                                                        @endif
                                                            <div type="button" class="dropdown-item active:bg-green-900" onclick="showModalImage({{ $voucher->id }})">
                                                                Image
                                                            </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                            <!---- Phân trang----->
                            @if($vouchers->hasPages())
                                <x-paginate-container>
                                    {!! $vouchers->appends(request()->input())->links('pagination::bootstrap-4') !!}
                                </x-paginate-container>
                            @endif

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </section>


    @include('admin.voucher.elements.modal_edit')
    @include('admin.voucher.elements.modal_confirm')
    @include('admin.voucher.elements.modal_image')

@endsection

@section("pagescript")
    <script>
        const STORE_URL = "{{ route('admin.voucher.store') }}";
        const BLOCK_URL= "{{url('/admin/voucher/block')}}"
        const UNBLOCK_URL= "{{url('/admin/voucher/unblock')}}"
        const GET_IMAGE_URL="{{url('/admin/voucher/image/get')}}"
        const SAVE_IMAGE_URL="{{url('/admin/voucher/image/save')}}"
    </script>
    <script src="{{ asset('js/admin/voucher/index.js?t='.config('constants.app_version') )}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

@endsection


