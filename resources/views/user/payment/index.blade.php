<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Play On Pitch</title>
    <link rel="stylesheet" href="{{ asset('css/user/payment.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<header>
    <div class="top-section">
        <h3>Logo và tên sân</h3>
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
                    <button><i class="fa-solid fa-user" style="color: #ffffff;"></i> {{ Auth::user()->full_name }}</button>
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

<div class="payment-container">

    <div class="flex text-[16px] flex-col">
        <div class="flex justify-center mb-3">
            <div class="flex items-center justify-between w-full max-w-[800px]">
                <div class="flex flex-col items-center">
                    <i class="fa fa-th-large mb-1 text-[24px]"></i>
                    <span>Chọn sân</span>
                </div>
                <div class="text-[18px] text-center">></div>
                <div class="flex flex-col text-red-600 items-center">
                    <i class="fa fa-credit-card mb-1 text-[24px]"></i>
                    <span>Thanh toán</span>
                </div>
                <div class="text-[18px] text-center">></div>
                <div class="flex flex-col items-center">
                    <i class="fa fa-ticket-alt mb-1 text-[24px]"></i>
                    <span>Thông tin đặt sân</span>
                </div>
            </div>
        </div>

        @php
         $subTotal= $total_price;
         $discount= 0;
         $boss= $yardSchedule->Yard->Boss;
         $userId=$currentUser->id;
        @endphp

        <div class="p-10 rounded mx-auto border bg-white">
            <div class="flex justify-center">
                <div class="mx-5">
                    <form action="{{url('user/payment/cancel')}}/{{$yardSchedule->id}}" method="get">
                        <button type="submit" class="mb-3 text-[20xp] hover:text-red-500"><i class="bi bi-caret-left-fill"></i>  Hủy</button>
                    </form>
                    <h2 class="text-bold-900 text-xl">Thanh Toán</h2>
                    <div class="payment-info">
                        <p><strong>Sân:</strong> <span>{{$boss->company_name}}</span></p>
                        <p><strong>Địa chỉ:</strong> <span>{{$boss->company_address}}, {{$boss->District->name}}, {{$boss->Province->name}}</span></p>
                        <p><strong>Vị trí:</strong> <span>{{$yardSchedule->Yard->yard_name}}</span></p>
                        <p><strong>Thời gian:</strong> <span>{{$yardSchedule->time_slot}} {{$yardSchedule->date}}</span></p>
                    </div>
                    <hr>
                    <div class="customer-info">
                        <p><strong>Người đặt:</strong> <span>{{$userName}}</span></p>
                        <p><strong>Số điện thoại:</strong> <span>{{$phone}}</span></p>
                        <p><strong>Email:</strong> <span>{{$currentUser->email}}</span></p>
                    </div>
                </div>
                <div class="mx-5 pt-10  ">
                    <div class="payment-option">
                        <form method="post" action="{{url('/user/momo/payment')}}" id="form_payment">
                            @csrf
                            <div>
                                <label for="payment_typ" class="">Loại thanh toán</label>
                                <x-select name="payment_type" id="payment_type"  class="ml-4" value="1" onchange="paymentTypeChange(event)">
                                    <option value="1">Trả Toàn bộ</option>
                                    <option value="2">Đặt cọc 20%</option>
                                </x-select>
                            </div>
                            <div class="mt-6 flex">
                                <x-select name="voucher_id" id="selectVoucher" onchange="voucherSelectOnchange(this)">
                                    <option  value="0">chọn voucher của bạn</option>
                                    @foreach($currentUser->User_Voucher as $userVoucher)
                                        <option value="{{$userVoucher->id}}" price="{{$userVoucher->Voucher->price}}">{{$userVoucher->Voucher->name}} vnd</option>
                                    @endforeach
                                </x-select>
                            </div>
                            <div class="payment_method mt-6">
                                <div id="momoContainer" onclick="chooseMomo()" class="flex border rounded h-[60px] p-4 mt-4 justify-between items-center border-green-500">
                                    <div class="flex">
                                        <img src="https://homepage.momocdn.net/fileuploads/svg/momo-file-240411162904.svg" width="30">
                                        <label class="ml-2">
                                            Thanh toán qua MoMo
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
                                            Thanh toán qua Stripe
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
                                <h2>Tổng kết thanh toán</h2>
                                <div class="flex w-full justify-between mt-2">
                                    <div class="text-[14px] text-gray-500">Tổng</div>
                                    <input type="hidden" value="{{$subTotal}}" id="subTotal">
                                    <div class="flex" id="subTotalDivContainer"><div id="subTotalDiv">{{$subTotal}}</div><span class="ml-1">vnd</span></div>
                                </div>
                                <div class="flex w-full justify-between mt-2 hidden" id="downPaymentContainer">
                                    <div class="text-[14px] text-gray-500">Đặc cọc</div>
                                    <input type="hidden" value="0" id="downPayment">
                                    <div class="flex"><div id="downPaymentDiv">0</div><span class="ml-1">vnd</span></div>
                                </div>
                                <div class="flex w-full justify-between mt-2">
                                    <div class="text-[14px] text-gray-500">Giảm giá</div>
                                    <div class="flex">
                                        <div id="discount">{{$discount}}</div><div class="ml-1">vnd</div>
                                        <input type="hidden" name="user_voucher_id" id="user_voucher_id">
                                    </div>

                                </div>
                                <hr class="my-2">
                                <div class="flex w-full justify-between mt-2">
                                    <div>Tổng Phải trả</div>
                                    <div class="flex">
                                        <div id="total">{{$subTotal-$discount}}</div>
                                        <div class="ml-1">vnd</div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-6">
                                <x-green-button type="submit" class="border-green-500 border px-4 py-3 w-full rounded">
                                    Tiến Hành Thanh Toán
                                </x-green-button>
                            </div>
                            <input name="userId" value="{{$userId}}" type="hidden"/>
                            <input name="name" value="{{$userName}}" type="hidden"/>
                            <input name="phone" value="{{$phone}}" type="hidden"/>
                            <input name="reservationId" value="{{$reservation_id}}" type="hidden"/>
                            <input value="{{$subTotal}}" name="totalPrice" type="hidden"/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
    const MOMO_URL="{{url('/user/momo/payment')}}";
    const STRIPE_URL="{{url('/user/stripe/payment')}}";
    const TEST_URL="{{url('/user/momo/test')}}";
</script>

<script src="{{asset('assets/libraries/toastr/toastr.min.js' ) }}"></script>
<script src="{{asset('js/registerBoss.js?t='.config('constants.app_version'))}}"></script>
<script src="{{asset('js/notification.js')}}"></script>
<script src="{{asset('js/user/payment/index.js')}}"></script>

