<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Play On Pitch</title>
    <link rel="stylesheet" href="{{ asset('css/yarddetail.css') }}">
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
            <li><a href="{{route('user.yardlist.index')}}">Danh sách sân</a></li>
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
        <!-- Main Image and Booking Info Section -->
        <div class="main-section">
            <div class="image-gallery">
                <h2>Sân Phú Thọ</h2>
                <img class="main-image" src="{{asset('img/sanbong.jpg')}}" alt="Main Field Image">

                <div class="thumbnails">
                    <img src="{{asset('img/sanbong.jpg')}}" alt="Thumbnail 1">
                    <img src="{{asset('img/sanbong.jpg')}}" alt="Thumbnail 2">
                    <img src="{{asset('img/sanbong.jpg')}}" alt="Thumbnail 3">
                    <img src="{{asset('img/sanbong.jpg')}}" alt="Thumbnail 4">
                    <img src="{{asset('img/sanbong.jpg')}}" alt="Thumbnail 4">
                </div>
            </div>

            <div class="booking-info">
                <div class="booking-controls">
                <select class="time-select">
                    <option value="">Chọn giờ</option>
                </select>
                <button class="book-now">Đặt sân ngay</button>
                </div>

                <div class="owner-info">
                    <h3>THÔNG TIN CHỦ SÂN</h3>
                    <p><i class="fa fa-user"></i> Anh Tài</p>
                    <p><i class="fa fa-phone"></i> 0123456789</p>
                    <p><i class="fa fa-envelope"></i> taint@vtca.edu.vn</p>
                    <p><i class="fa fa-map-marker"></i> 182 lê đại hành, phường, quận 11, TP HCM</p>
                    <img class="map" src="{{asset('img/sanbong.jpg')}}" alt="Map Image">
                </div>
            </div>
        </div>

        <!-- General Information Section -->
        <div class="general-info">
            <h3>Giới thiệu chung</h3>
            <p>...</p> <!-- Replace with actual description content -->
        </div>
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

<script> const getDistrictsUrl = "{{ route('boss.yard.getDistricts') }}";</script>

<script src="{{ asset('js/user/home/index.js?t='.config('constants.app_version') )}}"></script>