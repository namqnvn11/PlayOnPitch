<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Play On Pitch</title>
    <link rel="stylesheet" href="{{ asset('css/privacypolicy.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

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

<div class="policy-container">
    <div class="policy-header">
        <h1>Privacy Policy</h1>
    </div>

    <div class="policy-content">
        <h2>Privacy Policy</h2>
        <p>This privacy policy discloses how we collect, store, and process personal information or data (“Personal Information”) of our customers through the Website. We are committed to protecting customers' personal information and will make every effort to use appropriate measures to ensure the information provided by customers during the use of the Website is kept secure and protected from unauthorized access.</p>
        <p>However, we cannot guarantee the prevention of all unauthorized access. In cases of unauthorized access beyond our control, the company will not bear any responsibility for any claims, disputes, or damages arising from or related to such unauthorized access.</p>
        <p>To better understand the policies regarding the collection, storage, and use of personal information from users of this Website, please read the following privacy policies:</p>
        <h3>I. Purpose and Scope of Personal Information Collection</h3>
        <p>To access and use certain services on the Website, you may be required to register personal information with us (Email, Full Name, Contact Phone Number, etc.). All declared information must be accurate and lawful. Our Website is not responsible for any legal issues related to the declared information. We may also collect information about the number of visits, including the number of pages you view, the number of links you click, and other information related to your connection to our Website. We also collect information that your browser uses every time you visit the Website, including IP address, language used, access time, and addresses accessed.</p>
        <h3>II. Scope of Information Use</h3>
        <p>The information collected through <a href="https://www.PlayOnPitch.online">PlayOnPitch.online</a> will help us:</p>
        <ul>
            <li>Support customers when using the field booking service</li>
            <li>Answer customer inquiries</li>
            <li>Conduct customer surveys</li>
            <li>Carry out promotional activities related to the products and services of <a href="https://www.PlayOnPitch.online">PlayOnPitch.online</a></li>
        </ul>
        <p>Customers who request support or have inquiries and wish to provide information to us through <a href="https://www.PlayOnPitch.online">PlayOnPitch.online</a> may be required to register their personal information with us (Email, Full Name, Contact Phone Number, etc.). All declared information must be accurate and lawful. <a href="https://www.PlayOnPitch.online">PlayOnPitch.online</a> is not responsible for any legal issues related to the declared information.</p>
        <p>When necessary, we may use this information to contact you directly through various forms such as sending open letters, order confirmations, thank-you letters, technical and security information, etc.</p>
        <p>We commit to using customers' personal information strictly within the purposes and scope announced. In case of any usage outside of the disclosed purposes and scope, we will notify the customer and only use the information with the customer's consent.</p>
        <h3>III. Information Retention Period</h3>
        <p>We will store the personal information provided by customers in our internal systems during the service provision period or until the purpose of collection is completed or when customers request to delete the provided information.</p>
        <h3>IV. Entities or Organizations That May Access the Information</h3>
        <p>Customers agree that the following entities/organizations/individuals may access and collect their information when necessary:</p>
        <ul>
            <li>Management Board</li>
            <li>Competent state authorities</li>
            <li>Complainants proving violations by the customer (if any)</li>
        </ul>
        <h3>V. Address of the Unit Collecting and Managing Personal Information</h3>
        <p>COMPANY LIMITED by 3 Members</p>
        <p>Address: 184 Le Dai Hanh, Ward 17, District 11, Ho Chi Minh City</p>
        <p>✆Hotline: 0868 988 143</p>
        <p>✉Email: namhuynhkhachoai@gmail.com</p>
        <h3>VI. Commitment to Protect Customers' Personal Information</h3>
        <p>We are committed to protecting your personal information by all possible means. We will use various information security technologies to protect this information from being retrieved, used, or disclosed unintentionally. We recommend that you protect all information related to your access password and do not share it with anyone. If using a shared computer, you should log out or close all open Website windows.</p>
        <h3>VII. Mechanism for Receiving and Resolving Complaints Related to Personal Information</h3>
        <p>Customers have the right to file complaints about personal information being disclosed to third parties to the management board of <a href="https://www.PlayOnPitch.online">PlayOnPitch.online</a>, to the company's address, or via Email: namhuynhkhachoai@gmail.com.</p>
        <p>The company is responsible for implementing technical and professional measures to verify the reflected content.</p>
        <p>The time to process complaints related to personal information is 7 days.</p>
        <h3>VII. Contact Information</h3>
        <p>We always welcome feedback, contact, and responses regarding this “Privacy Policy.” If you have any questions, please contact us by Phone: 0868 988 143, Email: namhuynhkhachoai@gmail.com</p>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    const STORE_URL = "{{ route('user.storeRegister') }}";
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


