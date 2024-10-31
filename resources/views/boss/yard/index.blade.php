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
                        <div class="card-header">
                            <h3 class="card-title"></h3>
                            <div class="card-tools">
                                <a role="button" class="btn btn-success js-on-create">
                                    + Add new
                                </a>
                            </div>
                        </div>

                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th>Boss</th>
                                    <th>Yard Name</th>
                                    <th>Yard Type</th>
                                    <th>Description</th>
                                    <th>District</th>
                                    <th class="text-center" style="width: 170px;">Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($yards as $yard)
                                    <tr>
                                        <td>{{ $yard->Boss->company_name }}</td>
                                        <td>{{ $yard->yard_name }}</td>
                                        <td>{{ $yard->yard_type }}</td>
                                        <td>{{ $yard->description }}</td>
                                        <td>{{ $yard->District->name }}</td>
                                        <td class="text-center">
                                            <a role="button" class="btn btn-primary js-on-edit" data-url="{{ route('boss.yard.detail', $yard->id) }}">
                                                Detail
                                            </a>

                                            <button type="button" class="btn btn-danger" onclick="showModal({{ $yard->id }})">
                                                Block
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach


                                </tbody>
                            </table>
                            <!---- Phân trang----->
                            <div class="pagination-custom">
                                {!! $yards->appends(request()->input())->links('pagination::bootstrap-4') !!}
                            </div>

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
    </script>
    <script src="{{ asset('js/boss/yard/index.js?t='.config('constants.app_version') )}}"></script>
@endsection


