<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Play On Pitch</title>
    <link rel="stylesheet" href="{{ asset('css/policy.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
        <h1>Policy</h1>
    </div>

    <div class="policy-content">
        <h2>Personal Information Protection Policy</h2>
        <h3>1. Purpose of Collecting Personal Information:</h3>
        <p>
            The personal information collected will only be used internally within the company. "Personal Information" refers to customer information that can be used to identify the customer, including, but not limited to, name, ID number, birth certificate number, passport number, nationality, address, phone number, date of birth, credit or debit card details, race, gender, email address, or any other information provided by the customer through registration forms, applications, or any similar documents. It also includes sensitive personal information such as health data, religion, or similar beliefs that have been or can be collected, stored, used, and processed by the company over time.
        </p>
        <p>
            When members register an account on the PlayOnPitch online field booking platform, the company may use and process their personal information for business and operational purposes, including but not limited to the following:
        </p>
        <ul>
            <li>Forwarding orders from members to partner sports facilities where the member has booked a sports session;</li>
            <li>Notifying members about their bookings and providing customer support;</li>
            <li>Verifying the reliability of members;</li>
            <li>Providing payment details necessary to process transactions if the member chooses an online payment method;</li>
            <li>Confirming and/or processing payments as per agreements;</li>
            <li>Fulfilling the company’s obligations under any contracts signed with customers;</li>
            <li>Providing services to customers as per agreements;</li>
            <li>Handling customer participation in events, promotional programs, activities, research, contests, or any other customer-related activities;</li>
            <li>Processing, managing, or verifying customer service requests under agreements;</li>
            <li>Developing, enhancing, and delivering services requested under agreements to meet customer needs;</li>
            <li>Processing refunds, discounts, and/or fees as per agreements;</li>
            <li>Facilitating or enabling any audits required under agreements;</li>
            <li>Responding to customer inquiries, opinions, and feedback;</li>
            <li>Serving internal management purposes such as audits, data analysis, and database maintenance;</li>
            <li>Detecting, preventing, and prosecuting criminal activities;</li>
            <li>Fulfilling the company’s legal obligations;</li>
            <li>Sending customers notifications, newsletters, updates, packages, promotional materials, special offers, and holiday greetings from the company, partners, advertisers, and/or sponsors;</li>
            <li>Notifying and inviting customers to events or activities organized by the company, partners, advertisers, and/or sponsors;</li>
            <li>Sharing customer personal information with related companies, including subsidiaries, affiliates, and/or organizations under the control of the parent company, as well as agents, third-party suppliers, developers, advertisers, partners, event companies, or sponsors who may contact the customer for any reason.</li>
        </ul>

        <p>Members' order details will be securely stored, but for security reasons, members cannot directly request this information from the PlayOnPitch online booking platform. However, members can review their order details by logging into their personal account on the PlayOnPitch.online website. There, members can fully access their order history.</p>
        <p>Customers must ensure that their login information is kept confidential and not disclosed to any third party.</p>
        <p>If customers do not agree to the company using their personal information for any of the above purposes, please notify the company in advance using the contact details provided on the website.</p>
        <p>In case of any changes to the personal information provided to the company, such as changes to email addresses, phone numbers, payment details, or if customers wish to delete their accounts, please update this information by submitting a request to the contact details provided on the website.</p>
        <p>The company will implement these requested changes to the best of its ability within a reasonable timeframe after receiving the notification.</p>
        <p>By submitting their information, customers consent to its use as specified in the registration form and in the Terms of Use.</p>

        <h3>2. Scope of Information Use</h3>
        <p>PlayOnPitch does not sell, share, or exchange members' personal information collected on the website with any third parties.</p>
        <ul>
            <li>The Three-Member LLC will provide partner sports facilities with necessary information to transfer orders to their management team. If members choose online payment, the company will provide the payment gateway with required details for transaction processing. All transaction information will be kept secure; however, in the event of a legal request, we are obligated to provide this information to law enforcement authorities.</li>
            <li>After a booking is successfully made, only employees of the Three-Member LLC and the respective member can access the personal information section.</li>
            <li>Information will be stored in the PlayOnPitch online platform's system and managed directly from the office of Vitex Vietnam Software Joint Stock Company.</li>
            <li>Members can change, view, or delete their information by logging into the “Personal Page” section or by emailing us at namhuynhkhachoai@gmail.com.</li>
        </ul>

        <h3>3. Information Retention Period</h3>
        <p>The PlayOnPitch online booking platform will store members' personal information on our internal systems during the service provision period or until the purpose of data collection is fulfilled, or the customer requests the deletion of the provided information.</p>

        <h3>4. Contact Address of the Personal Information Collection and Management Unit at PlayOnPitch.online:</h3>
        <ul>
            <li>Address: 184 Le Dai Hanh, Ward 17, District 11, Ho Chi Minh City.</li>
            <li>Tel/Fax: 0868.988.143</li>
            <li>Email: namhuynhkhachoai@gmail.com</li>
        </ul>


        <h3>5. Tools and Methods for Users to Access and Edit Their Personal Data</h3>
        <ul>
            <li>Members can change, view, or delete their information by logging into the “Personal Page” section on the PlayOnPitch.online platform or by emailing us at namhuynhkhachoai@gmail.com for assistance.</li>
        </ul>

        <h3>6. Commitment to Protect Customers' Personal Information</h3>
        <p>The PlayOnPitch online field booking platform employs security measures to prevent loss, confusion, or alteration of data in the system.</p>
        <p>PlayOnPitch is committed to not selling, exchanging, or sharing information that could lead to the disclosure of members' personal information for commercial purposes, violating the commitments outlined in the customer information privacy policy.</p>
        <p>PlayOnPitch will not share members' information except in specific cases such as:</p>
        <ul>
            <li>As required by law from a government agency, or when we believe that such action is necessary and appropriate to comply with legal requirements.</li>
            <li>To protect PlayOnPitch and other third parties: We will only disclose account information and other personal details when we are certain that such disclosure complies with the law and protects the rights and property of service users, PlayOnPitch, and other third parties.</li>
            <li>The most limited personal information may be shared with third parties or sponsors. This summarized information will not include complete member details and will only be used to identify specific members using the PlayOnPitch service.</li>
        </ul>
        <p>In all other cases, we will provide specific notice to members when disclosing information to a third party, and such information will only be shared with the member’s consent.</p>

        <h3>7. Information Protection Agreement</h3>
        <p>The PlayOnPitch online field booking platform is responsible for requiring information-handling parties and contractual partners to ensure safeguards against loss, unauthorized access, misuse, alteration, or disclosure of personal data. PlayOnPitch has agreements and mechanisms in place to control the personal information of members and partners to ensure accountability through the following methods:</p>
        <ul>
            <li>Educating partners on the internal policies of the PlayOnPitch platform;</li>
            <li>Formal contracts;</li>
            <li>Requiring partners to adhere to the principles set forth by PlayOnPitch;</li>
            <li>Compliance with applicable rules and laws;</li>
        </ul>

        <h3>8. Handling Member Complaints Related to Information Security</h3>
        <p>Upon receiving information, PlayOnPitch will promptly verify and review the complaint. If the complaint is valid, PlayOnPitch will directly contact the member to address the issue with a corrective and goodwill approach. If both parties cannot reach an agreement, the matter will be referred to the People's Court of Hanoi for resolution.</p>

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


