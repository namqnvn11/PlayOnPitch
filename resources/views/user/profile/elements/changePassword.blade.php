<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordModalLabel">Đổi Mật Khẩu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form for changing password -->
                <form action="{{ url('/user/profile/password_update') }}" method="POST" id="changePasswordForm">
                    @csrf

                    <!-- Current Password Field -->
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Current Password</label>
                        <input type="password" class="form-control focus:ring-1 focus:ring-green-600 focus:border-green-600 rounded @error('current_password') is-invalid @enderror" id="current_password" name="current_password" autocomplete="off" value="{{ old('current_password') }}"/>
                        @error('current_password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- New Password Field -->
                    <div class="mb-3">
                        <label for="new_password" class="form-label">New Password</label>
                        <input type="password" class="form-control focus:ring-1 focus:ring-green-600 focus:border-green-600 @error('new_password') is-invalid @enderror rounded" id="new_password" name="new_password" autocomplete="off" value="{{ old('new_password') }}">
                        @error('new_password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Confirm New Password Field -->
                    <div class="mb-3">
                        <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control focus:ring-1 focus:ring-green-600 focus:border-green-600 @error('new_password_confirmation') is-invalid @enderror rounded" id="new_password_confirmation" name="new_password_confirmation" autocomplete="off" value="{{ old('new_password_confirmation') }}">
                        @error('new_password_confirmation')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default mr-1 border hover:bg-gray-100 text-xs font-bold py-[10px] text-gray-500" data-bs-dismiss="modal">CLOSE</button>
                        <x-green-button type="submit" class="btn" >Save</x-green-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
