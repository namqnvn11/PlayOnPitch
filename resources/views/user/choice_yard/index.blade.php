<!DOCTYPE html>
<html lang="en">
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
            <li><a href="{{ Auth::check() ? route('user.home.index') : route('guest.home.index') }}"><i class="fas fa-home"></i></a></li>
            <li>
                <a href="{{ Auth::check() ? route('user.yardlist.index') : route('guest.yardlist.index') }}">Yard List</a>
            </li>
            <li>
                <a href="{{ Auth::check() ? route('user.policy.index') : route('guest.policy.index') }}">Policy</a>
            </li>
            <li>
                <a href="{{ Auth::check() ? route('user.clause.index') : route('guest.clause.index') }}">Terms</a>
            </li>
            <li><a href="#footer">Contact</a></li>
        </ul>

        <div class="auth-button">
            @auth
                <a href="{{route('user.profile.index')}}">
                    <button><i class="fa-solid fa-user" style="color: #ffffff;"></i> {{ Auth::user()->full_name . " | " . Auth::user()->score }}<i class="fa-regular fa-star"></i></button>
                </a>
            @else
                <a href="{{ route('login') }}">
                    <button><i class="fa-solid fa-user" style="color: #ffffff;"></i> Login/ Register</button>
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

<div class="booking-container">

{{--    <div class="step-indicator">--}}
{{--        <div class="step active">--}}
{{--            <i class="fa fa-th-large"></i>--}}
{{--            <span>Choose Yard</span>--}}
{{--        </div>--}}
{{--        <span class="arrow">></span>--}}
{{--        <div class="step">--}}
{{--            <i class="fa fa-credit-card"></i>--}}
{{--            <span>Payment</span>--}}
{{--        </div>--}}
{{--        <span class="arrow">></span>--}}
{{--        <div class="step">--}}
{{--            <i class="fa fa-ticket-alt"></i>--}}
{{--            <span>Booking Info</span>--}}
{{--        </div>--}}
{{--    </div>--}}
    <div class="flex text-[16px] flex-col">
        <div class="flex justify-center mb-3">
            <div class="flex items-center justify-between w-full max-w-[800px]">
                <div class="flex flex-col text-red-600 items-center">
                    <i class="fa fa-th-large mb-1 text-[24px]"></i>
                    <span>Choose Yard</span>
                </div>
                <div class="text-[18px] text-center">></div>
                <div class="flex flex-col items-center">
                    <i class="fa fa-credit-card mb-1 text-[24px]"></i>
                    <span>Payment</span>
                </div>
                <div class="text-[18px] text-center">></div>
                <div class="flex flex-col items-center">
                    <i class="fa fa-ticket-alt mb-1 text-[24px]"></i>
                    <span>Booking Info</span>
                </div>
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
                <div>Available</div>
                <div class="mx-2 w-[50px] h-[30px] bg-white border-[1px] border-black"></div>
            </div>
            <div class="flex mx-2 items-end">
                <div>Booked</div>
                <div class="w-[50px] h-[30px] bg-red-400 border-[1px] border-black mx-2"></div>
            </div>
        </div>
    </div>
    @php
        $name= Auth::check()?'user':'guest';
        $makeReservationLink= route($name.'.choice_yard.makeReservation');
    @endphp
    <form id="bookingForm" action="{{$makeReservationLink}}" method="POST" onsubmit="preparePayment(event)">
        @csrf
        <div class="booking-content">
            <div class="booking-table">
                @if(count($timeSlots)==0)
                    <div>No schedule available for this yard.</div>
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
                                <td class="sticky left-0">{{ $yard->yard_name }} ({{$yard->yard_type}})</td>
                                @forelse($yard->YardSchedules as $time)
                                    @php
                                        $timeSlotParts = explode('-', $time->time_slot);
                                        $count=$yard->YardSchedules->count();
                                        $startTime = $timeSlotParts[0];
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
                                @empty
                                    <td colspan="{{$count??0}}" class="bg-red-400">
                                    </td>
                                @endforelse
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
                <div id="scheduleListContainer"></div>
                @if(Auth::check())
                    <input type="hidden" name="boss_id" value="{{$boss->id}}">
                    <input type="hidden" name="user_id" value="{{Auth::user()->id??null}}">
                    <input type="text" placeholder="Full Name" value="{{Auth::user()->full_name}}" name="userName" id="userName" oninput="clearError()">
                    <input type="text" placeholder="Phone Number" value="{{Auth::user()->phone}}" name="phone" id="userPhone" oninput="clearError()">
                @else
                    <input type="hidden" name="boss_id" value="{{$boss->id}}">
                    <input type="hidden" name="user_id">
                    <input type="text" placeholder="Full Name" name="userName" id="userName" oninput="clearError()">
                    <input type="text" placeholder="Phone Number" name="phone" id="userPhone" oninput="clearError()">
                @endif
                <div class="text-[16px] my-2">Total: <strong id="totalPrice">0 </strong> <span>VND</span></div>
                <input type="hidden" name="total_price" id="totalPrice-hidden" value="0">
                <span class="text-red-700" id="errorText"></span>
                <button type="submit" class="mt-3">Continue</button>
            </div>
        </div>
    </form>
