<div class="modal fade" id="modal-edit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditLabel">{{ 'Edit Profile' }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form method="POST" action="{{ route('user.profile.update') }}" enctype="multipart/form-data" id="form-edit">
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
                    <div class="form-group">
                        <label for="full_name">Full Name</label>
                        <input type="text" name="full_name" class="form-control" value="{{ old('full_name', $user->full_name) }}">
                        @error('full_name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Phone Field -->
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                        @error('phone')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Province Field -->
                    <div class="form-group">
                        <label for="province">Province</label>
                        <select name="province" id="province_id" class="form-control">
                            <option value="">Select Province</option>
                            @foreach ($provinces as $province)
                                <option value="{{ $province->id }}"
                                    {{ old('province', $user->province_id) == $province->id ? 'selected' : '' }}>
                                    {{ $province->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('province')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- District Field -->
                    <div class="form-group">
                        <label for="district">District</label><select name="district" id="district_id" class="form-control">
                            <option value="">Select District</option>
                            @foreach ($districts as $district)
                                <option value="{{ $district->id }}"
                                    {{ old('district', $user->district_id) == $district->id ? 'selected' : '' }}>
                                    {{ $district->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('district')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                        <!-- Address Field -->
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" name="address" class="form-control" value="{{ old('address', $user->address) }}">
                            @error('address')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" onclick="submitForm(event)">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
