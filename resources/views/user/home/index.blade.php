<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Play On Pitch</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
<header>
    <div class="top-section">
        <a href="#"><img src="{{asset('img/logotext.png')}}" alt="" style="width: 350px; height: 50px;"></a>
    </div>
    <hr class="divider" />
    <nav class="nav-menu">
        <ul>
            <li><a href="#"><i class="fas fa-home"></i></a></li>
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

<section class="search-section">
    <div class="search-container">
        <img src="{{ asset('img/360_F_355288042_An4jhyVFELBAY05m97yMQYDTDpNKeeJf.jpg') }}" alt="">
        <form action="{{ route('user.yardlist.index') }}" method="GET" class="search-bar">
            <select name="province_id" id="province_id">
                <option value="">Tỉnh/Thành Phố</option>
                @foreach($Province as $province)
                    <option value="{{ $province->id }}" {{ request('province_id') == $province->id ? 'selected' : '' }}>
                        {{ $province->name }}
                    </option>
                @endforeach
            </select>

            <select name="district_id" id="district_id">
                <option value="">Quận/Huyện</option>
                @if(request('province_id'))
                    @foreach($District->where('province_id', request('province_id')) as $district)
                        <option value="{{ $district->id }}" {{ request('district_id') == $district->id ? 'selected' : '' }}>
                            {{ $district->name }}
                        </option>
                    @endforeach
                @endif
            </select>

            <input type="text" placeholder="Tên sân" name="yard_name" value="{{ request('yard_name') }}">
            <button type="submit">Tìm kiếm</button>
        </form>
    </div>
</section>

<section class="features">
    <div class="feature">
        <img src="{{asset('img/san.jpg')}}" alt="Tìm kiếm" style="margin-bottom: 16px">
        <p>Tìm kiếm vị trí sân</p>
        <span>Dữ liệu sân đấu dồi dào, liên tục cập nhật, giúp bạn dễ dàng tìm kiếm theo khu vực mong muốn.</span>
    </div>
    <div class="feature">
        <img src="{{asset('img/lich.jpg')}}" alt="Đặt lịch">
        <p>Đặt lịch Online</p>
        <span>Không cần đến trực tiếp, không cần gọi điện đặt lịch, bạn hoàn toàn có thể đặt sân ở bất kì đâu có internet.</span>
    </div>
    <div class="feature">
        <img src="{{asset('img/dabong.jpg')}}" alt="Tìm đối bắt cặp">
        <p>Tìm đối bắt cặp đấu</p>
        <span>Tìm kiếm, giao lưu các đội thi đấu thể thao, kết nối, xây dựng cộng đồng thể thao sôi nổi, mạnh mẽ.</span>
    </div>
</section>

<div>
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
<script src="{{asset('assets/libraries/toastr/toastr.min.js' ) }}"></script>
<script src="{{asset('js/notification.js')}}"></script>

<script>
    const getDistrictsUrl = "{{ route('user.home.getDistricts') }}";
    const STORE_URL = "{{ route('user.storeRegister') }}";
</script>

<script src="{{asset('js/registerBoss.js?t='.config('constants.app_version'))}}"></script>
<script src="{{ asset('js/user/home/index.js?t='.config('constants.app_version') )}}"></script>

