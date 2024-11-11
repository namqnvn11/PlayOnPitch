<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Play On Pitch</title>
    @vite('resources/css/home.css')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{  asset('assets/templates/adminlte3/plugins/fontawesome-free/css/all.min.css' ) }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{  asset('assets/templates/adminlte3/dist/css/ionicons.min.css' ) }}">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{  asset('assets/templates/adminlte3/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css' ) }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{  asset('assets/templates/adminlte3/plugins/icheck-bootstrap/icheck-bootstrap.min.css' ) }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{  asset('assets/templates/adminlte3/plugins/jqvmap/jqvmap.min.css' ) }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{  asset('assets/templates/adminlte3/dist/css/adminlte.min.css' ) }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{  asset('assets/templates/adminlte3/plugins/overlayScrollbars/css/OverlayScrollbars.min.css' ) }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{  asset('assets/templates/adminlte3/plugins/daterangepicker/daterangepicker.css' ) }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{  asset('assets/templates/adminlte3/plugins/summernote/summernote-bs4.min.css' ) }}">
    <link rel="stylesheet" href="{{  asset('assets/libraries/toastr/toastr.min.css' ) }}">
    <link rel="stylesheet" href="{{  asset('css/custom.css?v='.config('constant.app_version') ) }}">
</head>
<body>
<header>
    <div class="top-section">
        <h3>Logo và tên sân</h3>
    </div>
    <hr class="divider" />
    <nav class="nav-menu">
        <ul>
            <li><a href="#"><i class="fas fa-home"></i></a></li>
            <li><a href="#">Danh sách sân</a></li>
            <li><a href="#">Giới thiệu</a></li>
            <li><a href="#">Điều khoản</a></li>
            <li><a href="#">Lợi ích chủ sân</a></li>
            <li><a href="#">Liên hệ</a></li>
        </ul>

        <div class="auth-button">
            <button><i class="fa-solid fa-user" style="color: #ffffff;"></i> Đăng nhập/ Đăng ký</button>
        </div>
    </nav>
</header>

<div class="banner">
    <img src="{{ asset('img/banner.jpg') }}" alt="Banner">
</div>


<div class="container mt-4">
    <div class="row">
        <!-- Phần bên trái: Menu -->
        <div class="col-lg-4 col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    <h4>Anh: {{ Auth::user()->full_name ?? 'Tên người dùng' }}</h4>
                </div>
                <div class="list-group list-group-flush">
                    <a href="#" class="list-group-item list-group-item-action">Lịch sử đặt sân</a>
                    <a href="#" class="list-group-item list-group-item-action">Thông tin cá nhân</a>
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="list-group-item list-group-item-action text-danger">Đăng xuất</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Phần bên phải: Thông tin cá nhân và các nút thao tác -->
        <div class="col-lg-8 col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    <h4>Thông Tin Cá Nhân</h4>
                </div>
                <div class="card-body">
                    <!-- Hiển thị thông tin cá nhân -->
                    <p><strong>Tên:</strong> {{ Auth::user()->full_name ?? 'Chưa cập nhật' }}</p>
                    <p><strong>Email:</strong> {{ Auth::user()->email ?? 'Chưa cập nhật' }}</p>
                    <p><strong>Số điện thoại:</strong> {{ Auth::user()->phone ?? 'Chưa cập nhật' }}</p>
                    <p><strong>Tỉnh/Thành Phố:</strong> {{ Auth::user()->Province->name ?? 'Chưa cập nhật' }}</p>
                    <p><strong>Quận/Huyện:</strong> {{ Auth::user()->District->name ?? 'Chưa cập nhật' }}</p>
                    <p><strong>Địa chỉ:</strong> {{ Auth::user()->address ?? 'Chưa cập nhật' }}</p>

                    <!-- Nút Chỉnh sửa thông tin và Đổi mật khẩu -->
                    <div class="text-center mt-4">
                        <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#editInfoModal" onclick="openEditModal()">Chỉnh sửa thông tin</button>
                        <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#changePasswordModal">Đổi mật khẩu</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div style="background-color: #2e7d32">
    <section class="registration">
        <div class="form">
            <h2>Bạn muốn đăng ký sử dụng<br> website quản lý sân bóng MIỄN PHÍ?</h2>
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

@include('user.editProfile')
<script>
    function openEditModal(){
        var _modal = $('#modal-edit');
        _modal.modal('show');
    }
    function closeModal(){
        var _modal = $('#modal-edit');
        _modal.modal('hide');
    }
</script>
@include('user.changePassword')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- jQuery -->
<script src="{{  asset('assets/templates/adminlte3/plugins/jquery/jquery.min.js' ) }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{  asset('assets/templates/adminlte3/plugins/jquery-ui/jquery-ui.min.js' ) }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script src="{{  asset('assets/libraries/toastr/toastr.min.js' ) }}"></script>
<script src="{{  asset('js/notification.js' ) }}"></script>
<script src="{{  asset('js/common.js' ) }}"></script>
<script src="{{ asset('js/user/profile/index.js') }}"></script>
</body>
</html>
