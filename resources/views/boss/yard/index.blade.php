@extends("layouts.appboss")
@section('title', $title ?? 'Yard')
@section("content")
@php
$currentBoss=\Illuminate\Support\Facades\Auth::guard('boss')->user();
$districtId= $currentBoss->District->id;
$provinceId= $currentBoss->Province->id;
$districtList= $currentBoss->Province->Districts;
$timeClose = $currentBoss->time_close
    ? \Carbon\Carbon::createFromFormat('H:i:s', $currentBoss->time_close)->format('h:i A')
    : 'N/A';
$timeOpen = $currentBoss->time_close
    ? \Carbon\Carbon::createFromFormat('H:i:s', $currentBoss->time_open)->format('h:i A')
    : 'N/A';

$timeOpenInModal = $currentBoss->time_close
    ? \Carbon\Carbon::createFromFormat('H:i:s', $currentBoss->time_open)->format('H:i')
    : 'N/A';
$timeCloseInModal = $currentBoss->time_close
    ? \Carbon\Carbon::createFromFormat('H:i:s', $currentBoss->time_close)->format('H:i')
    : 'N/A';
@endphp
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
                                    <x-text-input placeholder="Search yard name" name="searchText" value="{{ old('searchText', request('searchText')) }}"/>
                                    <x-green-button type="submit" class="ml-1">search</x-green-button>
                                    <div class="flex items-center ml-4">
                                        <x-select name="block" id="" onchange="filter()">
                                            <option value="active" {{ old('block', request('block')) == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="blocked" {{ old('block', request('block')) == 'blocked' ? 'selected' : '' }}>Blocked</option>
                                            <option value="all" {{ old('block', request('block')) == 'all' ? 'selected' : '' }}>All</option>
                                        </x-select>
                                    </div>
                                </form>
                            </div>
                            <div class="card-tools flex items-center">
                                @if($currentBoss->is_open_all_day)
                                    <div class="text-[20px] text-bold">OPENING : ALL DAY</div>
                                @else
                                    <div class="text-[20px] text-bold">OPENING : {{$timeOpen}} - {{$timeClose}}</div>
                                @endif
                                <button class="btn js-on-open-time">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                    </svg>
                                </button>
                                <x-green-button role="button" class="js-on-create ml-3">
                                    + Add new
                                </x-green-button>
                            </div>
                        </div>

                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th>Company</th>
                                    <th>Yard Name</th>
                                    <th>Yard Type</th>
                                    <th>District</th>
                                    <th class="text-center" style="width: 170px;">Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                @if($yards->count()==0)
                                    <tr><td colspan="5">No Yard Found</td></tr>
                                @endif

                                @foreach($yards as $yard)
                                    <tr onclick="viewDetail(event)" data-url="{{ route('boss.yard.detail', $yard->id) }}" class="cursor-default">
                                        <td>{{ $yard->Boss->company_name }}</td>
                                        <td>{{ $yard->yard_name }}</td>
                                        <td>{{ $yard->yard_type }}</td>
                                        <td>{{ $yard->District->name }}</td>
                                        <td class="text-center" onclick="event.stopPropagation()">
                                            <div class="dropdown">
                                                <button  type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="bi bi-three-dots-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                    <li>
                                                        @if($yard->block)
                                                            <div type="button" class="dropdown-item active:bg-green-900" onclick="showModalUnBlock({{ $yard->id }})">
                                                                Unblock
                                                            </div>
                                                        @else
                                                            <div type="button" class="dropdown-item active:bg-green-900" onclick="showModalBlock({{ $yard->id }})">
                                                                Block
                                                            </div>
                                                        @endif
                                                    </li>
                                                    <li>
                                                        <button class="dropdown-item active:bg-green-900" yard-id="{{$yard->id}}" onclick="showModalPricing({{$yard->id}})" >
                                                            Pricing
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>

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
    @include('boss.yard.elements.modal_time_setting')
    @include('boss.yard.elements.modal_open_time')

@endsection

@section("pagescript")
    <script>
        const STORE_URL = "{{ route('boss.yard.store') }}";
        var getDistrictsUrl = "{{ route('boss.yard.getDistricts') }}";
        const BLOCK_URL= "{{url('/boss/yard/block')}}"
        const UNBLOCK_URL= "{{url('/boss/yard/unblock')}}"
        const TIME_SETTING_URL = "{{ url('/boss/yard/pricing') }}";
        const GET_TIME_SETTING_URL= "{{url('/boss/yard/getPricing')}}";
        const SET_OPEN_TIME_URL= "{{url('/boss/yard/setOpenTime')}}/{{$currentBoss->id}}"
    </script>
    <script src="{{ asset('js/boss/yard/index.js?t='.config('constants.app_version') )}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

@endsection


