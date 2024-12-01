@extends("layouts.app")
@section('title', $title ?? 'RegisterBoss')
@section("content")
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Register Boss</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Admin</a></li>
                        <li class="breadcrumb-item active">{{ $title ?? 'RegisterBoss' }}</li>
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

{{--                            <div class="card-tools">--}}
{{--                                <x-green-button role="button" class="btn btn-success js-on-create">--}}
{{--                                    + Add new--}}
{{--                                </x-green-button>--}}
{{--                            </div>--}}
                        </div>
                        {{--end card header--}}

                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                </tr>
                                </thead>
                                <tbody>

                                @if($registerBosses->count()==0)
                                    <tr><td colspan="7">No Register Boss Found</td></tr>
                                @endif

                                @foreach($registerBosses as $registerBoss)
                                    <tr onclick="viewDetail(event)" data-url="{{ route('admin.registerBoss.detail', $registerBoss->id) }}" class="cursor-default">
                                        <td>
                                            @if($registerBoss->block)
                                                <i class="bi bi-ban mr-1"></i>
                                            @endif
                                            {{ $registerBoss->name }}
                                        </td>
                                        <td>{{ $registerBoss->email }}</td>
                                        <td>{{ $registerBoss->phone }}</td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                            <!---- Phân trang----->
                            @if($registerBosses->hasPages())
                                <x-paginate-container>
                                    {!! $registerBosses->appends(request()->input())->links('pagination::bootstrap-4') !!}
                                </x-paginate-container>
                            @endif

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </section>


    @include('admin.registerBoss.elements.modal_edit')
    @include('admin.registerBoss.elements.modal_confirm')

@endsection

@section("pagescript")
    <script>
        const BLOCK_URL= "{{url('/admin/registerBoss/block')}}"
        const UNBLOCK_URL= "{{url('/admin/registerBoss/unblock')}}"
        {{--const DELETE_URL = "{{ route('admin.registerBoss.destroy') }}";--}}
    </script>
    <script src="{{ asset('js/admin/registerBoss/index.js?t='.config('constants.app_version') )}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

@endsection