</div>


<div>
    <form action="{{ Auth::check() ? route('user.storeRegister') : route('guest.storeRegister') }}" method="post">
        @csrf
        <section class="registration">
            <div class="form">
                <h2 style="margin-right: 250px">Do you want to register to use the FREE football yard management website?</h2>
                <input type="text" placeholder="Enter full name" name="name">
                <input type="text" placeholder="Enter phone number" name="phone">
                <input type="text" placeholder="Enter email" name="email">
                <button type="submit">Submit</button>
            </div>
        </section>
    </form>
</div>

<footer id="footer">
    <div class="footer-section">
        <h3>ABOUT US</h3>
        <hr class="dividers" />
        <p>Play On Pitch provides an efficient platform for football yard management.</p>
        <ul>
            <li>
                <a href="{{ Auth::check() ? route('user.privacy_policy.index') : route('guest.privacy_policy.index') }}">
                    Privacy Policy
                </a>
            </li>
            <li>
                <a href="{{ Auth::check() ? route('user.cancellation_policy.index') : route('guest.cancellation_policy.index') }}">
                    Cancellation Policy (Returns & Exchanges)
                </a>
            </li>
            <li>
                <a href="{{ Auth::check() ? route('user.commodity_policy.index') : route('guest.commodity_policy.index') }}">
                    Booking Policy
                </a>
            </li>
            <li>
                <a href="{{ Auth::check() ? route('user.payment_policy.index') : route('guest.payment_policy.index') }}">
                    Payment Policy
                </a>
            </li>
        </ul>
    </div>

    <div class="footer-section">
        <h3>INFORMATION</h3>
        <hr class="dividers"/>
        <p>Công ty TNHH 3 thành viên</p>
        <p>Tax Code: 1234567890</p>
        <p>
            Email:
            <span style="cursor: pointer;" onclick="navigator.clipboard.writeText('namhuynhkhachoai@gmail.com')">namhuynhkhachoai@gmail.com</span>
        </p>
        <p>Address: 184 Lê Đại Hành, District 11, TP HCM</p>
        <p>
            Phone:
            <span style="cursor: pointer;" onclick="navigator.clipboard.writeText('0868986143')">0868.986.143</span>
        </p>
    </div>

    <div class="footer-section">
        <h3>CONTACT</h3>
        <hr class="dividers" style="width: 40vh" />
        <br><br>
        <a href="https://www.facebook.com/profile.php?id=61569828033426" target="_blank">
            <i class="fa-brands fa-facebook fa-2xl" style="color: #ffffff;"></i>
        </a>
        &nbsp;&nbsp;
        <a href="https://www.tiktok.com/@playonpitch.sg" target="_blank">
            <i class="fa-brands fa-tiktok fa-2xl" style="color: #000000;"></i>
        </a>
    </div>
</footer>
</body>
</html>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    const STORE_URL = "{{ route('user.storeRegister') }}";
    const CHOICE_YARD_INDEX_URL = "{{ route('user.choice_yard.index', $boss->id) }}";
</script>

<script src="{{ asset('assets/libraries/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('js/notification.js') }}"></script>
<script src="{{ asset('js/registerBoss.js?t=' . config('constants.app_version')) }}"></script>
<script src="{{ asset('js/user/choice_yard/index.js?t=' . config('constants.app_version')) }}"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Khi trang bắt đầu tải, thêm lớp 'loading'
        document.body.classList.add("loading");

        // Khi trang đã tải xong, xóa lớp 'loading'
        window.onload = function () {
            document.body.classList.remove("loading");
        };

        // Khi người dùng rời khỏi trang (chuyển trang hoặc tải lại)
        window.addEventListener("beforeunload", function () {
            document.body.classList.add("loading");
        });
    });
</script>

