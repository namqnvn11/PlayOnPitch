<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Play On Pitch</title>
    <link rel="stylesheet" href="{{ asset('css/privacypolicy.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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

<div class="policy-container">
    <div class="policy-header">
        <h1>Chính sách bảo mật thông tin</h1>
    </div>

    <div class="policy-content">
      <h2>Chính sách bảo mật thông tin</h2>
        <p>Chính sách bảo mật này công bố cách thức mà chúng tôi thu thập, lưu trữ và xử lý thông tin hoặc dữ liệu cá nhân (“Thông tin cá nhân”) của các khách hàng của mình thông qua Website. Chúng tôi cam kết sẽ bảo mật các thông tin cá nhân của khách hàng, đồng thời sẽ nỗ lực hết sức và sử dụng các biện pháp thích hợp để các thông tin mà khách hàng cung cấp cho chúng tôi trong quá trình sử dụng Website được bảo mật và bảo vệ khỏi sự truy cập trái phép.</p>
        <p>Tuy nhiên, chúng tôi không đảm bảo ngăn chặn được tất cả các truy cập trái phép. Trong trường hợp truy cập trái phép nằm ngoài khả năng kiểm soát của chúng tôi, công ty sẽ không chịu trách nhiệm dưới bất kỳ hình thức nào đối với bất kỳ khiếu nại, tranh chấp hoặc thiệt hại nào phát sinh từ hoặc liên quan đến truy cập trái phép đó.</p>
        <p>Để hiểu rõ hơn về chính sách trong công tác thu thập, lưu trữ và sử dụng thông tin cá nhân của người sử dụng Website này, vui lòng đọc các chính sách bảo mật dưới đây:</p>
        <h3>I. Mục đích và phạm vi thu thập thông tin cá nhân</h3>
        <p>Để truy cập và sử dụng một số dịch vụ tại Website, bạn có thể sẽ được yêu cầu đăng ký với chúng tôi thông tin cá nhân (Email, Họ tên, Số ĐT liên lạc,…). Mọi thông tin khai báo phải đảm bảo tính chính xác và hợp pháp. Website của chúng tôi không chịu mọi trách nhiệm liên quan đến pháp luật của thông tin khai báo. Chúng tôi cũng có thể thu thập thông tin về số lần viếng thăm, bao gồm số trang bạn xem, số links (liên kết) bạn click và những thông tin khác liên quan đến việc kết nối đến Website của chúng tôi. Chúng tôi cũng thu thập các thông tin mà trình duyệt Website bạn sử dụng mỗi khi truy cập vào Website, bao gồm: địa chỉ IP, loại ngôn ngữ sử dụng, thời gian và những địa chỉ mà truy xuất đến</p>
        <h3>II. Phạm vi sử dụng thông tin</h3>
        <p>Các thông tin thu thập thông qua Website PlayOnPitch.com sẽ giúp chúng tôi:</p>
        <ul>
            <li>Hỗ trợ khách hàng khi sử dụng dịch vụ đặt sân</li>
            <li>Giải đáp thắc mắc khách hàng</li>
            <li>Thực hiện các bản khảo sát khách hàng</li>
            <li>Thực hiện các hoạt động quảng bá liên quan đến các sản phẩm và dịch vụ của Website PlayOnPitch.com</li>
        </ul>
        <p>Khách hàng cần đề nghị hỗ trợ hoặc có thắc mắc cần giải đáp muốn chuyển thông tin đến chúng tôi thông qua Website PlayOnPitch.com, quý khách có thể sẽ được yêu cầu đăng ký với chúng tôi thông tin cá nhân (Email, Họ tên, Số ĐT liên lạc…). Mọi thông tin khai báo phải đảm bảo tính chính xác và hợp pháp. Website PlayOnPitch.com không chịu mọi trách nhiệm liên quan đến pháp luật của thông tin khai báo.</p>
        <p>Khi cần thiết, chúng tôi có thể sử dụng những thông tin này để liên hệ trực tiếp với bạn dưới các hình thức như: gởi thư ngỏ, đơn đặt hàng, thư cảm ơn, thông tin về kỹ thuật và bảo mật, …..</p>
        <p>Chúng tôi cam kết về việc sử dụng thông tin cá nhân của Khách hàng đúng với các mục đích và phạm vi đã thông báo. Trong trường hợp có bất kỳ phạm vi sử dụng phát sinh ngoài mục đích và thông báo, chúng tôi sẽ gửi thông báo cho Khách hàng và chỉ sử dụng khi có sự đồng ý của Khách hàng.</p>
        <h3>III. Thời gian lữu trữ thông tin</h3>
        <p>Chúng tôi sẽ lưu trữ các thông tin cá nhân do khách hàng cung cấp trên các hệ thống nội bộ của chúng tôi trong quá trình cung cấp dịch vụ cho khách hàng hoặc cho đến khi hoàn thành mục đích thu thập hoặc khi khách hàng có yêu cầu hủy các thông tin đã cung cấp.</p>
        <h3>IV. Những người hoặc tổ chức có thể được tiếp cận với thông tin</h3>
        <p>Khách hàng đồng ý rằng: trong trường hợp cần thiết, các cơ quan/tổ chức/cá nhân sau có quyền được tiếp cận và thu thập các thông tin của mình, bao gồm:</p>
        <ul>
            <li>Ban Quản Trị</li>
            <li>Cơ quan nhà nước có thẩm quyền</li>
            <li>Bên khiếu nại chứng minh được hành vi vi phạm của Khách hàng (nếu có)</li>
        </ul>
        <h3>V. Địa chỉ của đơn vị thu thập và quản lý thông tin cá nhân</h3>
        <p>CÔNG TY TNHH 3 thành viên</p>
        <p>Địa chỉ: 184 Lê Đại Hành, Phường 17, Quận 11, TP HCM</p>
        <p>✆Hotline: 0868 988 143</p>
        <p>✉Email: namhuynhkhachoai@gmail.com</p>
        <h3>VI. Cam kết bảo mật thông tin cá nhân khách hàng</h3>
        <p>Chúng tôi cam kết bảo mật thông tin cá nhân của bạn bằng mọi cách thức có thể. Chúng tôi sẽ sử dụng nhiều công nghệ bảo mật thông tin khác nhau nhằm bảo vệ thông tin này không bị truy lục, sử dụng hoặc tiết lộ ngoài ý muốn. Chúng tôi khuyến cáo bạn nên bảo mật các thông tin liên quan đến mật khẩu truy xuất của bạn và không nên chia sẻ với bất kỳ người nào khác. Nếu sử dụng máy tính chung nhiều người, bạn nên đăng xuất, hoặc thoát hết tất cả cửa sổ Website đang mở.</p>
        <h3>VII. Cơ chế tiếp nhận và giải quyết khiếu nại liên quan đến thông tin cá nhân</h3>
        <p>Khách hàng có quyền gửi khiếu nại về việc lộ thông tin cá nhân cho bên thứ 3 đến ban quản trị của Website PlayOnPitch.com, đến địa chỉ công ty hoặc qua Email: namhuynhkhachoai@gmail.com</p>
        <p>Công ty có trách nhiệm thực hiện các biện pháp kỹ thuật, nghiệp vụ để xác minh các nội dung được phản ánh.</p>
        <p>Thời gian xử lý phản ánh liên quan đến thông tin cá nhân là 7 ngày.</p>
        <h3>VII. Thông tin liên hệ</h3>
        <p>Chúng tôi luôn hoan nghênh các ý kiến đóng góp, liên hệ và phản hồi thông tin từ bạn về “Chính sách bảo mật” này. Nếu bạn có những thắc mắc liên quan xin vui lòng liên hệ theo Điện thoại: 0868 988 143, Email: namhuynhkhachoai@gmail.com</p>
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
            <li><a href="#">Chính sách bảo mật</a></li>
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
</script>
<script src="{{asset('assets/libraries/toastr/toastr.min.js' ) }}"></script>
<script src="{{asset('js/notification.js')}}"></script>
<script src="{{asset('js/registerBoss.js?t='.config('constants.app_version'))}}"></script>


