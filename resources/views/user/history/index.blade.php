<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Play On Pitch</title>
    <link rel="stylesheet" href="{{ asset('css/history.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
            <li style="background-color: #F4F4F4"><a href="#"  style="color: #4CAF50;"> <i class="fa fa-history"></i>&nbsp;Lịch sử đặt sân</a></li>
            <li><a href="{{route("user.profile.index")}}"> <i class="fa fa-info-circle"></i>&nbsp;Thông tin cá nhân</a></li>
            <li><a href="{{route("user.my_voucher.index")}}"><i class="fa-solid fa-ticket"></i>&nbsp;Voucher của bạn</a></li>
            <li><a href="{{route("user.voucher.index")}}"><i class="fa-solid fa-retweet"></i>&nbsp;Đổi voucher</a></li>
        </ul>
        <a href="{{route("user.logout")}}"><button class="logout-btn">Đăng xuất</button></a>
    </div>

    <div class="history-section">
        <h2 class="section-title">Lịch sử đặt sân</h2>
        <div class="booking-list">
            @forelse ($histories as $history)
                @if ($history->Reservation?->YardSchedules?->count()!==0)
                    @php
                    $boss=$history->Reservation->YardSchedules->first()->Yard->Boss
                    @endphp
                    <div class="booking-item">
                        <div class="booking-details">
                            <img src="{{$boss->images->first()->img??asset('img/sanbong.jpg')}}" alt="Hình sân bóng">
                            <div></div>
                            <div class="details">
                                <p><strong>Mã:</strong> {{ $history->reservation->code ?? 'Không có mã' }}</p>
                                @if ($history->reservation->YardSchedules->first())
                                    <h6>{{$boss->company_name }}</h6>
                                    <h6>{{ $boss->company_address .", " . $boss->district->name . ", " . $boss->district->province->name  }}</h6>
                                @else
                                    <p>Không tìm thấy thông tin sân</p>
                                @endif
                            </div>
                        </div>
                        <div class="booking-status">
                            <p class="status success">Thành công</p>
                            <p><strong>Tổng tiền:</strong> {{ number_format($history->reservation->total_price ?? 0, 0, ',', '.') }}đ</p>
                            <p><strong>Đã cọc:</strong> {{ number_format($history->reservation->deposit_amount ?? 0, 0, ',', '.') }}đ</p>
                            <button class="reorder-btn" onclick="redirectToInvoice({{ $history->reservation->invoice->id ?? '' }})">Xem hóa đơn</button>
                            <button class="reorder-btn" onclick="redirectToYardDetail({{ $history->reservation->YardSchedules->first()->yard->boss->id ?? '' }})">Đặt lại</button>
                        </div>
                    </div>
                @endif
            @empty
                <p>Không có lịch sử đặt sân nào.</p>
            @endforelse
        </div>
    </div>

</div>
<button id="showMoreBtn" class="show-more-btn">Xem thêm</button>

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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const STORE_URL = "{{ route('user.storeRegister') }}";

    function redirectToInvoice(reservationId) {
        window.location.href = `/user/invoice/index/${reservationId}`;
    }

    function redirectToYardDetail(yardId) {
        window.location.href = `/user/yarddetail/index/${yardId}`; // Điều hướng tới chi tiết sân
    }
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
<script src="{{  asset('js/user/history.js' ) }}"></script>

<script src="{{ asset('js/user/profile/index.js?t='.config('constants.app_version') )}}"></script>
