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
                                            <x-secondary-button type="submit" class="ml-1">search</x-secondary-button>
                                        </div>

                                        <div class="mt-2">
                                            <x-select name="block" id="" onchange="filter()" >
                                                <option value="active" {{ old('block', request('block')) == 'active' ? 'selected' : '' }}>Active</option>
                                                <option value="blocked" {{ old('block', request('block')) == 'blocked' ? 'selected' : '' }}>Blocked</option>
                                                <option value="all" {{ old('block', request('block')) == 'all' ? 'selected' : '' }}>All</option>
                                            </x-select>
                                            <x-secondary-button type="submit" class="ml-1"><a href="{{url('admin/voucher/index')}}">clear search</a></x-secondary-button>
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
                                <x-add-new-button role="button" class="btn btn-success js-on-create">
                                    + Add new
                                </x-add-new-button>
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
                                    <th>User</th>
                                    <th class="text-center" style="width: 170px;">Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                @if($vouchers->count()==0)
                                    <tr><td colspan="7">No Voucher Found</td></tr>
                                @endif

                                @foreach($vouchers as $voucher)
                                    <tr>
                                        <td>{{ $voucher->name }}</td>
                                        <td>{{ $voucher->price }}</td>
                                        <td>{{ $voucher->release_date }}</td>
                                        <td>{{ $voucher->end_date }}</td>
                                        <td>{{ $voucher->conditions_apply }}</td>
                                        <td>{{ $voucher->User->full_name }}</td>
                                        <td class="text-center">
                                            <x-detail-button role="button" class="js-on-edit" data-url="{{ route('admin.voucher.detail', $voucher->id) }}">
                                                Detail
                                            </x-detail-button>
                                            @if($voucher->block)
                                                <x-unblock-button type="button" class="" onclick="showModalUnBlock({{ $voucher->id }})">
                                                    UnBlock
                                                </x-unblock-button>
                                            @else
                                                <x-block-button type="button" class="" onclick="showModalBlock({{ $voucher->id }})">
                                                    Block
                                                </x-block-button>
                                            @endif
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

@endsection

@section("pagescript")
    <script>
        const STORE_URL = "{{ route('admin.voucher.store') }}";
        const BLOCK_URL= "{{url('/admin/voucher/block')}}"
        const UNBLOCK_URL= "{{url('/admin/voucher/unblock')}}"
        {{--const DELETE_URL = "{{ route('admin.voucher.destroy') }}";--}}
    </script>
    <script src="{{ asset('js/admin/voucher/index.js?t='.config('constants.app_version') )}}"></script>
@endsection


