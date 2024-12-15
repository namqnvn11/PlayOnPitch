<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Play On Pitch</title>
    <link rel="stylesheet" href="{{ asset('css/voucher.css') }}">
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

<div class="profile-container">
    <div class="sidebar">
        <div class="user-info">
            <p>Anh/Chị <strong>{{ Auth::user()->full_name}}</strong></p>
        </div>
        <ul class="menu">
            <li><a href="{{route("user.history.index")}}"> <i class="fa fa-history"></i>&nbsp;Lịch sử đặt sân</a></li>
            <li><a href="{{route("user.profile.index")}}"> <i class="fa fa-info-circle"></i>&nbsp;Thông tin cá nhân</a></li>
            <li><a href="{{route("user.my_voucher.index")}}"><i class="fa-solid fa-ticket"></i>&nbsp;Voucher của bạn</a></li>
            <li style="background-color: #F4F4F4"><a href="#"  style="color: #4CAF50;"><i class="fa-solid fa-retweet"  style="color: #4CAF50;"></i>&nbsp;Đổi voucher</a></li>
        </ul>
        <a href="{{route("user.logout")}}"><button class="logout-btn">Đăng xuất</button></a>
    </div>

    <div class="profile-details">
        <h2>Đổi voucher</h2>
        <table>
            <thead>
            <tr>
                <th>Hình ảnh</th>
                <th>Tên voucher</th>
                <th>Giá trị voucher</th>
                <th>Ngày bắt đầu</th>
                <th>Ngày kết thúc</th>
                <th>Điểm cần dùng</th>
                <th>Hành động</th>
            </tr>
            </thead>
            <tbody>
            @foreach($vouchers as $voucher)
            @if($voucher->end_date > now())
            <tr>

                <td class=""><img class="max-w-[200px] mx-auto rounded" src="{{$voucher->image->img??asset('img/voucher.jpg')}}" onclick="openImageLayer('{{$voucher->image->img??asset('img/voucher.jpg')}}')"></td>
                <td>{{$voucher->name}}</td>
                <td>{{$voucher->price}}</td>
                <td>{{ \Carbon\Carbon::parse($voucher->release_date)->format('d/m/Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($voucher->end_date)->format('d/m/Y') }}</td>
                <td>{{$voucher->conditions_apply}}</td>
                <td>
                    <form action="{{route("user.voucher.exchangeVoucher")}}" method="post">
                        @csrf
                        <div class="action-btn">
                            <input type="hidden" name="voucher_id" value="{{ $voucher->id }}">
                            <button class="btn-edit">Đổi</button>
                        </div>
                    </form>
                </td>
            </tr>
            @endif
            @endforeach
            </tbody>
        </table>
    </div>
</div>
<!-- Image Zoom Layer -->
<div id="imageLayer" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center hidden z-50 transition-opacity duration-300 opacity-0">
    <div class="relative">
        <!-- Close Button -->
        <button class="absolute top-0 right-2 text-black text-2xl" onclick="closeImageLayer()">×</button>
        <!-- Zoomed Image -->
        <img id="zoomedImage" src="" alt="Zoomed Image" class="max-w-screen-lg max-h-screen rounded-lg shadow-lg">
    </div>
</div>

<div style="background-color: #2e7d32">
    <form id="form-data" method="post">
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
</footer>
</body>

</html>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const STORE_URL = "{{ route('user.storeRegister') }}";
</script>
<!-- jQuery -->
<script src="{{  asset('assets/templates/adminlte3/plugins/jquery/jquery.min.js' ) }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{  asset('assets/templates/adminlte3/plugins/jquery-ui/jquery-ui.min.js' ) }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script src="{{  asset('assets/libraries/toastr/toastr.min.js' ) }}"></script>
<script src="{{  asset('js/notification.js' ) }}"></script>
<script src="{{  asset('js/common.js' ) }}"></script>
<script src="{{asset('js/registerBoss.js?t='.config('constants.app_version'))}}"></script>

<script src="{{ asset('js/user/profile/index.js?t='.config('constants.app_version') )}}"></script>

