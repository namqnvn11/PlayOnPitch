<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Play On Pitch</title>
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
            <li><a href="{{route('user.history.index')}}"> <i class="fa fa-history"></i>&nbsp;Booking History</a></li>
            <li style="background-color: #F4F4F4"><a style="color: #4CAF50;" href="{{route("user.profile.index")}}"> <i class="fa fa-info-circle"></i>&nbsp;Personal Information</a></li>
            <li><a href="{{route("user.my_voucher.index")}}"><i class="fa-solid fa-ticket"></i>&nbsp;Your Vouchers</a></li>
            <li><a href="{{route("user.voucher.index")}}"><i class="fa-solid fa-retweet"></i>&nbsp;Redeem Vouchers</a></li>
        </ul>
        <a href="{{route("user.logout")}}"><button class="logout-btn">Logout</button></a>
    </div>

    <div class="profile-details relative bg-gray-200">
        <div class="absolute top-10 right-[100px]">
            <div class="">
                <img src="{{Auth::user()->image->img??"https://t4.ftcdn.net/jpg/05/49/98/39/360_F_549983970_bRCkYfk0P6PP5fKbMhZMIb07mCJ6esXL.jpg"}}" class="rounded-full w-[100px] h-[100px]" width="100px">
                <div
                    class="bg-black absolute bottom-[4px] right-0 rounded-full w-[28px] h-[28px] hover:bg-gray-700 hover:scale-110 transition-all duration-300 cursor-pointer flex items-center justify-center"
                    onclick="showModalUpdateImage()"
                >
                    <i class="bi bi-pencil text-[20px] text-white hover:text-yellow-500 transition-colors duration-300"></i>
                </div>
            </div>
        </div>
        <h2>Personal Information</h2>
        <div class="details-box">
            <div class="info-row">
                <label>Email:</label>
                <span>
                    {{ Auth::user()->email}}
                    @if(Auth::user()->email_verified_at!==null)
                        <i class="bi bi-patch-check-fill text-green-600 text-[24px] ml-2"></i>
                        <p class="inline text-green-700">Verified</p>
                    @endif
                </span>
            </div>
            <div class="info-row">
                <label>Name:</label>
                <span>{{ Auth::user()->full_name}}</span>
            </div>
            <div class="info-row">
                <label>Phone Number:</label>
                <span>{{ Auth::user()->phone?Auth::user()->phone:'Not Provide'}}</span>
            </div>
            <div class="info-row">
                <label>Address:</label>
                <span>{{ Auth::user()->address?(Auth::user()->address . ", " . Auth::user()->District?->name . ", " . Auth::user()->District?->Province?->name) : 'Not Provide'}}</span>
            </div>

        </div>
        <div class="flex w-full">
            <button class="edit-btn js-on-edit" data-bs-toggle="modal" data-bs-target="#editInfoModal" onclick="openEditModal()">Edit Info</button>
            <button class="edit-btn js-on-edit ml-2" data-bs-toggle="modal" data-bs-target="#changePasswordModal" style="width: 21%">Change Password</button>
            @if(Auth::user()->email_verified_at===null)
                <a href="{{route('verification.notice')}}"><button class="edit-btn ml-2" type="submit">Verify you account</button></a>
            @endif
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
        <hr class="dividers" style="width: 40vh"/>
        <br><br>
        <a href="https://www.facebook.com/profile.php?id=61569828033426" target="_blank"><i class="fa-brands fa-facebook fa-2xl" style="color: #ffffff;"></i></a>
        &nbsp;&nbsp;
        <a href="https://www.tiktok.com/@playonpitch.sg" target="_blank"><i class="fa-brands fa-tiktok fa-2xl" style="color: #000000;"></i></a>
    </div>
</footer>
</body>

</html>

@include('user.profile.elements.modal_edit')
<script>
    function openEditModal() {
        var myModal = new bootstrap.Modal(document.getElementById('modal-edit'));
        myModal.show();
    }

    function closeModal() {
        var myModal = new bootstrap.Modal(document.getElementById('modal-edit'));
        myModal.hide();
    }

</script>
@include('user.profile.elements.changePassword')
@include('user.profile.elements.modal_image')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const STORE_URL = "{{ route('user.storeRegister') }}";
</script>
<!-- jQuery -->
<script src="{{asset('assets/templates/adminlte3/plugins/jquery/jquery.min.js' ) }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('assets/templates/adminlte3/plugins/jquery-ui/jquery-ui.min.js' ) }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script src="{{asset('assets/libraries/toastr/toastr.min.js' ) }}"></script>
<script src="{{asset('js/notification.js' ) }}"></script>
<script src="{{asset('js/common.js' ) }}"></script>
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
