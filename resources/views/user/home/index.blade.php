<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Play On Pitch</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
            <li><a href="#"><i class="fas fa-home"></i></a></li>
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

<section class="search-section">
    <div class="search-container">
        <img src="{{ asset('img/360_F_355288042_An4jhyVFELBAY05m97yMQYDTDpNKeeJf.jpg') }}" alt="">
        <form action="{{ route(Auth::check() ? 'user.yardlist.index' : 'guest.yardlist.index') }}" method="GET" class="search-bar">
        <select name="province_id" id="province_id" class="focus:ring-0 focus:border-0">
                <option value="">Province</option>
                @foreach($Province as $province)
                    <option value="{{ $province->id }}" {{ request('province_id') == $province->id ? 'selected' : '' }}>
                        {{ $province->name }}
                    </option>
                @endforeach
            </select>

            <select name="district_id" id="district_id" class="focus:ring-0 focus:border-0">
                <option value="">District</option>
                @if(request('province_id'))
                    @foreach($District->where('province_id', request('province_id')) as $district)
                        <option value="{{ $district->id }}" {{ request('district_id') == $district->id ? 'selected' : '' }}>
                            {{ $district->name }}
                        </option>
                    @endforeach
                @endif
            </select>

            <input type="text" placeholder="Yard Name" name="yard_name" value="{{ request('yard_name') }}" class="focus:ring-0 focus:border-0">
            <button type="submit">Search</button>
        </form>
    </div>
</section>

<section class="features">
    <div class="feature">
        <img src="{{asset('img/san.jpg')}}" alt="Search" style="margin-bottom: 16px">
        <p>Search for Yard Locations</p>
        <span>A rich and continuously updated database of sports yards helps you easily search by your desired area.</span>
    </div>
    <div class="feature">
        <img src="{{asset('img/lich.jpg')}}" alt="Book Schedule">
        <p>Online Booking</p>
        <span>No need to visit in person or call to book; you can book a yard from anywhere with internet access.</span>
    </div>
    <div class="feature">
        <img src="{{asset('img/dabong.jpg')}}" alt="Find Match Opponent">
        <p>Find Match Opponents</p>
        <span>Search and connect with sports teams, fostering interaction and building a vibrant, strong sports community.</span>
    </div>
</section>

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
    const getDistrictsUrl = "{{ route(Auth::check() ? 'user.home.getDistricts' : 'guest.home.getDistricts') }}";
    const STORE_URL = "{{ route('user.storeRegister') }}";
</script>

<script src="{{asset('js/registerBoss.js?t='.config('constants.app_version'))}}"></script>
<script src="{{ asset('js/user/home/index.js?t='.config('constants.app_version') )}}"></script>
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



