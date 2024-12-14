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
                        <div class="flex justify-start p-3 border">
                            <form method="GET" action="{{ route('boss.yard_schedule.index') }}" class="form-inline mr-2">
                                <div class="form-group">
                                    <label for="yard_id" class="mr-2">Select Yard:</label>
                                    <select name="yard_id" id="yard_id" class="form-control mr-2"  style="padding-right: 40px">
                                        @foreach($yards as $yard)
                                            <option value="{{ $yard->id }}" {{ $yardId == $yard->id ? 'selected' : '' }}>
                                                {{ $yard->yard_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <x-green-button type="submit" class="btn btn-primary">Filter</x-green-button>
                            </form>
                            <div class="flex float-left border-green-900 border">
                                <x-green-button class="w-[170px] mr-2"><a href="{{url('boss/yard/schedule/create')}}">Create Schedule</a></x-green-button>
                                <x-green-button class="w-[170px]"><a href="{{url('boss/yard/schedule/delete')}}">delete Schedule</a></x-green-button>
                            </div>
                    </div>
                        {{--end card header--}}

                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th>Time Slot</th>
                                    @foreach($Dates as $key => $date)
                                        <th>({{ \Carbon\Carbon::parse($date->date)->translatedFormat('l') }})<br>
                                            {{ \Carbon\Carbon::parse($date->date)->format('d/m/Y') }}
                                        </th>
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
                                                <td  class="editable-cell js-on-create" data-id="{{ $matchingSchedule->reservation_id }}" data-url="{{route("boss.yard_schedule.detail", ['id' => $matchingSchedule->reservation_id])}}">
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


    @include('boss.yard_schedule.elements.modal_edit')
    @include('boss.yard_schedule.elements.modal_confirm')

@endsection

@section("pagescript")
    <script>
        const STORE_URL = "{{ route('admin.voucher.store') }}";
        const BLOCK_URL= "{{url('/admin/voucher/block')}}"
        const UNBLOCK_URL= "{{url('/admin/voucher/unblock')}}"
        {{--const DELETE_URL = "{{ route('admin.voucher.destroy') }}";--}}
    </script>
    <script src="{{ asset('js/boss/yard_schedule/index.js?t='.config('constants.app_version') )}}"></script>
@endsection


