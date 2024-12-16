<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Play On Pitch</title>
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
            <li><a href="{{route('user.yardlist.index')}}">Danh sách sân</a></li>
            <li><a href="{{route('user.policy.index')}}">Chính sách</a></li>
            <li><a href="{{route('user.clause.index')}}">Điều khoản</a></li>
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

<a href="{{route('login')}}">
    <div class="banner">
        <img src="{{asset('img/banner.jpg')}}" alt="">
    </div>
</a>

<div class="profile-container">
    <div class="sidebar">
        <div class="user-info">
            <p>Anh/Chị <strong>{{ Auth::user()->full_name}}</strong></p>
        </div>
        <ul class="menu">
            <li><a href="{{route("user.history.index")}}"> <i class="fa fa-history"></i>&nbsp;Lịch sử đặt sân</a></li>
            <li style="background-color: #F4F4F4"><a href="#"  style="color: #4CAF50;"> <i class="fa fa-info-circle" style="color: #4CAF50;"></i>&nbsp;Thông tin cá nhân</a></li>
            <li><a href="{{route("user.my_voucher.index")}}"><i class="fa-solid fa-ticket"></i>&nbsp;Voucher của bạn</a></li>
            <li><a href="{{route("user.voucher.index")}}"><i class="fa-solid fa-retweet"></i>&nbsp;Đổi voucher</a></li>
        </ul>
        <a href="{{route("user.logout")}}"><button class="logout-btn">Đăng xuất</button></a>
    </div>

    <div class="profile-details relative bg-gray-200">
        <div class="absolute top-10 right-[100px]">
            <div class="">
                <img src="{{Auth::user()->image->img??"https://t4.ftcdn.net/jpg/05/49/98/39/360_F_549983970_bRCkYfk0P6PP5fKbMhZMIb07mCJ6esXL.jpg"}}" class="rounded-full w-[100px] h-[100px]" width="100px">
                <div
                    class="bg-black absolute bottom-[4px] right-0 rounded-full w-[28px] h-[28px] hover:bg-gray-700 hover:scale-110 transition-all duration-300 cursor-pointer flex items-center justify-center"
                    onclick="showModalUpdateImage()"
                >
                    <i class="bi bi-pencil text-[20px] text-white hover:text-yellow-500 transition-colors duration-300"></i>
                </div>
            </div>
        </div>
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
                <span>{{ Auth::user()->address?(Auth::user()->address . ", " . Auth::user()->District?->name . ", " . Auth::user()->District?->Province?->name) : ''}}</span>
            </div>

            <button class="edit-btn js-on-edit" data-bs-toggle="modal" data-bs-target="#editInfoModal" onclick="openEditModal()">Chỉnh sửa</button>
            <button class="edit-btn js-on-edit" data-bs-toggle="modal" data-bs-target="#changePasswordModal" style="width: 20%">Đổi mật khẩu</button>
        </div>
    </div>
</div>

<div>
    <form action="{{route('user.storeRegister')}}" method="post">
        @csrf
        <section class="registration">
            <div class="form">
                <h2 style="margin-right: 250px">Bạn muốn đăng ký sử dụng website quản lý sân bóng MIỄN PHÍ?</h2>
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
            <li><a href="{{route('user.commodity_policy.index')}}">Chính sách đặt sân</a></li>
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
        <hr class="dividers" style="width: 40vh"/>
        <br><br>
        <a href="https://www.facebook.com/profile.php?id=61569828033426" target="_blank"><i class="fa-brands fa-facebook fa-2xl" style="color: #ffffff;"></i></a>
        &nbsp;&nbsp;
        <a href="https://www.tiktok.com/@playonpitch.sg" target="_blank"><i class="fa-brands fa-tiktok fa-2xl" style="color: #000000;"></i></a>
    </div>
</footer>
</body>

</html>

@include('user.profile.elements.modal_edit')
<script>
    function openEditModal() {
        var myModal = new bootstrap.Modal(document.getElementById('modal-edit'));
        myModal.show();
    }

    function closeModal() {
        var myModal = new bootstrap.Modal(document.getElementById('modal-edit'));
        myModal.hide();
    }

</script>
@include('user.profile.elements.changePassword')
@include('user.profile.elements.modal_image')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const STORE_URL = "{{ route('user.storeRegister') }}";
</script>
<!-- jQuery -->
<script src="{{asset('assets/templates/adminlte3/plugins/jquery/jquery.min.js' ) }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('assets/templates/adminlte3/plugins/jquery-ui/jquery-ui.min.js' ) }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script src="{{asset('assets/libraries/toastr/toastr.min.js' ) }}"></script>
<script src="{{asset('js/notification.js' ) }}"></script>
<script src="{{asset('js/common.js' ) }}"></script>
<script src="{{asset('js/registerBoss.js?t='.config('constants.app_version'))}}"></script>

<script src="{{ asset('js/user/profile/index.js?t='.config('constants.app_version') )}}"></script>
