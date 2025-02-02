<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Play On Pitch</title>
    <link rel="stylesheet" href="{{ asset('css/user/payment.css') }}">
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

<div class="payment-container">

    <div class="flex text-[16px] flex-col">
        <div class="flex justify-center mb-3">
            <div class="flex items-center justify-between w-full max-w-[800px]">
                <div class="flex flex-col items-center">
                    <i class="fa fa-th-large mb-1 text-[24px]"></i>
                    <span>Choose Yard</span>
                </div>
                <div class="text-[18px] text-center">></div>
                <div class="flex flex-col text-red-600 items-center">
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

        @php
         $subTotal= $total_price??null;
         $discount= 0;
         $userId=$currentUser->id??null;

         $name= Auth::check()?'user':'guest';
        @endphp

        <div class="p-6 rounded mx-auto border bg-white max-w-screen-lg w-full">
            <div class="flex flex-col lg:flex-row lg:justify-center">
                <div class="mx-4 lg:w-1/2">
                    <form action="{{url($name.'/payment/cancel')}}" method="post" id="form-cancel">
                        @csrf
                        @foreach($yardSchedules as $yardSchedule)
                            <input type="hidden" name="ids[]" value="{{$yardSchedule->id}}">
                        @endforeach
                        <div class="flex hover:text-red-500 ">
                            <button type="submit" class="mb-3 text-[20xp] mr-2" onclick="localStorage.clear()"><i class="bi bi-caret-left-fill"></i> Cancel</button>
                            <div id="countdown"></div>
                        </div>
                    </form>
                    <div class="payment-info">
                        <div class="mt-2 text-[24px] w-[500px]"><strong>{{$boss->company_name}}</strong></div>
                        <p><strong>Address:</strong> <span>{{$boss->company_address}}, {{$boss->District->name}}, {{$boss->Province->name}}</span></p>
                        <div class="flex justify-between">
                            <div class="font-bold">Yards:</div>
                            <div class="w-[70%]">
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
                        <p><strong>Time:</strong> <span>{{$yardSchedule->date}}</span></p>
                    </div>
                    <hr>
                    <div class="customer-info">
                        <p><strong>Customer:</strong> <span>{{$contact->name??''}}</span></p>
                        <p><strong>Phone number:</strong> <span class=" md:mt-0 mt-[26px]">{{$contact->phone??''}}</span></p>
                        <p><strong>Email:</strong> <span>{{$currentUser->email??'trống'}}</span></p>
                    </div>
                </div>
                <div class="mx-5 pt-10  ">
                    <div class="payment-option">

                        <form method="post" action="{{url('/momo/payment')}}" id="form_payment">
                            @csrf
                            <div>
                                <label for="payment_type" class="">Payment Type</label>
                                <x-select name="payment_type" id="payment_type"  class="ml-4" value="1" onchange="paymentTypeChange(event)">
                                    <option value="1">Pay in Full</option>
                                    <option value="2">Deposit 20%</option>
                                </x-select>
                            </div>
                                <div class="mt-6 flex {{auth::check()?'':'hidden'}} flex-col md:flex-row gap-4">
                                    @if(auth::check()&&$currentUser)
                                        <x-select name="voucher_id" id="selectVoucher" onchange="voucherSelectOnchange(this)">
                                            <option value="0">Choose Your Voucher</option>
                                            @foreach($currentUser->User_Voucher as $userVoucher)
                                                @if(isset($userVoucher->Voucher) && !$userVoucher->Voucher->block)
                                                    <option value="{{$userVoucher->id}}" price="{{$userVoucher->Voucher->price}}">{{$userVoucher->Voucher->name}}</option>
                                                @endif
                                            @endforeach
                                        </x-select>
                                    @endif
                                </div>
                            <div class="payment_method mt-6 ">
                                <div id="momoContainer" onclick="chooseMomo()" class="flex border rounded h-[60px] p-4 mt-4 justify-between items-center border-green-500">
                                    <div class="flex">
                                        <img src="https://homepage.momocdn.net/fileuploads/svg/momo-file-240411162904.svg" width="30">
                                        <label class="ml-2">
                                            Pay via MoMo
                                        </label>
                                    </div>
                                    <input
                                        onchange="paymentMethodChange()"
                                        type="radio"
                                        class="payment-checkbox ml-2 text-green-700 border-green-900 rounded focus:ring-2 focus:ring-green-600 "
                                        name="payment_method"
                                        value="momo"
                                        id="momoOption"
                                    >
                                </div>
                                <div id="stripeContainer" onclick="chooseStripe()" class="flex border rounded h-[60px] p-4 mt-4 justify-between items-center">
                                    <div class="flex">
                                        <div class="bg-[#32325d] w-[40px] rounded">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="30" width="40" xml:space="preserve" y="0" x="0" id="Layer_1" version="1.1" viewBox="-54 -37.45 468 224.7"><style id="style41" type="text/css">.st0{fill-rule:evenodd;clip-rule:evenodd;fill:#fff}</style><g transform="translate(-54 -36)" id="g57"><path id="path43" d="M414 113.4c0-25.6-12.4-45.8-36.1-45.8-23.8 0-38.2 20.2-38.2 45.6 0 30.1 17 45.3 41.4 45.3 11.9 0 20.9-2.7 27.7-6.5v-20c-6.8 3.4-14.6 5.5-24.5 5.5-9.7 0-18.3-3.4-19.4-15.2h48.9c0-1.3.2-6.5.2-8.9zm-49.4-9.5c0-11.3 6.9-16 13.2-16 6.1 0 12.6 4.7 12.6 16z" class="st0"/><path id="path45" d="M301.1 67.6c-9.8 0-16.1 4.6-19.6 7.8l-1.3-6.2h-22v116.6l25-5.3.1-28.3c3.6 2.6 8.9 6.3 17.7 6.3 17.9 0 34.2-14.4 34.2-46.1-.1-29-16.6-44.8-34.1-44.8zm-6 68.9c-5.9 0-9.4-2.1-11.8-4.7l-.1-37.1c2.6-2.9 6.2-4.9 11.9-4.9 9.1 0 15.4 10.2 15.4 23.3 0 13.4-6.2 23.4-15.4 23.4z" class="st0"/><path id="polygon47" class="st0" d="M248.9 36l-25.1 5.3v20.4l25.1-5.4z"/><path id="rect49" class="st0" d="M223.8 69.3h25.1v87.5h-25.1z"/><path id="path51" d="M196.9 76.7l-1.6-7.4h-21.6v87.5h25V97.5c5.9-7.7 15.9-6.3 19-5.2v-23c-3.2-1.2-14.9-3.4-20.8 7.4z" class="st0"/><path id="path53" d="M146.9 47.6l-24.4 5.2-.1 80.1c0 14.8 11.1 25.7 25.9 25.7 8.2 0 14.2-1.5 17.5-3.3V135c-3.2 1.3-19 5.9-19-8.9V90.6h19V69.3h-19z" class="st0"/><path id="path55" d="M79.3 94.7c0-3.9 3.2-5.4 8.5-5.4 7.6 0 17.2 2.3 24.8 6.4V72.2c-8.3-3.3-16.5-4.6-24.8-4.6C67.5 67.6 54 78.2 54 95.9c0 27.6 38 23.2 38 35.1 0 4.6-4 6.1-9.6 6.1-8.3 0-18.9-3.4-27.3-8v23.8c9.3 4 18.7 5.7 27.3 5.7 20.8 0 35.1-10.3 35.1-28.2-.1-29.8-38.2-24.5-38.2-35.7z" class="st0"/></g></svg>
                                        </div>
                                        <label class="ml-2">
                                            Pay via Stripe
                                        </label>
                                    </div>
                                    <input
                                        onchange="paymentMethodChange()"
                                        type="radio"
                                        class="payment-checkbox ml-2 text-green-700 border-green-900 rounded focus:ring-2 focus:ring-green-600"
                                        name="payment_method"
                                        value="stripe"
                                        id="stripeOption"
                                    >
                                </div>
                            </div>
                            <div class="mt-6">
                                <h2>Payment Summary</h2>
                                <div class="flex w-full justify-between mt-2">
                                    <div class="text-[14px] text-gray-500">Subtotal</div>
                                    <input type="hidden" value="{{$subTotal}}" id="subTotal">
                                    <div class="flex" id="subTotalDivContainer">
                                        <div id="subTotalDiv">{{number_format($subTotal,0,',')}}</div>
                                        <span class="">&nbsp;VND</span>
                                    </div>
                                </div>
                                <div class="flex w-full justify-between mt-2 hidden" id="downPaymentContainer">
                                    <div class="text-[14px] text-gray-500">Deposit</div>
                                    <input type="hidden" value="0" id="downPayment">
                                    <div class="flex">
                                        <div id="downPaymentDiv">0</div>
                                        <span>&nbsp;VND</span>
                                    </div>
                                </div>
                                <div class="flex w-full justify-between mt-2">
                                    <div class="text-[14px] text-gray-500">Discount</div>
                                    <div class="flex">
                                        <div id="discount">{{number_format($discount,0,',')}}</div><span>&nbsp;VND</span>
                                        <input type="hidden" name="user_voucher_id" id="user_voucher_id">
                                    </div>

                                </div>
                                <hr class="my-2">
                                <div class="flex w-full justify-between mt-2">
                                    <div>Total</div>
                                    <div class="flex">
                                        <div id="total">{{number_format($subTotal-$discount,0,',')}}</div>
                                        <span>&nbsp;VND</span>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-6">
                                <x-green-button type="submit" class="border-green-500 border px-4 py-3 w-full rounded" onclick="localStorage.clear()">
                                    Proceed to Payment
                                </x-green-button>
                            </div>
                            <input name="userId" value="{{$userId??null}}" type="hidden"/>
                            <input name="contact_id" value="{{$contact->id}}" type="hidden"/>
                            <input name="reservationId" value="{{$reservation_id}}" type="hidden" id="reservationId"/>
                            <input value="{{$subTotal}}" name="totalPrice" type="hidden"/>
                        </form>
                    </div>
                </div>
            </div>
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
    const MOMO_URL="{{url('/momo/payment')}}";

    const STRIPE_URL="{{url($name .'/stripe/payment')}}";

</script>

<script src="{{asset('assets/libraries/toastr/toastr.min.js' ) }}"></script>
<script src="{{asset('js/registerBoss.js?t='.config('constants.app_version'))}}"></script>
<script src="{{asset('js/notification.js')}}"></script>
<script src="{{asset('js/user/payment/index.js')}}"></script>
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

