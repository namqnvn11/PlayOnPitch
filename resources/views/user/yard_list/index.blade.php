<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Play On Pitch</title>
    <link rel="stylesheet" href="{{ asset('css/yardlist.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
<header>
    <div class="top-section">
        <h3>Logo và tên sân</h3>
    </div>
    <hr class="divider" />
    <nav class="nav-menu">
        <ul>
            <li><a href="{{route('user.home.index')}}"><i class="fas fa-home"></i></a></li>
            <li><a href="#">Danh sách sân</a></li>
            <li><a href="#">Giới thiệu</a></li>
            <li><a href="#">Điều khoản</a></li>
            <li><a href="#">Lợi ích chủ sân</a></li>
            <li><a href="#">Liên hệ</a></li>
        </ul>

        <div class="auth-button">
            @auth
                <a href="{{route('user.profile.index')}}">
                    <button><i class="fa-solid fa-user" style="color: #ffffff;"></i> {{ Auth::user()->full_name }}</button>
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
    <div class="filters-container">
    <div class="filters">
        <select name="province_id" id="province_id">
            <option value="">Tỉnh/Thành Phố</option>
            @foreach($Province as $province)
                <option value="{{ $province->id }}">{{ $province->name }}</option>
            @endforeach
        </select>

        <select name="district_id" id="district_id">
            <option>Quận/Huyện</option>
        </select>
    </div>

    <h1 class="title">Danh sách sân</h1>
    </div>

    <div class="grid">
        <div class="card">
            <img src="{{asset('img/sanbong.jpg')}}" alt="Football Field">
            <div class="card-content">
                <h3>Sân bóng đá Phú Thọ</h3>
                <p>Khu vực: Quận 10 - HCM</p>
                <p>Sân số: 5</p>
                <p class="time-slots">Sân trống: 15h00 16h30 18h00</p>
                <a href="#" class="book-button">Đặt sân</a>
            </div>
        </div>
        <div class="card">
            <img src="{{asset('img/sanbong.jpg')}}" alt="Football Field">
            <div class="card-content">
                <h3>Sân bóng đá Phú Thọ</h3>
                <p>Khu vực: Quận 10 - HCM</p>
                <p>Sân số: 5</p>
                <p class="time-slots">Sân trống: 15h00 16h30 18h00</p>
                <a href="#" class="book-button">Đặt sân</a>
            </div>
        </div>
        <div class="card">
            <img src="{{asset('img/sanbong.jpg')}}" alt="Football Field">
            <div class="card-content">
                <h3>Sân bóng đá Phú Thọ</h3>
                <p>Khu vực: Quận 10 - HCM</p>
                <p>Sân số: 5</p>
                <p class="time-slots">Sân trống: 15h00 16h30 18h00</p>
                <a href="#" class="book-button">Đặt sân</a>
            </div>
        </div>
        <div class="card">
            <img src="{{asset('img/sanbong.jpg')}}" alt="Football Field">
            <div class="card-content">
                <h3>Sân bóng đá Phú Thọ</h3>
                <p>Khu vực: Quận 10 - HCM</p>
                <p>Sân số: 5</p>
                <p class="time-slots">Sân trống: 15h00 16h30 18h00</p>
                <a href="#" class="book-button">Đặt sân</a>
            </div>
        </div>
        <div class="card">
            <img src="{{asset('img/sanbong.jpg')}}" alt="Football Field">
            <div class="card-content">
                <h3>Sân bóng đá Phú Thọ</h3>
                <p>Khu vực: Quận 10 - HCM</p>
                <p>Sân số: 5</p>
                <p class="time-slots">Sân trống: 15h00 16h30 18h00</p>
                <a href="#" class="book-button">Đặt sân</a>
            </div>
        </div>
    </div>
    <button class="load-more">Xem thêm</button>
</div>
</div>


<div style="background-color: #2e7d32">
    <section class="registration">
        <div class="form">
            <h2 style="margin-right: 250px">Bạn muốn đăng ký sử dụng<br> website quản lý sân bóng MIỄN PHÍ?</h2>
            <input type="text" placeholder="Nhập họ và tên">
            <input type="text" placeholder="Nhập số điện thoại">
            <input type="email" placeholder="Nhập email">
            <button>Gửi</button>
        </div>
    </section>
</div>

<footer>
    <div class="footer-section">
        <h3>GIỚI THIỆU</h3>
        <hr class="dividers" />
        <p>Công ty Play On Pitch cung cấp nền tảng quản lý sân bóng hiệu quả.</p>
        <ul>
            <li><a href="#">Chính sách bảo mật</a></li>
            <li><a href="#">Chính sách hủy (đổi trả)</a></li>
            <li><a href="#">Chính sách khách hàng</a></li>
            <li><a href="#">Chính sách thanh toán</a></li>
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
</footer>
</body>
</html>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script> const getDistrictsUrl = "{{ route('user.yardlist.getDistricts') }}";</script>

<script src="{{ asset('js/user/yard_list/index.js?t='.config('constants.app_version') )}}"></script>
