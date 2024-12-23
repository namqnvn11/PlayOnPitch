<div class="modal fade" id="modal-edit-user-profile">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditLabel">{{ 'Edit Profile' }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form method="POST" action="{{ route('user.profile.update') }}" enctype="multipart/form-data" id="form-edit-user-profile">
                @csrf
                <input type="hidden" name="id" value="{{ $user->id }}">

                <div class="modal-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <!-- Full Name Field -->
                    <div class="form-group mb-3">
                        <label for="full_name" class="mb-1">Full Name</label>
                        <x-green-input type="text" name="full_name" class="form-control" value="{{ old('full_name', $user->full_name) }}" />
                        @error('full_name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Phone Field -->
                    <div class="form-group mb-3">
                        <label for="phone" class="mb-1">Phone</label>
                        <x-green-input type="text" name="phone" class="form-control rounded" value="{{ old('phone', $user->phone) }}" />
                        @error('phone')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                        <!-- Address Field -->
                        <div class="form-group mb-3">
                            <label for="address" class="mb-1">Address</label>
                            <x-green-input type="text" name="address" class="form-control rounded" value="{{ old('address', $user->address) }}"/>
                            @error('address')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                    <!-- Province Field -->
                    <div class="form-group mb-3">
                        <label for="province" class="mb-1">Province</label>
                        <x-green-select name="province" id="province_id" class="form-control py-2" onchange="provinceOnchange(event)">
                            <option value="">Select Province</option>
                            @foreach ($provinces as $province)
                                <option
                                    value="{{ $province->id }}"
                                    {{ $user->District->Province->id == $province->id ? 'selected' : '' }}
                                >
                                    {{ $province->name }}
                                </option>
                            @endforeach
                        </x-green-select>
                        @error('province')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- District Field -->
                    <div class="form-group">
                        <label for="district" class="mb-1">District</label>
                        <x-green-select name="district" id="district_id" class="form-control py-2">
                            <option value="">Select District</option>
                            @foreach ($districts as $district)
                                <option
                                    value="{{ $district->id }}"
                                    {{ $user->district_id== $district->id ? 'selected' : '' }}
                                >
                                    {{ $district->name }}
                                </option>
                            @endforeach
                        </x-green-select>
                        @error('district')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default mr-1 border hover:bg-gray-100 text-xs font-bold py-[10px] text-gray-500" data-bs-dismiss="modal" >CLOSE</button>
                    <x-green-button type="submit" class="" onclick="submitForm(event)">Save</x-green-button>
                </div>
            </form>
        </div>
    </div>
</div>
