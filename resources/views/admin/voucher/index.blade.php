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

                                @foreach($vouchers as $voucher)
                                    <tr>
                                        <td>{{ $voucher->name }}</td>
                                        <td>{{ $voucher->price }}</td>
                                        <td>{{ $voucher->release_date }}</td>
                                        <td>{{ $voucher->end_date }}</td>
                                        <td>{{ $voucher->conditions_apply }}</td>
                                        <td>{{ $voucher->User->full_name }}</td>
                                        <td class="text-center">
                                            <a role="button" class="btn btn-primary js-on-edit" data-url="{{ route('admin.voucher.detail', $voucher->id) }}">
                                                Detail
                                            </a>
                                            <button type="button" class="btn btn-danger" onclick="showModal({{ $voucher->id }})">
                                                Block
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach


                                </tbody>
                            </table>
                            <!---- Phân trang----->
                            <div class="pagination-custom">
                                {!! $vouchers->appends(request()->input())->links('pagination::bootstrap-4') !!}
                            </div>

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
    </script>
    <script src="{{ asset('js/admin/voucher/index.js?t='.config('constants.app_version') )}}"></script>
@endsection


