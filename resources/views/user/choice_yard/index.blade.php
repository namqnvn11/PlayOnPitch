<!DOCTYPE html>
<html lang="vi">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Play On Pitch</title>
    <link rel="stylesheet" href="{{ asset('css/choiceyard.css') }}">
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
            <li><a href="{{route('user.policy.index')}}">Chính sách</a></li>
            <li><a href="{{route('user.clause.index')}}">Điều khoản</a></li>
            <li><a href="#">Lợi ích chủ sân</a></li>
            <li><a href="#footer">Liên hệ</a></li>
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
<form id="bookingForm" action="{{ route('user.choice_yard.store.Reservation') }}" method="POST">
    @csrf
    <div class="booking-container">
        <div class="step-indicator">
            <div class="step active">
                <i class="fa fa-th-large"></i>
                <span>Chọn sân</span>
            </div>
            <span class="arrow">></span>
            <div class="step">
                <i class="fa fa-credit-card"></i>
                <span>Thanh toán</span>
            </div>
            <span class="arrow">></span>
            <div class="step">
                <i class="fa fa-ticket-alt"></i>
                <span>Thông tin đặt sân</span>
            </div>
        </div>

        <div class="time-selector">
            <select id="dateSelector" name="reservation_date">
                <option value="">Chọn ngày</option>
                @foreach ($dates as $date)
                    <option value="{{ $date }}">{{ \Carbon\Carbon::parse($date)->translatedFormat('D d/m') }}</option>
                @endforeach
            </select>
        </div>
        <div class="booking-content">
            <div class="booking-table">
                <table class="booking-table1">
                    <thead>
                    <tr>
                        <th></th>
                        @foreach ($timeSlots as $slot)
                            <th>{{ $slot->time_slot }}</th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($yards as $yard)
                        <tr>
                            <td class="sticky left-0">{{ $yard->yard_name }}</td>
                            @foreach($timeSlots as $slot)
                                <td class="selectable"></td>
                            @endforeach
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="booking-info">
                <p><strong>{{$yard->boss->company_name}}</strong></p>
                <p>{{ $yard->boss->company_address}}</p>
                <p id="selectedDate"></p>
                {{--<p id="selected-field"></p>--}}
                <p id="selected-yard"></p>
                <p id="selected-timeslot"></p>
                <input type="hidden" name="reservation_time_slot[]" id="selected-timeslot-input">
                <input type="hidden" name="yard_id[]" value="{{$yard->id}}">
                <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                <input type="text" placeholder="Họ và tên" value="{{Auth::user()->full_name}}">
                <input type="tel" placeholder="Số điện thoại" value="{{Auth::user()->phone}}">
                <p>Tổng tiền: <strong id="totalPrice">0 đ</strong></p>
                <input type="hidden" name="total_price" id="totalPrice-hidden">
                <button type="submit" >Tiếp tục</button>
            </div>
        </div>
    </div>
</form>

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
</footer>
</body>
</html>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    const STORE_URL = "{{ route('user.storeRegister') }}";
</script>
<script src="{{asset('assets/libraries/toastr/toastr.min.js' ) }}"></script>
<script src="{{asset('js/notification.js')}}"></script>
<script src="{{asset('js/registerBoss.js?t='.config('constants.app_version'))}}"></script>

<script src="{{ asset('js/user/choice_yard/index.js?t='.config('constants.app_version') )}}"></script>
