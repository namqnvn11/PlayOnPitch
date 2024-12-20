<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Play On Pitch</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/invoice.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
            <li><a href="{{ Auth::check() ? route('user.home.index') : route('guest.home.index') }}"><i class="fas fa-home"></i></a></li>
            <li>
                <a href="{{ Auth::check() ? route('user.yardlist.index') : route('guest.yardlist.index') }}">Danh sách sân</a>
            </li>
            <li>
                <a href="{{ Auth::check() ? route('user.policy.index') : route('guest.policy.index') }}">Chính sách</a>
            </li>
            <li>
                <a href="{{ Auth::check() ? route('user.clause.index') : route('guest.clause.index') }}">Điều khoản</a>
            </li>
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

<div class="invoice-container">
    <div class="steps">
        <div class="step">
            <i class="fa fa-th-large"></i>
            <span>Chọn sân</span>
        </div>
        <div class="arrow">></div>
        <div class="step">
            <i class="fa fa-credit-card"></i>
            <span>Thanh toán</span>
        </div>
        <div class="arrow">></div>
        <div class="step active">
            <i class="fa fa-ticket-alt"></i>
            <span>Thông tin đặt sân</span>
        </div>
    </div>

    <div class="invoice">
        <h2>Hóa đơn</h2>
        <hr>
        <div class="invoice-info">
            <p><strong>Sân:</strong> <span>{{ $boss->company_name }}</span></p>
            <p><strong>Địa chỉ:</strong> <span>{{ $boss->company_address }}</span></p>
            <div class="flex justify-between">
                <div class="font-bold">Vị trí:</div>
                <div class="w-[64%]">
                    @foreach($groupedSchedules as $aYardSchedule)
                        <div class="mb-1">
                            {{$aYardSchedule[0]->Yard->yard_name}}:
                            @foreach($aYardSchedule as $slot)
                                {{$slot->time_slot}}
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
            <p><strong>Thanh toán lúc:</strong> <span>{{ $invoice->created_at }}</span></p>
            <p><strong>Trạng thái:</strong> <span>Đã thanh toán bằng {{$invoice->payment_method}}</span></p>
        </div>
        <hr>
        <div class="customer-info">
            <p><strong>Người đặt:</strong> <span>{{ $reservation->Contact->name??''}}</span></p>
            <p><strong>Số điện thoại:</strong> <span>{{ $reservation->Contact->phone??'' }}</span></p>
            <p><strong>Email:</strong> <span>{{ $reservation->user->email??'trống' }}</span></p>
        </div>
        <hr>
        <div class="total-info">
            <p><strong>Tổng tiền:</strong> <span>{{ number_format($reservation->total_price, 0, ',', '.') }} vnd</span></p>

                <p><strong>Loại thanh toán:</strong> <span>{{$reservation->deposit_amount!=0?'Đặt cọc 20%':'Trả toàn bộ'}}</span></p>

            <p><strong>Đã thanh toán:</strong> <span>{{ number_format($reservation->deposit_amount==0?$reservation->total_price:$reservation->deposit_amount, 0, ',', '.') }} vnd</span></p>
        </div>
        <hr>
        <button class="export-invoice" id="export-invoice">Xuất hóa đơn</button>
    </div>
</div>

<div>
    <form action="{{ Auth::check() ? route('user.storeRegister') : route('guest.storeRegister') }}" method="post">
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
            <li>
                <a href="{{ Auth::check() ? route('user.privacy_policy.index') : route('guest.privacy_policy.index') }}">
                    Chính sách bảo mật
                </a>
            </li>
            <li>
                <a href="{{ Auth::check() ? route('user.cancellation_policy.index') : route('guest.cancellation_policy.index') }}">
                    Chính sách hủy (đổi trả)
                </a>
            </li>
            <li>
                <a href="{{ Auth::check() ? route('user.commodity_policy.index') : route('guest.commodity_policy.index') }}">
                    Chính sách đặt sân
                </a>
            </li>
            <li>
                <a href="{{ Auth::check() ? route('user.payment_policy.index') : route('guest.payment_policy.index') }}">
                    Chính sách thanh toán
                </a>
            </li>
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
<script>
    const STORE_URL = "{{ route('user.storeRegister') }}";

    document.querySelector('.export-invoice').addEventListener('click', function () {
        window.print();
    });
</script>
<script src="{{asset('assets/libraries/toastr/toastr.min.js' ) }}"></script>
<script src="{{asset('js/notification.js')}}"></script>
<script src="{{asset('js/registerBoss.js?t='.config('constants.app_version'))}}"></script>

