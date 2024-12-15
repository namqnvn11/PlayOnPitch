@extends("layouts.app")
@section('title', $title ?? 'User')
@section("content")

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>User</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Admin</a></li>
                        <li class="breadcrumb-item active">{{ $title ?? 'User' }}</li>
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
                                <form action="{{url('admin/user/search')}}" method="get" id="filterForm" class="flex">
                                    <x-text-input placeholder="Search name or email" name="searchText" value="{{ old('searchText', request('searchText')) }}"/>
                                    <x-green-button type="submit" class="ml-1">search</x-green-button>
                                    <div class="flex items-center ml-4">
                                        <x-select name="block" id="" onchange="filter()" >
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

                        <div class="table-responsive">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr class="p-2">
                                    <th>
                                        Full Name
                                        @if (request('asc') === 'false')
                                            <a type="submit" class="hover:text-gray-300"
                                               href="{{ url('admin/user/search') . '?' . http_build_query(array_merge(request()->query(), ['asc' => 'true'])) }}">
                                                <i class="bi bi-arrow-down"></i>
                                            </a>
                                        @else
                                            <a type="submit" class="hover:text-gray-300"
                                               href="{{ url('admin/user/search') . '?' . http_build_query(array_merge(request()->query(), ['asc' => 'false'])) }}">
                                                <i class="bi bi-arrow-up"></i>
                                            </a>
                                        @endif
                                    </th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th class="text-center" style="width: 170px;">Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                @if($users->count()==0)
                                    <tr><td colspan="5">No User Found</td></tr>
                                @endif

                                @foreach($users as $user)
                                    <tr onclick="viewDetail(event)" data-url="{{ route('admin.user.detail', $user->id) }}" class="cursor-default">
                                        <td class="">
                                            @if($user->block)
                                                <i class="bi bi-ban mr-1"></i>
                                            @endif
                                            {{ $user->full_name }}

                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->phone }}</td>
                                        @if($user->address)
                                        <td>{{$user->address . ', ' . $user->District->name . ", " . $user->District->Province->name }}</td>
                                        @else
                                            <td></td>
                                        @endif
                                        <td class="text-center" onclick="event.stopPropagation()">
                                            <div class="dropdown">
                                                <button  type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="bi bi-three-dots-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                    <li>
                                                        @if($user->block)
                                                            <div class="dropdown-item active:bg-green-900" type="" onclick="showModalUnBlock({{ $user->id }},event)">
                                                                Unblock
                                                            </div>
                                                        @else
                                                            <div class="dropdown-item active:bg-green-900" type="button" onclick="showModalBlock({{ $user->id }},event)">
                                                                Block
                                                            </div>
                                                        @endif
                                                    </li>
                                                    <li>
                                                        <div role="button" class="dropdown-item js-on-reset-password active:bg-green-900" onclick="prepareResetPassword(event,{{$user->id}})">
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
                            @if ($users->hasPages())
                                <x-paginate-container >
                                    {!! $users->appends(request()->input())->links('pagination::bootstrap-4') !!}
                                </x-paginate-container >
                            @endif
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    @include('admin.user.elements.modal_edit')
    @include('admin.user.elements.modal_confirm')
    @include('admin.user.elements.modal_confirm_reset_password')
@endsection

@section("pagescript")
    <script>
        const STORE_URL = "{{ route('admin.user.store') }}";
        var getDistrictsUrl = "{{ route('admin.user.getDistricts') }}";
        const BLOCK_URL= "{{url('/admin/user/block')}}"
        const UNBLOCK_URL= "{{url('/admin/user/unblock')}}"
        const RESET_PASSWORD_URL= '{{url('admin/user/reset-password')}}'
    </script>
    <script src="{{ asset('js/admin/user/index.js?t='.config('constants.app_version') )}}"></script>
    <script src="{{ asset('js/admin/admin.js?t='.config('constants.app_version'))}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

@endsection


