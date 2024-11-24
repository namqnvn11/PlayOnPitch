@extends("layouts.appboss")
@section('title', $title ?? 'Yard Schedule')
@section("content")
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Yard Schedule</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Admin</a></li>
                        <li class="breadcrumb-item active">{{ $title ?? 'Yard Schedule' }}</li>
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
                            <div class="card-tools">
                                <green-button role="button" class="btn btn-success js-on-create">
                                    + Add new
                                </green-button>
                            </div>
                        </div>
                        {{--end card header--}}

                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th>Time Slot</th>
                                    @foreach($Dates as $key => $date)
                                        @if ($key < 7) {{-- Hiển thị tối đa 7 ngày --}}
                                        <th>{{ $date->date }}</th>
                                        @endif
                                    @endforeach
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($TimeSlots as $timeSlot)
                                    <tr>
                                        <td>{{ $timeSlot->time_slot }}</td>
                                        @foreach ($Dates as $date)
                                            @php
                                                // Tìm yardSchedule theo date và time_slot
                                                $matchingSchedule = $yardSchedules->first(function ($yardSchedule) use ($date, $timeSlot) {
                                                    return $yardSchedule->date === $date->date && $yardSchedule->time_slot === $timeSlot->time_slot;
                                                });
                                            @endphp

                                            @if ($matchingSchedule)
                                                <td>
                                                    <div>{{ $matchingSchedule->reservation->name ?? 'N/A' }}</div>
                                                    <div>{{ $matchingSchedule->reservation->phone ?? 'N/A' }}</div>
                                                    <div>{{ number_format($matchingSchedule->price_per_hour, 0, ',', '.') }} VNĐ</div>
                                                </td>
                                            @else
                                                <td>--</td>
                                            @endif
                                        @endforeach
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <!---- Phân trang----->
                            @if($yardSchedules->hasPages())
                                <x-paginate-container>
                                    {!! $yardSchedules->appends(request()->input())->links('pagination::bootstrap-4') !!}
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


