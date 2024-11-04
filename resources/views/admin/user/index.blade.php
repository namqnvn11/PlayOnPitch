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
                                    <x-text-input placeholder="search name or email" name="searchText" value="{{ old('searchText', request('searchText')) }}"/>
                                    <x-secondary-button type="submit" class="ml-1">search</x-secondary-button>
                                    <div class="flex items-center ml-4">
                                        <x-select name="block" id="" onchange="filterStatus()" >
                                            <option value="active" {{ old('block', request('block')) == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="blocked" {{ old('block', request('block')) == 'blocked' ? 'selected' : '' }}>Blocked</option>
                                            <option value="all" {{ old('block', request('block')) == 'all' ? 'selected' : '' }}>All</option>
                                        </x-select>
                                    </div>
                                </form>
                            </div>

                            <div class="add-new-user">
                                <a role="button" class="btn btn-success js-on-create">
                                    + Add new
                                </a>
                            </div>
                        </div>
                        {{--end card header--}}

                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th class="text-center" style="width: 170px;">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($users->count()==0)
                                    <tr><td colspan="5">No User</td></tr>
                                @endif
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->full_name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->phone }}</td>
                                        @if($user->address)
                                        <td>{{ $user->address . ", " . $user->District->name . ", " . $user->District->Province->name }}</td>
                                        @else
                                            <td></td>
                                        @endif

                                        <td class="text-center">
                                            @if($user->block)
                                                <button type="button" class="btn btn-secondary" onclick="showModal({{ $user->id }})">
                                                    UnClock
                                                </button>
                                            @else
                                                <button type="button" class="btn btn-danger" onclick="showModal({{ $user->id }})">
                                                    Block
                                                </button>
                                            @endif


                                        </td>
                                    </tr>
                                @endforeach


                                </tbody>
                            </table>

                            <!---- Phân trang----->
                            <div class="pagination-custom">
                                {!! $users->appends(request()->input())->links('pagination::bootstrap-4') !!}
                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </section>


    @include('admin.user.elements.modal_edit')
    @include('admin.user.elements.modal_confirm')

@endsection

@section("pagescript")
    <script>
        const STORE_URL = "{{ route('admin.user.store') }}";
        var getDistrictsUrl = "{{ route('admin.user.getDistricts') }}";

        {{--const DELETE_URL = "{{ route('admin.user.destroy') }}";--}}
    </script>
    <script>
        function showModal(userId) {
            const form = document.getElementById('form-block');
            form.action = `/admin/user/block/${userId}`;
            $('#modal-confirm').modal('show');
        }
        function filterStatus(){
            document.getElementById('filterForm').submit();
        }
    </script>
    <script src="{{ asset('js/admin/user/index.js?t='.config('constants.app_version') )}}"></script>
@endsection


