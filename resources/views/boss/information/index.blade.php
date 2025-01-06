@extends("layouts.appboss")
@section('title', $title ?? 'Information')
@section("content")
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Information</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Admin</a></li>
                        <li class="breadcrumb-item active">{{ $title ?? 'Information' }}</li>
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

                        <div class="card-body table-responsive flex justify-center">
                            <form method="post" id="information-form" class="w-[60%]" onsubmit="handleUpdateInformation(event)" action="{{route('boss.information.update')}}">
                                @csrf
                                <input type="hidden" name="boss_id" id="boss_id" value="{{$boss->id}}">

                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="text" name="email" id="email" class="form-control rounded-md border-gray-400" placeholder="Enter email" value="{{$boss->email}}" disabled>
                                    </div>

                                    <div class="form-group">
                                        <label for="full_name">Full Name</label>
                                        <input type="text" name="full_name" id="full_name" class="form-control rounded-md border-gray-400" placeholder="Enter full name" value="{{$boss->full_name}}">
                                    </div>

                                    <div class="form-group">
                                        <label for="phone">Phone</label>
                                        <input type="text" name="phone" id="phone" class="form-control rounded-md border-gray-400" placeholder="Enter phone" value="{{$boss->phone}}">
                                    </div>

                                    <div class="form-group">
                                        <label for="company_name">Company Name</label>
                                        <input type="text" name="company_name" id="company_name" class="form-control rounded-md border-gray-400" placeholder="Enter company name" value="{{$boss->company_name}}">
                                    </div>

                                    <div class="form-group">
                                        <label for="company_address">Company Address</label>
                                        <input type="text" name="company_address" id="company_address" class="form-control rounded-md border-gray-400" placeholder="Enter company address" value="{{$boss->company_address}}">
                                    </div>

                                    <div class="form-group">
                                        <label for="province">Province</label>
                                        <select class="form-control rounded-md" name="province" id="province">
                                            <option value="">Select Province</option>
                                            @foreach($provinces as $province)
                                                <option value="{{ $province->id }}" {{$province->id===$boss->District->Province->id?'selected':''}}>{{ $province->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="district">District</label>
                                        <select class="form-control rounded-md" name="district" id="district">
                                            <option value="">Select District</option>
                                            @foreach($districts as $district)
                                                <option value="{{ $district->id }}" {{$district->id===$boss->District->id?'selected':''}}>{{ $district->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <x-green-button type="submit" class="">Update</x-green-button>
                                </div>
                            </form>
                            <form method="POST" id="password-update-form" class="ml-4 w-[30%]" onsubmit="handleUpdateBossPassword(event)" action="{{route('boss.information.password.update')}}">
                                @csrf
                                <input type="hidden" name="boss_id" id="boss_id" value="{{$boss->id}}">

                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="">Old Password</label>
                                        <input type="password" name="old_password" class="form-control rounded-md border-gray-400" placeholder="" id="old_password">
                                    </div>
                                    <div class="form-group">
                                        <label for="">New Password</label>
                                        <input type="password" name="new_password" class="form-control rounded-md border-gray-400" placeholder="" id="new_password">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Confirm Password</label>
                                        <input type="password" name="new_password_confirmation" class="form-control rounded-md border-gray-400" placeholder="" id="new_password_confirmation">
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <x-green-button type="submit" class="w-[180px]">Update Password</x-green-button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

{{--    include--}}
@endsection

@section("pagescript")
    <script>
        const GET_DISTRICTS_URL = "{{ route('boss.information.getDistricts') }}";
        const UPDATE_INFORMATION_URL = "{{ route('boss.information.update') }}"
        const UPDATE_PASSWORD_URL = "{{ route('boss.information.password.update') }}"

    </script>
    <script src="{{ asset('js/boss/information/index.js?t='.config('constants.app_version') )}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

@endsection


