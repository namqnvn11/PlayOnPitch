<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Play On Pitch</title>
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
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
                <a href="#">
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

<div class="profile-container">
    <div class="sidebar">
        <div class="user-info">
            <p>Anh/Chị <strong>{{ Auth::user()->full_name}}</strong></p>
        </div>
        <ul class="menu">
            <li><a href="#"> <i class="fa fa-history"></i> Lịch sử đặt sân</a></li>
            <li style="background-color: #F4F4F4"><a href="#"> <i class="fa fa-info-circle" style="color: #4CAF50;"></i> Thông tin cá nhân</a></li>
        </ul>
        <a href="{{route("user.logout")}}"><button class="logout-btn">Đăng xuất</button></a>
    </div>

    <div class="profile-details">
        <h2>Thông tin cá nhân</h2>
        <div class="details-box">
            <div class="info-row">
                <label>Email:</label>
                <span>{{ Auth::user()->email}}</span>
            </div>
            <div class="info-row">
                <label>Tên:</label>
                <span>{{ Auth::user()->full_name}}</span>
            </div>
            <div class="info-row">
                <label>Số điện thoại:</label>
                <span>{{ Auth::user()->phone}}</span>
            </div>
            <div class="info-row">
                <label>Địa chỉ:</label>
                <span>{{ Auth::user()->address}}</span>
            </div>
            <div class="info-row">
                <label>Mật khẩu:</label>
                <span>******** <a href="#">Đổi mật khẩu</a></span>
            </div>
            <button class="edit-btn js-on-edit">Chỉnh sửa</button>
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


<script src="{{ asset('js/user/profile/index.js?t='.config('constants.app_version') )}}"></script>
