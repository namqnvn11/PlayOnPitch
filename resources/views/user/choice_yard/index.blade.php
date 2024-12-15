<!DOCTYPE html>
<html lang="vi">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Play On Pitch</title>
    <link rel="stylesheet" href="{{ asset('css/choiceyard.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
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

        <div class="time-selector flex items-center mt-3">
            <form method="get" id="selectedTime">
                @php
                    $selectedDate=$selectTime??now();
                    $selectedDate= \Carbon\Carbon::parse($selectedDate)->toDateString();
                 @endphp
                <select id="dateSelector" name="selectTime" onchange="ChangeSelectTime(this)" class="px-4 rounded w-[120px]">
                    @foreach ($dates as $date)
                        <option value="{{ $date }}" {{ $date == $selectedDate ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::parse($date)->translatedFormat('D d/m') }}
                        </option>
                    @endforeach
                </select>
            </form>
            <div class="flex ml-4">
                <div class="flex mx-2 items-end">
                    <div>Sân trống</div>
                    <div class="mx-2 w-[50px] h-[30px] bg-white border-[1px] border-black"></div>
                </div>
                <div class="flex mx-2 items-end">
                    <div>Đã đặt</div>
                    <div class="w-[50px] h-[30px] bg-red-400 border-[1px] border-black mx-2"></div>
                </div>
            </div>
        </div>
        <form id="bookingForm" action="{{ route('user.choice_yard.makeReservation') }}" method="POST" onsubmit="preparePayment(event)">
            @csrf
        <div class="booking-content">
            <div class="booking-table">
                @if(count($timeSlots)==0)
                    <div>sân chưa có lịch</div>
                @else
                <table class="booking-table1">
                    <thead>
                    <tr>
                        <th></th>
                        @foreach ($timeSlots as $slot)
                            <th class="">{{ $slot->time_slot }}</th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $currentDateTime = \Carbon\Carbon::now()->addMinutes(30);
                    @endphp

                    @foreach($yards as $yard)
                        <tr>
                            <td class="sticky left-0">{{ $yard->yard_name }}</td>
                            @foreach($yard->YardSchedules as $time)
                                @php
                                    $timeSlotParts = explode('-', $time->time_slot);
                                    $startTime = $timeSlotParts[0];

                                    // Tạo đối tượng Carbon từ date và time_slot
                                    $scheduleDateTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i', $time->date . ' ' . $startTime);
                                    $isPast = $scheduleDateTime->lessThan($currentDateTime);
                                    $isUnavailable = $time->status !== 'available';
                                @endphp

                                <td
                                    class="{{ $isPast || $isUnavailable ? 'bg-red-400' : 'selectable' }}"
                                    scheduleId="{{ $time->id }}"
                                    timeSlot="{{ $time->time_slot }}"
                                    price="{{ $time->price_per_hour }}"
                                    date="{{ $time->date }}"
                                    yard="{{ $yard->yard_name }}"
                                >
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @endif
            </div>
            <div class="booking-info pt-2">
                <div class="text-[20px] font-bold">{{$boss->company_name}}</div>
                <p>{{ $boss->company_address}}, {{$boss->District->name}}, {{$boss->District->Province->name}}</p>
                <p id="selectedDate"></p>
                <p id="selected-yard"></p>
                <p id="selected-timeslot"></p>
                <div id="scheduleListContainer">
{{--                    chứa danh sách id của lịch sân đã chọn--}}
                </div>
                <input type="hidden" name="boss_id" value="{{$boss->id}}">
                <input type="hidden" name="user_id" value="{{Auth::user()->id??null}}">
                <input type="text" placeholder="Họ và tên" value="{{Auth::user()->full_name}}" name="userName" id="userName" oninput="clearError()">
                <input type="text" placeholder="Số điện thoại" value="{{Auth::user()->phone}}" name="phone" id="userPhone" oninput="clearError()">
                <div class="text-[16px] my-2">Tổng tiền: <strong id="totalPrice">0 đ</strong></div>
                <input type="hidden" name="total_price" id="totalPrice-hidden" value="0">
                <span class="text-red-700" id="errorText"></span>
                <button type="submit" class="mt-3">Tiếp tục</button>
            </div>
        </div>
        </form>
    </div>


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
    const CHOICE_YARD_INDEX_URL="{{route('user.choice_yard.index',$boss->id)}}";
</script>

<script src="{{asset('assets/libraries/toastr/toastr.min.js' ) }}"></script>
<script src="{{asset('js/notification.js')}}"></script>
<script src="{{asset('js/registerBoss.js?t='.config('constants.app_version'))}}"></script>

<script src="{{ asset('js/user/choice_yard/index.js?t='.config('constants.app_version') )}}"></script>
