<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Play On Pitch</title>
    <link rel="stylesheet" href="{{ asset('css/clause.css') }}">
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
        <h1>Terms</h1>
    </div>

    <div class="policy-content">
        <h2>TERMS OF OPERATION</h2>
        <p>TERMS OF OPERATION OF THE ONLINE PLATFORM</p>
        <p>ONLINE FIELD BOOKING PLATFORM <a href="https://www.PlayOnPitch.online">WWW.PLAYONPITCH.ONLINE</a></p>
        <p><a href="https://www.PlayOnPitch.online">PlayOnPitch.online</a> is an online field booking platform serving merchants, organizations, and individuals who want to create online storefronts to showcase and post listings for renting out sports fields and fitness facilities.</p>
        <p><a href="https://www.PlayOnPitch.online">PlayOnPitch.online</a> is designed to maximize support for customers who want to explore online information about various sports training and competition fields or need to book sports fields online.</p>

        <h3>I. General Principles</h3>
        <p>The online field booking platform <a href="https://www.PlayOnPitch.online">PlayOnPitch.online</a> is operated and managed by Three-Member LLC. Members of the platform include merchants, organizations, and individuals engaged in lawful commercial activities, officially recognized by <a href="https://www.PlayOnPitch.online">PlayOnPitch.online</a>, and permitted to use the services provided by the platform and related parties.</p>
        <p>These principles apply to members who register to use the platform, create storefronts, advertise, sell products/services, or promote products/services on <a href="https://www.PlayOnPitch.online">PlayOnPitch.online</a>.</p>
        <p>Merchants, organizations, and individuals participating in transactions on <a href="https://www.PlayOnPitch.online">PlayOnPitch.online</a> are free to negotiate, respecting the lawful rights and interests of all parties involved in renting products/services through contracts, provided they do not violate legal regulations.</p>
        <p>Products/services traded on <a href="https://www.PlayOnPitch.online">PlayOnPitch.online</a> must comply with all relevant legal regulations and not fall into categories prohibited for business or advertisement under the law.</p>
        <p>Transactions conducted through <a href="https://www.PlayOnPitch.online">PlayOnPitch.online</a> must be transparent and open, ensuring consumer rights are protected.</p>
        <p>All content within these regulations must comply with Vietnam’s legal system. Members participating in <a href="https://www.PlayOnPitch.online">PlayOnPitch.online</a> must understand their legal responsibilities under the current Vietnamese laws and commit to following the platform's regulations.</p>

        <h3>II. General Regulations</h3>
        <p>Domain Name of the Online Field Booking Platform: The online field booking platform <a href="https://www.PlayOnPitch.online">PlayOnPitch.online</a> is developed by Vitex Vietnam Software Joint Stock Company with the domain name: <a href="https://www.PlayOnPitch.online">https://www.PlayOnPitch.online</a> (hereinafter referred to as “the Online Field Booking Platform PlayOnPitch”).</p>
        <p>General Definitions:</p>
        <p>Field Owners/Providers (Suppliers, Partners): These are merchants, organizations, or individuals who wish to use PlayOnPitch services, including creating storefronts, advertising products/services for renting sports fields, introducing their companies, and running promotional campaigns.</p>
        <p>Renters/Customers: These are merchants, organizations, or individuals seeking information about sports field rental products/services listed on <a href="https://www.PlayOnPitch.online">PlayOnPitch.online</a>.</p>
        <p>Members: This term includes both Field Owners/Providers and Renters.</p>
        <ul>
            <li>Members engaging in transactions on the platform are merchants, organizations, or individuals with a need to buy or sell products/services on the website.</li>
            <li>Members must register and provide their initial personal information, which must be verified and officially recognized by the platform management, to use the services provided by <a href="https://www.PlayOnPitch.online">PlayOnPitch.online</a>.</li>
            <li>When you register as a member of the platform, you understand that:
                <ul>
                    <li>You can create your personal account to use the platform.</li>
                    <li>You can purchase products/services at the listed prices and standards as committed by legitimate merchants published on the platform.</li>
                </ul>
            </li>
            <li>The contents of these regulations comply with the current laws of Vietnam. Members participating in <a href="https://www.PlayOnPitch.online">PlayOnPitch.online</a> must understand their legal responsibilities under Vietnam’s current laws and commit to adhering to the terms outlined in these regulations.</li>
        </ul>

        <h3>III. Transaction Process</h3>
        <p><a href="https://www.PlayOnPitch.online">PlayOnPitch.online</a> is designed to help members easily find available sports fields at their desired times and book directly on the PlayOnPitch system without having to make numerous phone calls.</p>

        <h3>1. Process for Renters</h3>
        <p>When looking for a sports field, members can follow these steps:</p>
        <ul>
            <li>Step 1: Register a legal account on the platform.</li>
            <li>Step 2: Log in to the PlayOnPitch system.</li>
            <li>Step 3: Search for sports fields by selecting the sport, location, and pressing the search button.</li>
            <li>Step 4: Choose the date, start time, and end time for the selected location.</li>
            <li>Step 5: Select the location, date, and available time slot that suits your needs, then click the "Book Field" button.</li>
            <li>Step 6: Verify all booking details.</li>
            <li>Step 7: After booking, members will receive a confirmation notification with all booking details, including the date, time, and location. If "Pay at Field" is selected, members must visit the field to complete the payment, and payment information will be updated in the PlayOnPitch system.</li>
        </ul>

        <h3>2. Process for Field Managers</h3>
        <ul>
            <li>Step 1: After registering as members of PlayOnPitch, sports facilities must sign a partnership agreement to advertise their fields, fitness centers, and related rental services. Once the contract is signed, PlayOnPitch will provide management accounts to the facilities.</li>
            <li>Step 2: Log in to the PlayOnPitch system using the provided account.</li>
            <li>Step 3: Managers can view all booking details, including specific dates and times, and payment information (deposits, completed payments).</li>
            <li>Step 4: Managers can easily update orders (beyond those created by users) in the system by clicking on a date and selecting the time. The system will automatically update newly created orders by the manager. Managers can also update users' payment statuses by confirming or canceling orders directly in the system.</li>
        </ul>

        <h3>3. Delivery and Handover Service</h3>
        <p>Customers who rent sports fields or facilities for training or competition will receive a confirmation email after selecting and booking the field online. Upon arrival at the field, customers are requested to present this email, SMS, or registered information to complete the check-in process.</p>

        <h3>4. Warranty Policy</h3>
        <p>PlayOnPitch is responsible for assisting partners, field owners, and facility managers in uploading images and rental schedules to the platform. If partners encounter any issues related to using the services, we will provide support and warranty services for the issue.</p>
        <p>For customers booking sports fields through PlayOnPitch, the responsibility for ensuring service quality lies with the partners or field owners renting the field.</p>
        <p>We recommend that customers contact our online support team directly to receive helpful information about sports fields, facilities, and the service quality policies of each partner advertising on PlayOnPitch.</p>

        <h3>5. Order Confirmation and Cancellation Process</h3>
        <p>Order cancellations will follow the policies of each sports field (members are advised to carefully read the information or contact the field directly to learn about cancellation terms).</p>
        <p>Order Confirmation:</p>

        <ul>
            <li>Order confirmations will be sent directly to members via email immediately after a successful booking.</li>
            <li>Field managers may call members if additional information is needed.</li>
            <li>Order confirmations for deposits or "Pay at Field" bookings will be processed within 24 hours from the booking time or within 3 hours if the booking duration is less than 24 hours.</li>
        </ul>
        <p>Order Cancellation</p>
        <ul>
            <li>PlayOnPitch reserves the right to delay any transaction reasonably suspected of being fraudulent, unlawful, or linked to any criminal activity, or if there are grounds to believe that a member has violated the terms and conditions of this service.</li>
            <li>For PlayOnPitch and field managers: Both can log into the system, select the bookings to be canceled, and execute the cancellation command. The system will automatically update the information and send a cancellation confirmation email to the member.</li>
        </ul>

        <h3>6. Dispute Resolution Process</h3>
        <p>PlayOnPitch and sports facilities are responsible for receiving and handling complaints from members related to transactions conducted on the website <a href="https://www.PlayOnPitch.online">www.PlayOnPitch.online</a>.</p>
        <p>Members have the right to file complaints regarding service quality discrepancies or disclosed payment information causing damage to them. Upon receiving such feedback, PlayOnPitch will verify the information. If the complaint is valid, appropriate measures will be taken promptly depending on the severity of the issue.</p>
        <p>Steps for Dispute Resolution:</p>
        <p>Step 1: Receive Complaints</p>
        <p>Members can submit feedback or complaints using the following methods:</p>
        <ul>
            <li>Send a letter via postal mail to the official address of PlayOnPitch (include detailed issues and any supporting documents to facilitate processing and resolving the complaint).</li>
            <li>Call the Customer Service department via Hotline: 0868 988 143. The Customer Service team will document the member’s complaint and forward it to relevant departments for resolution. (Members must provide necessary information or documents when requested by the Customer Service team.)</li>
            <li>Send directly to the website’s email address: namhuynhkhachoai@gmail.com</li>
        </ul>
        <p>Step 2: Analysis and Evaluation</p>
        <p>Within 24 hours (excluding Saturdays, Sundays, and public holidays) of receiving a complaint, PlayOnPitch will investigate, verify, analyze, and evaluate the issue raised by the member.</p>
        <p>Step 3: Collect Information and Resolve the Complaint</p>
        <p>After clarifying the complaint, PlayOnPitch will compile the necessary information and process the resolution based on its regulations.</p>
        <p>Step 4: Respond to the Customer</p>
        <p>Within 24 working hours of receiving the complaint, PlayOnPitch will provide a written response or communicate with the member via other means such as email, phone, or fax. If the complaint is complex and requires additional time, PlayOnPitch will contact the customer directly to extend the response time, which will not exceed 60 working hours.</p>
        <p>Step 5: Conclusion</p>
        <p>PlayOnPitch adheres to legal regulations regarding the protection of member rights. Therefore, sports facilities listed on the website are required to provide accurate, truthful, and detailed information about their services. Any fraudulent activity will be condemned and held fully accountable under the law.</p>
        <p>PlayOnPitch publicly discloses its dispute resolution mechanisms to address issues arising from transactions on the website. If users face conflicts with service providers or suffer damages, PlayOnPitch will accept feedback, resolve related issues, and actively support members in protecting their legitimate rights and interests.</p>
        <p>PlayOnPitch uses a dispute resolution process based on mutual agreement. Disputes will be initially resolved through indirect communication via phone or email. If unresolved, direct meetings will be arranged to address issues and achieve the most beneficial resolution for all parties involved.</p>
        <p>Both sports facilities and members, along with PlayOnPitch, are responsible for actively resolving disputes. Sports facilities must provide verified documentation related to the issue. Members must provide accurate tangible and intangible information regarding the conflict. PlayOnPitch will assess the information, determine the liable party, and propose compensation agreements between both sides to resolve the issue satisfactorily.</p>
        <p>If the fault lies with the sports facility, PlayOnPitch may issue warnings, require full reimbursement of costs incurred by the member, or demand that the service quality matches what was advertised. Repeat violations may result in the removal of the facility’s information from the PlayOnPitch platform.</p>
        <p>If disputes cannot be resolved through negotiation, PlayOnPitch will escalate the matter to competent legal authorities to ensure the legitimate rights and interests of all parties, especially the customer.</p>

        <h3>IV. Transaction Security</h3>
        <p>The management team employs services to protect information posted by field owners/providers on PlayOnPitch. This ensures that transactions are successfully conducted with minimal risks.</p>
        <p>Field owners/providers must provide complete information (name, address, phone number, email) for each service listing.</p>
        <p>Renters should not share payment details with anyone via email or other communication methods. PlayOnPitch is not responsible for damages or risks incurred from information exchanged outside the platform.</p>
        <p>If renters contact field owners directly without using the PlayOnPitch online booking system, they must carefully consider payment arrangements in advance.</p>
        <p>Renters are strictly prohibited from using programs, tools, or other methods to interfere with the system or alter data structures. Disseminating, promoting, or encouraging activities that disrupt or damage the website system is strictly prohibited. Any violations will be addressed according to PlayOnPitch regulations and legal provisions.</p>
        <p>All transaction information is protected, except in cases where disclosure is required by law enforcement authorities.</p>

        <h3>V. Protection of Members' Personal Information</h3>
        <h3>1. Purpose of Collecting Personal Information</h3>
        <p>Personal information collected will only be used internally within the company. “Personal Information” refers to information about customers that can be used to identify the customer's identity, including, but not limited to, name, ID number, birth certificate number, passport number, nationality, address, phone number, credit card or debit card details, race, gender, date of birth, email address, or any other information provided by the customer in registration forms or similar forms, and/or any information that has been or can be collected, stored, used, and processed by the company over time. This includes sensitive personal information such as health data, religion, or similar beliefs.</p>
        <p>When a member registers an account on the PlayOnPitch e-commerce platform, the company may use and process the customer’s personal information for business purposes and other activities, including but not limited to the following purposes (“Purposes”):</p>
        <ul>
            <li>Forwarding orders from members to partner sports facilities where the member has booked a sports session.</li>
            <li>Notifying members about their bookings and providing customer support.</li>
            <li>Verifying the reliability of members.</li>
            <li>Providing a payment gateway with necessary information to process transactions if members choose online payment methods.</li>
            <li>Confirming and/or processing payments as per agreements.</li>
            <li>Fulfilling the company’s obligations under any contracts signed with customers.</li>
            <li>Providing customers with services as per agreements.</li>
            <li>Handling customer participation in events, promotional programs, activities, research, contests, promotional surveys, or other activities, and communicating with customers about their participation.</li>
            <li>Processing, managing, or verifying customers’ service usage requests under agreements.</li>
            <li>Developing, enhancing, and providing requested services to meet customer needs.</li>
            <li>Handling refunds, discounts, and/or fees as per agreements.</li>
            <li>Facilitating or enabling any audits required under agreements.</li>
            <li>Responding to inquiries, opinions, and feedback from customers.</li>
            <li>Serving internal purposes such as audits, data analysis, and database maintenance.</li>
            <li>Detecting, preventing, and prosecuting criminal activities.</li>
            <li>Complying with the company’s legal obligations.</li>
            <li>Sending customers notifications, newsletters, updates, packages, promotional materials, special offers, and holiday greetings from the company, partners, advertisers, and/or sponsors.</li>
            <li>Notifying and inviting customers to events or activities organized by the company, partners, advertisers, and/or sponsors.</li>
            <li>Sharing customer personal information with the company’s affiliated companies, including subsidiaries, associated companies, and/or organizations under the parent company’s control (“Group”), as well as with the company’s third-party agents, suppliers, developers, advertisers, partners, event companies, or sponsors who may contact customers for any reason.</li>
        </ul>
        <p>Order details of members will be stored securely, but for security reasons, members cannot request this information directly from PlayOnPitch. However, members can review their order details by logging into their personal accounts on PlayOnPitch. There, members can fully track their order history. Customers must ensure their login information is kept confidential and not disclosed to third parties.</p>
        <p>If customers do not agree to the company using their personal information for any of the above purposes, please notify the company in advance using the contact information provided on the website/application.</p>
        <p>In case of any changes to the personal information provided by the customer to the company, such as changes to the email address, phone number, payment details, or if customers wish to cancel their accounts, please update this information by sending a request to the contact information provided on the website/application.</p>
        <p>The company will make the requested changes to the best of its ability within a reasonable time after receiving the notification.</p>
        <p>By submitting information, customers agree to its use as specified in the registration form and the Terms of Use.</p>

        <h3>2. Scope of Information Use</h3>
        <p>The PlayOnPitch online field booking platform does not sell, share, or exchange personal information collected on the website with any third parties.</p>
        <ul>
            <li>The Three-Member LLC will provide sports facilities with necessary information to process orders and manage bookings. If members choose online payment methods, the company will provide a payment gateway with the required details to process payments. All transaction information will be secured, but in the case of legal requirements, we will provide such information to law enforcement authorities.</li>
            <li>After a booking is successfully made, only employees of Vitex Vietnam Software Joint Stock Company and the member can access the personal information section.</li>
            <li>Information will be stored on the PlayOnPitch system, managed at the office of Vitex Vietnam Software Joint Stock Company.</li>
            <li>Members can change, view, or delete their information by logging into the “Personal Page” section or sending an email to us at namhuynhkhachoai@gmail.com.</li>
        </ul>

        <h3>3. Information Retention Period</h3>
        <p>The PlayOnPitch online field booking platform will store members' personal information on our internal systems during service provision or until the collection purpose is fulfilled, or the customer requests the deletion of provided information.</p>

        <h3>4. Address of the Information Collection and Management Unit for the PlayOnPitch Online Field Booking Platform:</h3>
        <ul>
            <li>Address: 184 Le Dai Hanh, Ward 17, District 11, Ho Chi Minh City</li>
            <li>Tel/Fax: 0868 988 143</li>
            <li>Email: namhuynhkhachoai@gmail.com</li>
        </ul>

        <h3>5. Tools and Means for Users to Access and Edit Their Personal Data</h3>
        <p>Members can change, view, or delete their information by logging into the “Members” section on the PlayOnPitch online field booking platform or by emailing us at namhuynhkhachoai@gmail.com for assistance.</p>

        <h3>6. Commitment to Protect Customers' Personal Information</h3>
        <p>The PlayOnPitch online field booking platform commits not to sell, exchange, or share information that could lead to the disclosure of members’ personal information for commercial purposes, violating the commitments set forth in the customer information privacy policy.</p>
        <p>The PlayOnPitch online field booking platform will not share members’ information except in specific cases such as:</p>
        <ul>
            <li>When required by law from a government agency or when we believe such action is necessary and appropriate to comply with legal requirements.</li>
            <li>To protect the PlayOnPitch online field booking platform and other third parties: We will only disclose account and other personal information when we are certain that such disclosure is in compliance with the law and protects the rights and property of service users, PlayOnPitch, and other third parties.</li>
            <li>The most limited amount of personal information may be shared with third parties or sponsors. This summarized information will not include full member details and is only intended to identify certain users of the PlayOnPitch service.</li>
        </ul>
        <p>In other cases, we will provide specific notice to members when disclosing information to a third party, and such information will only be shared with the member's consent.</p>

        <h3>7. Information Protection Agreement</h3>
        <p>The PlayOnPitch online field booking platform has the responsibility to require information-handling parties and contracting parties to ensure measures for safeguarding against loss, unauthorized access, misuse, alteration, or disclosure of personal data. PlayOnPitch has agreements and mechanisms in place to control members' and partners' personal information, ensuring responsibility for safeguarding personal data through the following methods:</p>
        <ul>
            <li>Educating members and partners on PlayOnPitch's internal policies.</li>
            <li>Formal contracts.</li>
            <li>Requiring members and partners to comply with the principles set forth by PlayOnPitch.</li>
            <li>Adhering to relevant rules and laws.</li>
        </ul>

        <h3>8. Handling Member Complaints Related to Information Security</h3>
        <p>Upon receiving information, the PlayOnPitch online field booking platform will promptly verify and review the complaint. If the complaint is valid, PlayOnPitch will contact the member directly to address the issue with a corrective and goodwill approach. If both parties cannot reach an agreement, the matter will be referred to the People's Court of Hanoi for resolution.</p>

        <h3>VI. Terms of Commitment</h3>
        <ul>
            <li>All members and partners using PlayOnPitch are deemed to have agreed to comply with these regulations.</li>
            <li>For any questions or concerns, partners and members are encouraged to contact PlayOnPitch via the following information:</li>
            <li>Official contact address for the PlayOnPitch website:</li>
            <li>PlayOnPitch Online Field Booking Platform</li>
            <li>Three-Member LLC</li>
            <li>Address: 184 Le Dai Hanh, Ward 17, District 11, Ho Chi Minh City</li>
            <li>Tel: 0868 988 143</li>
            <li>Email: namhuynhkhachoai@gmail.com</li>
        </ul>


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


