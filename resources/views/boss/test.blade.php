@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>{{ isset($boss) ? 'Update Boss' : 'Create New Boss' }}</h2>

        {{-- Hiển thị lỗi nếu có --}}
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Thông báo thành công nếu có --}}
        @if(session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif

        {{-- Form --}}
        <form action="{{route('admin.boss.store') }}" method="POST" id="bossForm">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $boss->email ?? '') }}" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" {{ isset($boss) ? '' : 'required' }}>
                @if(isset($boss))
                    <small class="form-text text-muted">Leave blank if you don't want to change the password.</small>
                @endif
            </div>

            <div class="mb-3">
                <label for="full_name" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="full_name" name="full_name" value="{{ old('full_name', $boss->full_name ?? '') }}" required>
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $boss->phone ?? '') }}" required>
            </div>

            <div class="mb-3">
                <label for="company_name" class="form-label">Company Name</label>
                <input type="text" class="form-control" id="company_name" name="company_name" value="{{ old('company_name', $boss->company_name ?? '') }}" required>
            </div>

            <div class="mb-3">
                <label for="company_address" class="form-label">Company Address</label>
                <input type="text" class="form-control" id="company_address" name="company_address" value="{{ old('company_address', $boss->company_address ?? '') }}" required>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select id="status" class="form-select" name="status" required>
                    <option value="">Choose...</option>
                    <option value="0" {{ (old('status') ?? $boss->status ?? '') == '0' ? 'selected' : '' }}>Active</option>
                    <option value="1" {{ (old('status') ?? $boss->status ?? '') == '1' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="district_id" class="form-label">District</label>
                <select id="district_id" class="form-select" name="district_id" required>
                    <option value="">Choose...</option>
                    {{-- Giả định có danh sách các quận/huyện --}}
                    @foreach($districts as $district)
                        <option value="{{ $district->id }}" {{ (old('district_id') ?? $boss->district_id ?? '') == $district->id ? 'selected' : '' }}>{{ $district->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">{{ isset($boss) ? 'Update Boss' : 'Create Boss' }}</button>
        </form>
    </div>
@endsection
