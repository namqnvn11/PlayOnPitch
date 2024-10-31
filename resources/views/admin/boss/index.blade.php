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

                                @foreach($bosses as $boss)
                                    <tr>
                                        <td>{{ $boss->email }}</td>
                                        <td>{{ $boss->full_name }}</td>
                                        <td>{{ $boss->phone }}</td>
                                        <td>{{ $boss->company_name }}</td>
                                        <td>{{ $boss->company_address . ", " . $boss->District->name . ", " . $boss->District->Province->name }}</td>
                                        <td>{{ $boss->status == 1 ? 'Mới' : 'Cũ' }}</td>

                                        <td class="text-center">

                                            <button type="button" class="btn btn-danger" onclick="showModal({{ $boss->id }})">
                                                Block
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach


                                </tbody>
                            </table>
                            <!---- Phân trang----->
                            <div class="pagination-custom">
                                {!! $bosses->appends(request()->input())->links('pagination::bootstrap-4') !!}
                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </section>


    @include('admin.boss.elements.modal_edit')
    @include('admin.boss.elements.modal_confirm')

@endsection

@section("pagescript")
    <script>
        const STORE_URL = "{{ route('admin.boss.store') }}";
        var getDistrictsUrl = "{{ route('admin.boss.getDistricts') }}";

        {{--const DELETE_URL = "{{ route('admin.boss.destroy') }}";--}}
    </script>
    <script>
        function showModal(bossId) {
            const form = document.getElementById('form-block');
            form.action = `/admin/boss/block/${bossId}`;
            $('#modal-confirm').modal('show');
        }
    </script>
    <script src="{{ asset('js/admin/boss/index.js?t='.config('constants.app_version') )}}"></script>
@endsection


