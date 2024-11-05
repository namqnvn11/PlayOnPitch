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
                                    <x-text-input placeholder="search name or email" name="searchText" value="{{ old('searchText', request('searchText')) }}"/>
                                    <x-secondary-button type="submit" class="ml-1">search</x-secondary-button>
                                    <div class="flex items-center ml-4">
                                        <x-select name="block" id="" onchange="filterStatus()" >
                                            <option value="active" {{ old('block', request('block')) == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="blocked" {{ old('block', request('block')) == 'blocked' ? 'selected' : '' }}>Blocked</option>
                                            <option value="all" {{ old('block', request('block')) == 'all' ? 'selected' : '' }}>All</option>
                                        </x-select>
                                    </div>

                                    <div class="ml-3">
                                        <label for="fromDate">From</label>
                                        <x-timepicker value="{{ old('fromDate', request('fromDate')) }}" name="fromDate" onchange="filterDate()"/>
                                    </div>

                                    <div class="ml-3">
                                        <label for="toDate">To</label>
                                        <x-timepicker name="toDate" value="{{ old('toDate', request('toDate')) }}" onchange="filterDate()"/>
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
                                                <x-unblock-button type="button" class="" onclick="showModal({{ $voucher->id }})">
                                                    UnClock
                                                </x-unblock-button>
                                            @else
                                                <x-block-button type="button" class="" onclick="showModal({{ $voucher->id }})">
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
        {{--const DELETE_URL = "{{ route('admin.voucher.destroy') }}";--}}
    </script>
    <script>
        function showModal(voucherId) {
            const form = document.getElementById('form-block');
            form.action = `/admin/voucher/block/${voucherId}`;
            $('#modal-confirm').modal('show');
        }
        function filterStatus(){
            document.getElementById('filterForm').submit();
        }
        function filterDate(){
            document.getElementById('filterForm').submit();
        }

    </script>
    <script src="{{ asset('js/admin/voucher/index.js?t='.config('constants.app_version') )}}"></script>
@endsection


