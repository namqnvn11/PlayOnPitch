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

    <link
        rel="icon"
        href="{{asset('img/logo.png')}}"
        type="image/x-icon"
    />

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

<div class="invoice-container">
    {{--    <div class="step-indicator">--}}
    {{--        <div class="step">--}}
    {{--            <i class="fa fa-th-large"></i>--}}
    {{--            <span>Choose Yard</span>--}}
    {{--        </div>--}}
    {{--        <div class="arrow">></div>--}}
    {{--        <div class="step">--}}
    {{--            <i class="fa fa-credit-card"></i>--}}
    {{--            <span>Payment</span>--}}
    {{--        </div>--}}
    {{--        <div class="arrow">></div>--}}
    {{--        <div class="step active">--}}
    {{--            <i class="fa fa-ticket-alt"></i>--}}
    {{--            <span>Booking Info</span>--}}
    {{--        </div>--}}
    {{--    </div>--}}

    <div class="flex text-[16px] flex-col">
        <div class="flex justify-center mb-3">
            <div class="flex items-center justify-between w-full max-w-[800px]">
                <div class="flex flex-col items-center">
                    <i class="fa fa-th-large mb-1 text-[24px]"></i>
                    <span>Choose Yard</span>
                </div>
                <div class="text-[18px] text-center">></div>
                <div class="flex flex-col items-center">
                    <i class="fa fa-credit-card mb-1 text-[24px]"></i>
                    <span>Payment</span>
                </div>
                <div class="text-[18px] text-center">></div>
                <div class="flex flex-col text-red-600 items-center">
                    <i class="fa fa-ticket-alt mb-1 text-[24px]"></i>
                    <span>Booking Info</span>
                </div>
            </div>
        </div>


        <div class="invoice">
            <h2>Invoice</h2>
            <hr>
            <div class="invoice-info">
                <div class="mt-2 text-[24px] w-[500px]"><strong>{{ $boss->company_name }}</strong></div>
                <p><strong>Address:</strong> <span>{{ $boss->company_address }}, {{$boss->District->name}}, {{$boss->District->Province->name}}</span></p>
                <div class="flex justify-between">
                    <div class="font-bold">Yards:</div>
                    <div class="w-[64%]">
                        @foreach($groupedSchedules as $aYardSchedule)
                            <div class="mb">
                                {{$aYardSchedule[0]->Yard->yard_name}}:
                                @foreach($aYardSchedule as $slot)
                                    {{$slot->time_slot}}
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
                <p><strong>Payment at</strong> <span>{{ $invoice->created_at }}</span></p>
                <p><strong>Status:</strong> <span>Paid via {{$invoice->payment_method}}</span></p>
            </div>
            <hr>
            <div class="customer-info">
                <p><strong>Customer:</strong> <span>{{ $reservation->Contact->name??''}}</span></p>
                <p><strong>Phone Number:</strong> <span>{{ $reservation->Contact->phone??'' }}</span></p>
                <p><strong>Email:</strong> <span>{{ $reservation->user->email??'Not provide' }}</span></p>
            </div>
            <hr>
            <div class="total-info">
                <p><strong>Total:</strong> <span>{{ number_format($reservation->total_price, 0, ',') }} VND</span></p>

                <p><strong>Payment Type:</strong> <span>{{$reservation->deposit_amount!=0?'Deposit 20%':'Pay in Full'}}</span></p>

                <p><strong>Paid Amount:</strong> <span>{{ number_format($reservation->deposit_amount==0?$reservation->total_price:$reservation->deposit_amount, 0, ',') }} VND</span></p>
            </div>
            <hr>
            <button class="export-invoice rounded" id="export-invoice">Export Invoice</button>
        </div>
    </div>
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

    document.querySelector('.export-invoice').addEventListener('click', function () {
        window.print();
    });
</script>
<script src="{{asset('assets/libraries/toastr/toastr.min.js' ) }}"></script>
<script src="{{asset('js/notification.js')}}"></script>
<script src="{{asset('js/registerBoss.js?t='.config('constants.app_version'))}}"></script>
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

