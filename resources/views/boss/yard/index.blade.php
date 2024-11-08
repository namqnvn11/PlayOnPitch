@extends("layouts.appboss")
@section('title', $title ?? 'Yard')
@section("content")

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Yard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Admin</a></li>
                        <li class="breadcrumb-item active">{{ $title ?? 'Yard' }}</li>
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
                                <form action="{{url('boss/yard/search')}}" method="get" id="filterForm" class="flex">
                                    <x-text-input placeholder="search yard name" name="searchText" value="{{ old('searchText', request('searchText')) }}"/>
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
                            <div class="card-tools">
                                <x-add-new-button role="button" class="js-on-create">
                                    + Add new
                                </x-add-new-button>
                            </div>
                        </div>

                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th>Company</th>
                                    <th>Yard Name</th>
                                    <th>Yard Type</th>
{{--                                    <th>Description</th>--}}
                                    <th>District</th>
                                    <th class="text-center" style="width: 170px;">Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                @if($yards->count()==0)
                                    <tr><td colspan="5">No Yard Found</td></tr>
                                @endif

                                @foreach($yards as $yard)
                                    <tr>
                                        <td>{{ $yard->Boss->company_name }}</td>
                                        <td>{{ $yard->yard_name }}</td>
                                        <td>{{ $yard->yard_type }}</td>
{{--                                        <td>{{ $yard->description }}</td>--}}
                                        <td>{{ $yard->District->name }}</td>
                                        <td class="text-center">
                                            <x-detail-button role="button" class="btn btn-primary js-on-edit" data-url="{{ route('boss.yard.detail', $yard->id) }}">
                                                Detail
                                            </x-detail-button>

                                            @if($yard->block)
                                                <x-unblock-button type="button" class="btn btn-danger" onclick="showModal({{ $yard->id }})">
                                                    Unblock
                                                </x-unblock-button>
                                            @else
                                                <x-block-button type="button" class="btn btn-danger" onclick="showModal({{ $yard->id }})">
                                                    Block
                                                </x-block-button>
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach


                                </tbody>
                            </table>
                            <!---- Phân trang----->
                            @if($yards->hasPages())
                                <x-paginate-container>
                                    {!! $yards->appends(request()->input())->links('pagination::bootstrap-4') !!}
                                </x-paginate-container>
                            @endif
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </section>


    @include('boss.yard.elements.modal_edit')
    @include('boss.yard.elements.modal_confirm')

@endsection

@section("pagescript")
    <script>
        const STORE_URL = "{{ route('boss.yard.store') }}";
        var getDistrictsUrl = "{{ route('boss.yard.getDistricts') }}";

        {{--const DELETE_URL = "{{ route('boss.yard.destroy') }}";--}}
    </script>
    <script>
        function showModal(yardId) {
            const form = document.getElementById('form-block');
            form.action = `/boss/yard/block/${yardId}`;
            $('#modal-confirm').modal('show');
        }
        function filterStatus(){
            document.getElementById('filterForm').submit();
        }
    </script>
    <script src="{{ asset('js/boss/yard/index.js?t='.config('constants.app_version') )}}"></script>
@endsection


