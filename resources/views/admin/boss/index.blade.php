@extends("layouts.app")
@section('title', $title ?? 'Boss')
@section("content")

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Boss</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Admin</a></li>
                        <li class="breadcrumb-item active">{{ $title ?? 'Boss' }}</li>
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
                        <div class="flex justify-between p-3 border rounded-top items-center">

                            <div class="search-filter flex">
                                <form action="{{url('admin/boss/search')}}" method="get" id="filterForm" class="flex">
                                    <x-text-input placeholder="Search name or email" name="searchText" value="{{ old('searchText', request('searchText')) }}"/>
                                    <x-green-button type="submit" class="ml-1" data-toggle="tooltip" data-placement="bottom" title="trạng thái mới cũ">search</x-green-button>

                                    <div class="flex items-center ml-4">
                                        <label for="status" class="mt-1">Status</label>
                                        <x-select name="filterStatus" id="filterStatus" onchange="filter()" class="ml-1">
                                            <option value="all" {{ old('filterStatus', request('filterStatus')) == 'all' ? 'selected' : '' }}>All</option>
                                            <option value="new" {{ old('filterStatus', request('filterStatus')) == 'new' ? 'selected' : '' }}>New</option>
                                            <option value="old" {{ old('filterStatus', request('filterStatus')) == 'old' ? 'selected' : '' }}>Old</option>
                                        </x-select>
                                    </div>

                                    <div class="flex items-center ml-4">
                                        <x-select name="block" id="block" onchange="filter()" >
                                            <option value="active" {{ old('block', request('block')) == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="blocked" {{ old('block', request('block')) == 'blocked' ? 'selected' : '' }}>Blocked</option>
                                            <option value="all" {{ old('block', request('block')) == 'all' ? 'selected' : '' }}>All</option>
                                        </x-select>
                                    </div>

                                </form>
                            </div>

                            <div class="add-new-user">
                                <x-green-button role="button" class="js-on-create">
                                    + Add new
                                </x-green-button>
                            </div>
                        </div>
                        {{--end card header--}}

                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th>Email</th>
                                    <th>Full Name</th>
                                    <th>Phone</th>
                                    <th>Company Name</th>
                                    <th>Company Address</th>
                                    <th>Status</th>

                                    <th class="text-center" style="width: 170px;">Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                @if($bosses->count()==0)
                                    <tr><td colspan="7">No Boss Found</td></tr>
                                @endif

                                @foreach($bosses as $boss)
                                    <tr onclick="viewDetail(event)" data-url="{{ route('admin.boss.detail', $boss->id) }}" class="cursor-default">
                                        <td>
                                            @if($boss->block)
                                                <i class="bi bi-ban mr-1"></i>
                                            @endif
                                            {{ $boss->email }}
                                        </td>
                                        <td>{{ $boss->full_name }}</td>
                                        <td>{{ $boss->phone }}</td>
                                        <td>{{ $boss->company_name }}</td>
                                        <td>{{ $boss->company_address . ', ' . $boss->District->name . ", " . $boss->District->Province->name }}</td>
                                        <td>{{ $boss->status == 1 ? 'Mới' : 'Cũ' }}</td>

                                        <td class="text-center" onclick="event.stopPropagation()">
                                            <div class="dropdown">
                                                <button  type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="bi bi-three-dots-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu z-30" aria-labelledby="dropdownMenuButton1">
                                                    <li>
                                                        @if($boss->block)
                                                            <div class="dropdown-item active:bg-green-900" onclick="showModalUnBlock(event,{{ $boss->id }})">
                                                                UnBlock
                                                            </div>
                                                        @else
                                                            <div class="dropdown-item active:bg-green-900" onclick="showModalBlock(event,{{ $boss->id }})">
                                                                Block
                                                            </div>
                                                        @endif
                                                    </li>
                                                    <li>
                                                        <div class="js-on-reset-password dropdown-item active:bg-green-900" onclick="prepareResetPassword(event,{{$boss->id}})">
                                                            Reset Password
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
                            @if($bosses->hasPages())
                                <x-paginate-container>
                                    {!! $bosses->appends(request()->input())->links('pagination::bootstrap-4') !!}
                                </x-paginate-container>
                            @endif


                        </div>

                    </div>

                </div>
            </div>
        </div>
    </section>


    @include('admin.boss.elements.modal_edit')
    @include('admin.boss.elements.modal_confirm')
    @include('admin.boss.elements.modal_confirm_reset_password')

@endsection

@section("pagescript")
    <script>
        const STORE_URL = "{{ route('admin.boss.store') }}";
        var getDistrictsUrl = "{{ route('admin.boss.getDistricts') }}";
        const BLOCK_URL= "{{url('/admin/boss/block')}}"
        const UNBLOCK_URL= "{{url('/admin/boss/unblock')}}"
        const RESET_PASSWORD_URL= '{{url('admin/boss/reset-password')}}'
        {{--const DELETE_URL = "{{ route('admin.boss.destroy') }}";--}}
    </script>
    <script src="{{ asset('js/admin/boss/index.js?t='.config('constants.app_version') )}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
@endsection


