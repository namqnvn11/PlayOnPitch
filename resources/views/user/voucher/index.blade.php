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

    <link
        rel="icon"
        href="{{asset('img/logo.png')}}"
        type="image/x-icon"
    />

</head>
<body>
<header>
    <div class="top-section">
        @if(Auth::check())
            <a href="{{route('user.home.index')}}"><img src="{{asset('img/logotext.png')}}" alt="" style="width: 350px; height: 50px;"></a>
        @else
            <a href="{{route('guest.home.index')}}"><img src="{{asset('img/logotext.png')}}" alt="" style="width: 350px; height: 50px;"></a>
        @endif
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

<div class="profile-container">
    <div class="sidebar">
        <div class="user-info">
            <p>Mr./Ms. <strong>{{ Auth::user()->full_name}}</strong></p>
        </div>
        <ul class="menu">
            <li><a href="{{route("user.history.index")}}"> <i class="fa fa-history"></i>&nbsp;Booking History</a></li>
            <li><a href="{{route("user.profile.index")}}"> <i class="fa fa-info-circle"></i>&nbsp;Personal Information</a></li>
            <li><a href="{{route("user.my_voucher.index")}}"><i class="fa-solid fa-ticket"></i>&nbsp;Your Vouchers</a></li>
            <li style="background-color: #F4F4F4"><a href="#"  style="color: #4CAF50;"><i class="fa-solid fa-retweet"  style="color: #4CAF50;"></i>&nbsp;Redeem Vouchers</a></li>
            <li class="border-green-600 border-1 rounded"><a href="{{route("user.logout")}}" class="flex justify-center text-green-600" style="color: #0b2e13 !important;"><div class="text-[#4CAF50]">Logout</div></a></li>
        </ul>
    </div>

    <div class="profile-details">
        <h2>Redeem Vouchers</h2>
        <table>
            <thead>
            <tr>
                <th>Image</th>
                <th>Voucher Name</th>
                <th>Voucher Value</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Points Required</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($vouchers as $voucher)
            @if($voucher->end_date > now() && $voucher->id!==9999)
            <tr>
                <td class=""><img class="max-w-[200px] mx-auto rounded" src="{{$voucher->image->img??asset('img/voucher.jpg')}}" onclick="openImageLayer('{{$voucher->image->img??asset('img/voucher.jpg')}}')"></td>
                <td>{{$voucher->name}}</td>
                <td>{{number_format($voucher->price,0,',')}} VND</td>
                <td>{{ \Carbon\Carbon::parse($voucher->release_date)->format('d/m/Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($voucher->end_date)->format('d/m/Y') }}</td>
                <td>{{$voucher->conditions_apply}}</td>
                <td>
                    <form action="{{route("user.voucher.exchangeVoucher")}}" method="post">
                        @csrf
                        <div class="action-btn">
                            <input type="hidden" name="voucher_id" value="{{ $voucher->id }}">
                            <button class="btn-edit">Change</button>
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

<div>
    <form action="{{ Auth::check() ? route('user.storeRegister') : route('guest.storeRegister') }}" method="post">
        @csrf
        <section class="registration py-6">
            <div class="form">
                <div class="leading-6 text-[24px] font-bold max-w-[500px]">Do you want to register to use the FREE football yard management website?</div>
                <input type="text" placeholder="Enter full name" name="name">
                <input type="text" placeholder="Enter phone number" name="phone">
                <input type="text" placeholder="Enter email" name="email">
                <button type="submit" class="min-w-[80px]">Submit</button>
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

