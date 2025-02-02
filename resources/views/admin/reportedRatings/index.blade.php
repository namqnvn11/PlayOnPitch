@extends("layouts.app")
@section('title', $title ?? 'Reported Rating')
@section("content")

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Reported Rating</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Admin</a></li>
                        <li class="breadcrumb-item active">{{ $title ?? 'Reported Rating' }}</li>
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
                        <div class="flex justify-end p-3 border rounded-top items-center">
                            <x-green-button onclick="submitBlock()">Block</x-green-button>
                            <x-green-button class="ml-2" onclick="submitUnblock()">UNBlock</x-green-button>
                        </div>
                        {{--end card header--}}

                        <div class="table-responsive">
                            <form action="{{}}" method="post" id="reported-rating-form">
                                @csrf
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr class="p-2">
                                    <th class="w-[20%]">Author</th>
                                    <th class="w-[10%]">Star</th>
                                    <th class="w-[40%]">Comment</th>
                                    <th class="w-[18%]">Rating Time</th>
                                    <th class="flex items-center max-w-[80px] mt-2" style="border: none">
                                        <x-check-box id="checkAll" onclick="toggleAll(this)"/>
                                        <div class="ml-2">
                                            Check All
                                            @if ($ratings->hasPages())
                                                <span class="text-gray-600 text-[14px] font-weight-normal">
                                                (this page)
                                            </span>
                                            @endif
                                        </div>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($ratings->count()==0)
                                    <tr><th colspan="5" class="font-medium">No Reported</th></tr>
                                @endif
                                    @foreach($ratings as $rating)
                                        <tr onclick="showContentModal('{{$rating->id}}','{{$rating->comment}}')">
                                            <td>{{$rating->User->full_name}}</td>
                                            <td>{{$rating->point}}</td>
                                            <td class="text-ellipsis max-w-[200px] overflow-hidden">{{$rating->comment}}</td>
                                            <td>{{$rating->created_at}}</td>
                                            <th onclick="event.stopPropagation();">
                                                <x-check-box id="check-item" name="ratingIds[]" value="{{$rating->id}}"/>
                                            </th>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                                @if ($ratings->hasPages())
                                    <x-paginate-container >
                                        {!! $ratings->appends(request()->input())->links('pagination::bootstrap-4') !!}
                                    </x-paginate-container >
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('admin.reportedRatings.elements.modal_rating_content')
@endsection

@section("pagescript")
    <script>
        const STORE_URL = "{{ route('admin.user.store') }}";
        var getDistrictsUrl = "{{ route('admin.user.getDistricts') }}";
        const BLOCK_URL= "{{url('/admin/user/block')}}";
        const UNBLOCK_URL= "{{url('/admin/user/unblock')}}";
        const RESET_PASSWORD_URL= '{{url('admin/user/reset-password')}}';
        const BLOCK_RATING="{{url('admin/reported/block')}}";
        const UNBLOCK_RATING="{{url('admin/reported/unblock')}}";
        const GET_REPORTS_URL="{{url('/admin/reported/getReports')}}"
    </script>
    <script src="{{ asset('js/admin/reportedRating/index.js?t='.config('constants.app_version') )}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

@endsection


