<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Play On Pitch</title>
    <link rel="stylesheet" href="{{ asset('css/yardlist.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<header>
    <div class="top-section">
        <a href="{{route('user.home.index')}}"><img src="{{asset('img/logotext.png')}}" alt="" style="width: 350px; height: 50px;"></a>
    </div>
    <hr class="divider" />
    <nav class="nav-menu">
        <ul>
            <li><a href="{{route('user.home.index')}}"><i class="fas fa-home"></i></a></li>
            <li><a href="#">Danh sách sân</a></li>
            <li><a href="{{route('user.policy.index')}}">Chính sách</a></li>
            <li><a href="{{route('user.clause.index')}}">Điều khoản</a></li>
            <li><a href="#">Lợi ích chủ sân</a></li>
            <li><a href="#footer">Liên hệ</a></li>
        </ul>

        <div class="auth-button">
            @auth
                <a href="{{route('user.profile.index')}}">
                    <button><i class="fa-solid fa-user" style="color: #ffffff;"></i> {{ Auth::user()->full_name . " | " . Auth::user()->score }}<i class="fa-regular fa-star"></i></button>
                </a>
            @else
                <a href="{{ route('login') }}">
                    <button><i class="fa-solid fa-user" style="color: #ffffff;"></i> Đăng nhập/ Đăng ký</button>
                </a>
            @endauth
        </div>
    </nav>
</header>

<div class="banner">
    <img src="{{asset('img/banner.jpg')}}" alt="">
</div>
<div class="content-wrapper">
<div class="content">

    <h1 class="title">Danh sách sân</h1>

        <form method="GET" action="{{ route('user.yardlist.index') }}">

            <div class="filters-container">

                <div class="filters">

                    <select name="province_id" id="province_id" onchange="this.form.submit()">
                        <option value="">Tỉnh/Thành Phố</option>
                        @foreach($Province as $province)
                            <option value="{{ $province->id }}" {{ request('province_id') == $province->id ? 'selected' : '' }}>
                                {{ $province->name }}
                            </option>
                        @endforeach
                    </select>

                    <select name="district_id" id="district_id" onchange="this.form.submit()" class="w-[160px]">
                        <option value="">Quận/Huyện</option>
                        @if(request('province_id'))
                            @foreach($District->where('province_id', request('province_id')) as $district)
                                <option value="{{ $district->id }}" {{ request('district_id') == $district->id ? 'selected' : '' }}>
                                    {{ $district->name }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
        </form>

    </div>


    <div class="grid grid-cols-4 gap-x-1 gap-y-4 m-3">
        @if($bosses->isEmpty())
            <p class="w-[120%] ml-[12px]">Không có sân nào phù hợp với tiêu chí tìm kiếm.</p>
        @else
            @foreach($bosses as $boss)
                @php
                    $bossId = 1;  // Giả sử bạn muốn lấy các sân của Boss có ID = 1
                    $yardTypes = $boss->yards()
                                    ->where('block', false)
                                    ->distinct('yard_type')
                                    ->pluck('yard_type')
                                    ->implode(', ');
                    $count = $boss->yards()->where('block', false)->count();
                @endphp
                <div class="card flex flex-col justify-between">
                    <img src="{{$boss->images()->first()->img??asset('img/sanbong.jpg')}}" alt="Football Field">
                    <div class="card-content">
                        <h3>{{ $boss->company_name }}</h3>
                        <p>Khu vực: {{ $boss->district->name }} - {{ $boss->district->province->name }}</p>
                        <p>Loại sân: {{$yardTypes}}</p>
                        <p>Tổng sân: {{$count}}</p>
                        <a href="{{ url('user/yarddetail/index') }}/{{$boss->id}}" class="book-button">Đặt sân</a>
                    </div>
                </div>
            @endforeach
        @endif
</div>
    @if ($bosses->hasPages())
        <x-paginate-container >
            {!! $bosses->appends(request()->input())->links('pagination::bootstrap-4') !!}
        </x-paginate-container >
    @endif



</div>

<div style="background-color: #2e7d32">
    <form id="form-data" method="post">
        @csrf
        <section class="registration">
            <div class="form">
                <h2 style="margin-right: 250px">Bạn muốn đăng ký sử dụng<br> website quản lý sân bóng MIỄN PHÍ?</h2>
                <input type="text" placeholder="Nhập họ và tên" name="name">
                <input type="text" placeholder="Nhập số điện thoại" name="phone">
                <input type="text" placeholder="Nhập email" name="email">
                <button type="submit">Gửi</button>
            </div>
        </section>
    </form>
</div>

<footer id="footer">
    <div class="footer-section">
        <h3>GIỚI THIỆU</h3>
        <hr class="dividers" />
        <p>Công ty Play On Pitch cung cấp nền tảng quản lý sân bóng hiệu quả.</p>
        <ul>
            <li><a href="{{route('user.privacy_policy.index')}}">Chính sách bảo mật</a></li>
            <li><a href="{{route('user.cancellation_policy.index')}}">Chính sách hủy (đổi trả)</a></li>
            <li><a href="{{route('user.commodity_policy.index')}}">Chính sách kiểm hàng</a></li>
            <li><a href="{{route('user.payment_policy.index')}}">Chính sách thanh toán</a></li>
        </ul>
    </div>

    <div class="footer-section">
        <h3>THÔNG TIN</h3>
        <hr class="dividers"/>
        <p>Công ty TNHH 3 thành viên</p>
        <p>MST: 1234567890</p>
        <p>Email: namhuynhkhachoai@gmail.com</p>
        <p>Địa chỉ: 184 Lê Đại Hành, Quận 11, TP HCM</p>
        <p>Điện thoại: 0868.986.143</p>
    </div>

    <div class="footer-section">
        <h3>LIÊN HỆ</h3>
        <hr class="dividers" />
        <button>Chăm sóc khách hàng</button>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</footer>
</body>
</html>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script> const getDistrictsUrl = "{{ route('user.yardlist.getDistricts') }}";</script>

<script src="{{ asset('js/user/yard_list/index.js?t='.config('constants.app_version') )}}"></script>
<script>
    const STORE_URL = "{{ route('user.storeRegister') }}";
</script>
<script src="{{asset('assets/libraries/toastr/toastr.min.js' ) }}"></script>
<script src="{{asset('js/notification.js')}}"></script>
<script src="{{asset('js/registerBoss.js?t='.config('constants.app_version'))}}"></script>
