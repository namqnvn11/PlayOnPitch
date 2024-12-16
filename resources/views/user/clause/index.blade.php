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
        <a href="{{route('user.home.index')}}"><img src="{{asset('img/logotext.png')}}" alt="" style="width: 350px; height: 50px;"></a>
    </div>
    <hr class="divider" />
    <nav class="nav-menu">
        <ul>
            <li><a href="{{route('user.home.index')}}"><i class="fas fa-home"></i></a></li>
            <li><a href="{{route('user.yardlist.index')}}">Danh sách sân</a></li>
            <li><a href="{{route('user.policy.index')}}">Chính sách</a></li>
            <li><a href="#">Điều khoản</a></li>
            <li><a href="#footer">Liên hệ</a></li>
        </ul>

        <div class="auth-button">
            @auth
                <a href="{{route('user.profile.index')}}">
                    <button><i class="fa-solid fa-user" style="color: #ffffff;"></i> {{ Auth::user()->full_name . " | " . Auth::user()->score }}<i class="fa-regular fa-star"></i></button>
                </a>
            @else
                <a href="{{ route('login') }}">
                    <button><i class="fa-solid fa-user" style="color: #ffffff;"></i> Đăng nhập/ Đăng ký</button>
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
        <h1>Điều khoản</h1>
    </div>

    <div class="policy-content">
        <h2>QUY CHẾ HOẠT ĐỘNG</h2>
        <p>QUY CHẾ HOẠT ĐỘNG CỦA NỀN TẢNG</p>
        <p>ĐẶT SÂN TRỰC TUYẾN WWW.PLAYONPITCH.COM</p>
        <p>PlayOnPitch là nền tảng đặt sân trực tuyến phục vụ thương nhân, tổ chức, cá nhân có nhu cầu tạo gian hàng trực tuyến để giới thiệu và đăng tin cho thuê sân tập, cơ sở thể dục của mình.</p>
        <p>PlayOnPitch được xây dựng nhằm hỗ trợ tối đa cho khách hàng muốn tìm hiểu thông tin trực tuyến về sân luyện tập, thi đấu thể dục thể thao khác nhau hoặc có nhu cầu đặt thuê sân trực tuyến</p>

        <h3>I. Nguyên tắc chung</h3>
        <p>Nền tảng đặt sân trực tuyến PlayOnPitch do Công ty TNHH 3 thành viên thực hiện hoạt động và vận hành. Thành viên trên Nền tảng đặt sân trực tuyến là các thương nhân, tổ chức, cá nhân có hoạt động thương mại hợp pháp được PlayOnPitch chính thức công nhận và được phép sử dụng dịch vụ do Nền tảng đặt sân trực tuyến PlayOnPitch và các bên liên quan cung cấp.</p>
        <p>Nguyên tắc này áp dụng cho các thành viên đăng ký sử dụng, tạo lập gian hàng giới thiệu, buôn bán sản phẩm/ dịch vụ hoặc khuyến mại sản phẩm/ dịch vụ được thực hiện trên Nền tảng đặt sân trực tuyến PlayOnPitch.</p>
        <p>Thương nhân, tổ chức, cá nhân tham gia giao dịch tại Nền tảng đặt sân trực tuyến PlayOnPitch tự do thỏa thuận trên cơ sở tôn trọng quyền và lợi ích hợp pháp của các bên tham gia hoạt động cho thuê sản phẩm/ dịch vụ thông qua hợp đồng, không trái với quy định của pháp luật.</p>
        <p>Sản phẩm/ dịch vụ tham gia giao dịch trên Nền tảng đặt sân trực tuyến PlayOnPitch phải đáp ứng đầy đủ các quy định của pháp luật có liên quan, không thuộc các trường hợp cấm kinh doanh, cấm quảng cáo theo quy định của pháp luật.</p>
        <p>Hoạt động cho thuê dịch vụ qua Nền tảng đặt sân trực tuyến PlayOnPitch phải được thực hiện công khai, minh bạch, đảm bảo quyền lợi của người tiêu dùng.</p>
        <p>Tất cả các nội dung trong Quy định này phải tuân thủ theo hệ thống pháp luật hiện hành của Việt Nam. Thành viên khi tham gia vào Nền tảng đặt sân trực tuyến PlayOnPitch phải tự tìm hiểu trách nhiệm pháp lý của mình đối với luật pháp hiện hành của Việt Nam và cam kết thực hiện đúng những nội dung trong Quy chế của Nền tảng đặt sân trực tuyến PlayOnPitch</p>

        <h3>II. Quy định chung</h3>
        <p>Tên Miền Nền tảng đặt sân trực tuyến: Nền tảng đặt sân trực tuyến PlayOnPitch do Công ty Cổ phần Phần mềm Vitex Việt Nam phát triển với tên miền là: https://www.PlayOnPitch.com  (sau đây gọi tắt là: “Nền tảng đặt sân trực tuyến PlayOnPitch”)</p>
        <p>Định nghĩa chung:</p>
        <p>Người cho thuê/ Chủ sân (Nhà cung cấp, đối tác): là thương nhân, tổ chức, cá nhân có nhu cầu sử dụng dịch vụ của PlayOnPitch bao gồm: tạo gian hàng, giới thiệu sản phẩm/ dịch vụ cho thuê sân luyện tập thể thao, giới thiệu về công ty, thực hiện các khuyến mại dịch vụ.</p>
        <p>Người thuê/ Khách hàng: là thương nhân, tổ chức, cá nhân có nhu cầu tìm hiểu thông tin về sản phẩm/ dịch vụ cho thuê sân tập thể thao được đăng tải trên PlayOnPitch
            Thành viên: là bao gồm cả người cho thuê và người thuê</p>
        <ul>
            <li>Thành viên tham gia giao dịch trên nền tảng là thương nhân, tổ chức, cá nhân có nhu cầu mua bán sản phẩm/ dịch vụ trên website.</li>
            <li>Thành viên đăng ký kê khai ban đầu các thông tin cá nhân có liên quan, được Ban quản lý nền tảng chính thức công nhận và được phép sử dụng dịch vụ do Nền tảng đặt sân trực tuyến PlayOnPitch</li>
            <li>Khi bạn đăng ký là thành viên của nền tảng, thành viên hiểu rằng:
            <ul>
                <li>Thành viên có thể tạo một tài khoản cá nhân của mình để sử dụng.</li>
                <li>Thành viên có thể mua sản phẩm/ dịch vụ theo đúng giá và quy chuẩn, đúng cam kết của thương nhân hợp pháp đã công bố trên nền tảng.</li>
            </ul>
            </li>
            <li>Nội dung bản Quy chế này tuân thủ theo các quy định hiện hành của Việt Nam. Thành viên khi tham gia vào Nền tảng đặt sân trực tuyến phải tự tìm hiểu trách nhiệm pháp lý của mình đối với luật pháp hiện hành của Việt Nam và cam kết thực hiện đúng những nội dung trong Quy chế của Nền tảng đặt sân trực tuyến PlayOnPitch</li>
        </ul>
        <h3>III. Quy trình giao dịch</h3>
        <p>PlayOnPitch được xây dựng nhằm hỗ trợ cho thành viên dễ dàng tìm thấy các sân tập thể thao trống vào thời gian họ muốn chơi và đặt sân trực tiếp trên hệ thống PlayOnPitch mà không cần phải gọi điện thoại tìm kiếm khắp nơi.</p>
        <h3>1. Quy trình dành cho người đặt sân</h3>
        <p>Khi có nhu cầu tìm sân chơi, thành viên sẽ thực hiện theo các bước dưới đây:</p>
        <ul>
            <li>Bước 1: Đăng ký 1 tài khoản sử dụng hợp pháp trên sàn giao dịch.</li>
            <li>Bước 2: Đăng nhập vào hệ thống PlayOnPitch</li>
            <li>Bước 3: Tìm kiếm sân chơi thể thao bằng cách chọn môn thể thao, địa điểm, và nhấn vào nút tìm kiếm.</li>
            <li>Bước 4: Chọn ngày, thời gian bắt đầu, thời gian kết thúc cho toàn bộ địa điểm.</li>
            <li>Bước 5: Chọn địa điểm, ngày, thời gian trống phù hợp sau đó nhấn nút đặt sân</li>
            <li>Bước 6: Kiểm tra toàn bộ thông tin.</li>
            <li>Bước 7: Sau khi đặt sân, thành viên sẽ nhận được thông báo việc đặt sân hoàn tất và toàn bộ thông tin về ngày, giờ, địa điểm. Trường hợp chọn thanh toán tại sân, thành viên cần đến sân để thanh toán toàn bộ phí thuê sân và thông tin thanh toán sẽ được cập nhật lên hệ thống của PlayOnPitch</li>
        </ul>
        <h3>2. Quy trình dành cho ngươ quản lý</h3>
        <ul>
            <li>Bước 1: Các cơ sở thể thao sau khi đăng ký trở thành thành viên của PlayOnPitch phải có hợp đồng hợp tác để quảng báo giới thiệu về hình ảnh sân, cơ sở thể dục kèm dịch vụ cho thuê đi kèm. Sau khi ký hợp đồng PlayOnPitch sẽ cung cấp cho các cơ sở thể thao những tài khoản quản lý.</li>
            <li>Bước 2: Đăng nhập vào hệ thống PlayOnPitch bằng tài khoản được cung cấp.</li>
            <li>Bước 3: Người quản lý sẽ nhìn thấy tất cả các thông tin về các đơn đặt hàng đã được đặt vào ngày giờ cụ thể, các thông tin về thanh toán (đặt cọc, đã thanh toán)</li>
            <li>Bước 4: Người quản lý dễ dàng câp nhật các đơn đặt hàng (ngoài các đơn đặt hàng do người dùng tạo) trên hệ thống Datsan247 bằng cách nhấp vào ngày và chọn thời gian, sau đó hệ thống sẽ tự động cập nhập các đơn đặt hàng mới được tạo bởi người quản lý. Người quản lý cũng dễ dàng cập nhật các trạng thái thanh toán của người dùng trên hệ thống, bằng cách xác nhận/hủy bỏ trên các đơn đặt hàng đã được cập nhật trên hệ thống.</li>
        </ul>
        <h3>3. Dịch vụ vận chuyển, giao nhận</h3>
        <p>Khách hàng có nhu cầu thuê sân tập, cơ sở thể thao để luyện tập, thi đấu sau khi chọn sân và đặt sân online xong PlayOnPitch sẽ tiến hành xác nhận gửi email xác nhận đăng ký của khách hàng. Khi tham đến nhận sân, đề nghị khách hàng xuất trình email, SMS này hoặc thông tin khi đăng ký để làm thủ tục nhận sân.</p>
        <h3>4. Chính sách bảo hành</h3>
        <p>PlayOnPitch có trách nhiệm hỗ trợ các đối tác, chủ sân, chủ cơ sở thể thao tham gia đăng tải các hình ảnh, lịch trống cho thuê sân trên PlayOnPitch. Khi đối tác gặp bất kỳ sự cố nào liên quan đến việc sử dụng dịch vụ trên, chúng tôi sẽ tiến hành hỗ trợ, bảo hành cho dịch vụ đó.</p>
        <p>Đối với khách hàng đăng ký thuê sân tập thể thao trên PlayOnPitch thì trách nhiệm đảm bảo chất lượng dịch vụ thuộc về đối tác, chủ sân cho thuê đó.</p>
        <p>Chúng tôi khuyến cáo khách hàng nên liên hệ trực tiếp đến Bộ phận hỗ trợ trực tuyến để được hỗ trợ những thông tin hữu ích về sân tập, cơ sở thể thao và các chính sách đảm bảo về chất lượng dịch vụ của từng đối tác đăng tin quảng bá trên PlayOnPitch</p>
        <h3>5. Quy trình xác nhận và hủy đơn hàng</h3>
        <p>Việc hủy bỏ đơn đặt hàng sẽ được thực hiện theo chính sách của từng sân tập (khuyến cáo thành viên phải đọc kỹ thông tin hoặc gọi điện trực tiếp đến sân tập để tìm hiểu về việc hủy bỏ đơn hàng)</p>
        <p>Xác nhận đơn hàng</p>
        <ul>
            <li>Xác nhận đơn hàng sẽ được gửi trực tiếp đến thành viên ngay sau khi thành viên đặt sân thành công bằng email.</li>
            <li>Người quản lý sân có thể sẽ gọi điện cho thành viên trong các trường hợp cần thêm các thông tin cần thiết.</li>
            <li>Thời gian xác nhận đơn hàng đối với các thanh toán đặt cọc hoặc thanh toán tại sân trong vòng 24 giờ kể từ lúc đặt chỗ hoặc trong vòng 3 giờ nếu việc đặt chỗ chỉ kéo dài trong vòng 24 giờ</li>
        </ul>
        <p>Hủy đơn hàng</p>
        <ul>
            <li>PlayOnPitch có quyền hoãn lại quá trình của bất kỳ giao dịch nào mà chúng tôi tin tưởng một cách hợp lý rằng giao dịch là lừa đảo, trái pháp luật hoặc dính líu tới bất kỳ hoạt động tội phạm nào hoặc khi chúng tôi có cơ sở để tin rằng thành viên vi phạm điều khoản và điều kiện sử dụng Dịch vụ này.</li>
            <li>Đối với PlayOnPitch và người quản lý sân: PlayOnPitch và quản lý sân chỉ cần đăng nhập hệ thống và chọn các đơn hàng cần hủy, nhấn vào lệnh hủy đơn hàng, hệ thống sẽ tự động cập nhật thông tin vả gửi xác nhận hủy đơn hàng vào email của thành viên.</li>
        </ul>
        <h3>6. Quy trình giải quyết tranh chấp, khiếu nại</h3>
        <p>PlayOnPitch và cơ sở thể thao luôn có trách nhiệm tiếp nhận và xử lý khiếu nại của Thành viên liên quan đến giao dịch tại website www.PlayOnPitch.com</p>
        <p>Thành viên có quyền gửi khiếu nại về việc chất lượng dịch vụ không đúng với mô tả, thông tin thanh toán bị tiết lộ gây thiệt hại cho mình đến Ban quản trị của PlayOnPitch. Khi tiếp nhận những phản hồi này, PlayOnPitch sẽ xác nhận lại thông tin, trường hợp đúng như phản ánh của Thành viên tùy theo mức độ, PlayOnPitch sẽ có những biện pháp xử lý kịp thời</p>
        <p>Các bước giải quyết tranh chấp, khiếu nại:</p>
        <p>Bước 1: Tiếp nhận khiếu nại</p>
        <p>Thành viên có thể gửi ý kiến đóng góp hoặc đơn khiếu nại bằng các hình thức sau:</p>
        <ul>
            <li>Gửi thư qua đường bưu điện về địa chỉ trụ sở chính của PlayOnPitch (Trong nội dung thư ghi rõ những vấn đề Thành viên cần khiếu nại và một số thông tin tài liệu liên quan để hỗ trợ cho việc xử lý và giải quyết khiếu nại).</li>
            <li>Gọi điện trực tiếp đến bộ phận Dịch vụ khách hàng thông qua Hotline:0868 988 143. Bộ phận Dịch vụ khách hàng có trách nhiệm ghi lại những thông tin khiếu nại của Thành viên và gửi đến các bộ phận liên quan để giải quyết khiếu nại (Thành viên có trách nhiệm cung cấp thông tin hoặc tài liệu liên quan cho bộ phận Dịch vụ khách hàng nếu được yêu cầu hỗ trợ);</li>
            <li>Gửi trực tiếp vào địa chỉ email của Website: namhuynhkhachoai@gmail.com</li>
        </ul>
        <p>Bước 2: Phân tích, đánh giá</p>
        <p>Trong vòng 24 giờ (không kể ngày Thứ bảy, Chủ nhật, Lễ, Tết) kể từ ngày tiếp nhận đơn khiếu nại, PlayOnPitch sẽ tiến hành điều tra, xác minh, phân tích và đánh giá đơn khiếu nại của Thành viên.</p>
        <p>Bước 3: Tổng hợp thông tin và giải quyết khiếu nại</p>
        <p>Sau khi xác minh rõ vấn đề khiếu nại, Website sẽ tổng hợp thông tin và căn cứ theo quy định của PlayOnPitch để xử lý và giải đáp khiếu nại của khách hàng.</p>
        <p>Bước 4: Trả lời khách hàng</p>
        <p>Trong vòng 24 giờ làm việc kể từ khi nhận được khiếu nại, PlayOnPitch sẽ có văn bản trả lời hoặc trả lời cho Thành viên thông qua những phương tiện khác như email, điện thoại, fax. Nếu khiếu nại có tính chất phức tạp và cần thêm thời gian để giải quyết và trả lời cho Thành viên một cách rõ ràng, PlayOnPitch sẽ trực tiếp liên hệ với khách hàng để gia hạn thời gian trả lời, nhưng không quá 60 giờ làm việc.</p>
        <p>Bước 5: Kết thúc</p>
        <p>PlayOnPitch tôn trọng và nghiêm tục thực hiện các quy định của pháp luật về bảo vệ quyền lợi của thành viên. Vì vậy, đề nghị các cơ sở thể thao trên website cung cấp đầy đủ, chính xác, trung thực và chi tiết các thông tin liên quan đến dịch vụ. Mọi hành vi lừa đảo, gian lận trong kinh doanh đều bị lên án và phải chịu hoàn toàn trách nhiệm trước pháp luật.
            Chúng tôi công khai cơ chế giải quyết các tranh chấp phát sinh trong quá trình giao dịch trên website PlayOnPitch. Khi người dùng sử dụng dịch vụ phát sinh mâu thuẫn với cơ sở cung cấp hoặc bị tổn hại lợi ích hợp pháp, PlayOnPitch sẽ có trách nhiệm tiếp nhận thông tin phản ánh. Chịu trách nhiệm giải quyết các vấn đề liên quan, tích cực hỗ trợ thành viên bảo vệ quyền và lợi ích hợp pháp của bản thân.</p>
        <p>PlayOnPitch công khai cơ chế và quy trình giải quyết tranh chấp đối với các bên liên quan là: giải quyết tranh chấp theo cơ chế trao đổi thỏa thuận thống nhất, các bên liên quan sẽ thực hiện theo quy trình trao đổi gián tiếp qua điện thoại, xác nhận văn bằng email, nếu vẫn chưa thỏa thuận được thì sẽ giải quyết thông qua gặp trực tiếp để cụ thể hóa vấn đề, giải quyết triệt để vấn đề mâu thuẫn giữa các bên sao cho có lợi nhất.</p>
        <p>Các bên bao gồm cơ sở thể thao, Thành viên và PlayOnPitch sẽ phải có vai trò trách nhiệm trong việc tích cực giải quyết vấn đề. Đối với cơ sở thể thao cần có trách nhiệm cung cấp văn bản giấy tờ chứng thực thông tin liên quan đến sự việc đang gây mâu thuẫn cho khách hàng. Đối với mua dịch vụ sẽ có trách nhiệm trọng tài tiến hành lắng nghe và tiếp nhận thông tin từ khách hàng (trong trường hợp cụ thể chúng tôi sẽ: yêu cầu khách hàng cần có trách nhiệm cung cấp chính xác các thông tin vô hình và hữu hình về vấn đề mâu thuẫn đang phát sinh cần giải quyết mà khách hàng đã tự thấy mình bị thiệt hại) và cơ sở thể thao, sau đó tiến hành xem xét và nêu rõ, phân tích lỗi thuộc về bên nào. Lấy ý kiến về sự thỏa thuận mức độ bồi hoàn của 2 bên và kết thúc giải quyết tranh chấp một cách thỏa đáng nhất.</p>
        <p>Trong trường hợp chứng minh được lỗi thuộc về cơ sở thể thao: PlayOnPitch có biện pháp cảnh cáo, yêu cầu bồi hoàn lại toàn bộ chi phí mà Thành viên đã phải bỏ ra để sử dụng dịch vụ đó hoặc phải đổi lại dịch vụ đúng với chất lượng mà cơ sở thông báo tại PlayOnPitch. Nếu cơ sở tái phạm PlayOnPitch sẽ chấm dứt và gỡ bỏ toàn bộ thông tin cơ sở đó trên PlayOnPitch.</p>
        <p>Nếu thông qua hình thức thỏa thuận mà vẫn không thể giải quyết được mâu thuẫn phát sinh từ giao dịch, thì PlayOnPitch sẽ nhờ đến cơ quan pháp luật có thẩm quyền can thiệp nhằm đảm bảo lợi ích hợp pháp của các bên nhất là cho khách hàng.</p>
        <h3>IV. Đảm bảo an toàn giao dịch</h3>
        <p>Ban quản lý đã sử dụng các dịch vụ để bảo vệ thông tin về nội dung mà Chủ sân/ người cho thuê đăng tải trên PlayOnPitch. Để đảm bảo các giao dịch được tiến hành thành công, hạn chế tối đa rủi ro có thể phát sinh.</p>
        <p>Chủ sân/ người cho thuê phải cung cấp thông tin đầy đủ (tên, địa chỉ, số điện thoại, email) trong mỗi gian hàng đăng tin dịch vụ của mình.</p>
        <p>Người thuê không nên đưa thông tin chi tiết về việc thanh toán với bất kỳ ai bằng email hoặc hình thức liên lạc khác, PlayOnPitch không chịu trách nhiệm về những thiệt hại hay rủi ro thành viên có thể gánh chịu trong việc trao đổi thông tin của người thuê thành viên qua Internet hoặc email.</p>
        <p>Trong trường hợp người thuê liên hệ trực tiếp với người cho thuê và không sử dụng công cụ đặt sân trực tuyến của PlayOnPitch thì người thuê phải cân nhắc cẩn việc giao tiền trước cho người cho thuê.</p>
        <p>Người thuê tuyệt đối không sử dụng bất kỳ chương trình, công cụ hay hình thức nào khác để can thiệp vào hệ thống hay làm thay đổi cấu trúc dữ liệu. Nghiêm cấm việc phát tán, truyền bá hay cổ vũ cho bất kỳ hoạt động nào nhằm can thiệp, phá hoại hay xâm của hệ thống website. Mọi vi phạm sẽ bị xử lý theo Quy chế và quy định của pháp luật.
            Mọi thông tin giao dịch được bảo mật, trừ trường hợp buộc phải cung cấp khi Cơ quan pháp luật yêu cầu.</p>
        <h3>V. Bảo vệ thông tin cá nhân thành viên</h3>
        <h3>1. Mục đích thu thập thông tin cá nhân</h3>
        <p>Thông tin cá nhân thu thập được sẽ chỉ được sử dụng trong nội bộ công ty. “Thông tin cá nhân” có nghĩa là thông tin về khách hàng mà dựa vào đó có thể xác định danh tính của khách hàng, bao gồm, nhưng không giới hạn, tên, số chứng minh thư, số giấy khai sinh, số hộ chiếu, quốc tịch, địa chỉ, số điện thoại, các chi tiết về thẻ tín dụng hoặc thẻ ghi nợ, chủng tộc, giới tính, ngày sinh, địa chỉ thư điện tử, bất kỳ thông tin gì về khách hàng mà khách hàng đã cung cấp cho Công ty trong các mẫu đơn đăng ký, đơn xin hoặc bất kỳ mẫu đơn tương tự nào và/hoặc bất kỳ thông tin gì về khách hàng mà đã được hoặc có thể thu thập, lưu trữ, sử dụng và xử lý bởi Công ty theo thời gian và bao gồm các thông tin cá nhân nhạy cảm như dữ liệu liên quan đến sức khỏe, tôn giáo hay tín ngưỡng tương tự khác.</p>
        <p>Khi Thành viên đăng ký tài khoản trên SGD TMĐT PlayOnPitch. Công ty có thể sử dụng và xử lý Thông tin Cá nhân của khách hàng cho việc kinh doanh và các hoạt động của Công ty, bao gồm, nhưng không giới hạn, các mục đích sau đây (“Mục đích”):</p>
        <ul>
            <li>Chuyển tiếp đơn hàng từ Thành viên đến các cơ sở thể thao đối tác nơi mà Thành viên đặt lịch chơi thể thao</li>
            <li>Thông báo về việc đặt lịch và hỗ trợ khách hàng</li>
            <li>Xác minh sự tin cậy của Thành viên.</li>
            <li>Cung cấp cổng thanh toán với các thông tin cần thiết để thực hiện các giao dịch nếu Thành viên lựa chọn hình thức thanh toán trực tuyến.</li>
            <li>Để xác nhận và/hoặc xử lý các khoản thanh toán theo Thỏa thuận;</li>
            <li>Để thực hiện các nghĩa vụ của Công ty đối với bất kỳ hợp đồng nào đã ký kết với khách hàng;</li>
            <li>Để cung cấp cho khách hàng các dịch vụ theo Thỏa thuận;</li>
            <li>Để xử lý việc tham gia của khách hàng trong bất kỳ sự kiện, chương trình khuyến mãi, hoạt động, các nghiên cứu, cuộc thi, chương trình khuyến mãi, các cuộc điều tra thăm dò, khảo sát hoặc các hoạt động khác và để liên lạc với khách hàng về sự tham gia của khách hàng tại đây;</li>
            <li>Để xử lý, quản lý, hoặc kiểm chứng yêu cầu sử dụng Dịch vụ của khách hàng theo Thỏa thuận;</li>
            <li>Để phát triển, tăng cường và cung cấp những Dịch vụ được yêu cầu theo Thỏa thuận nhằm đáp ứng nhu cầu của khách hàng;</li>
            <li>Để xử lý bất kỳ khoản bồi hoàn, giảm giá và/hoặc các khoản phí theo quy định của Thỏa thuận;</li>
            <li>Để tạo điều kiện hoặc cho phép bất kỳ sự kiểm tra có thể được yêu cầu theo Thỏa thuận;</li>
            <li>Để trả lời các khúc mắc, ý kiến và phản hồi từ khách hàng;</li>
            <li>Để phục vụ các mục đích quản lý nội bộ như kiểm toán, phân tích dữ liệu, lưu giữ cơ sở dữ liệu;</li>
            <li>Để phục vụ các mục đích phát hiện, ngăn chặn và truy tố tội phạm;</li>
            <li>Để Công ty thực hiện các nghĩa vụ theo pháp luật;</li>
            <li>Để gửi cho khách hàng các thông báo, bản tin, cập nhật, bưu phẩm, tài liệu quảng cáo, ưu đãi đặc biệt, lời chúc vào các ngày lễ từ phía Công ty, đối tác, nhà quảng cáo và/hoặc nhà tài trợ hoặc;</li>
            <li>Để thông báo và mời khách hàng tới dự các sự kiện hoặc các hoạt động do Công ty, đối tác, nhà quảng cáo và/hoặc nhà tài trợ tổ chức;</li>
            <li>Để chia sẻ Thông tin cá nhân của khách hàng với nhóm các công ty liên quan của Công ty bao gồm các công ty con, công ty liên kết và/hoặc các tổ chức thuộc quyền đồng kiểm soát của công ty mẹ của tập đoàn (“Tập đoàn”) và với các đại lý, các nhà cung cấp bên thứ ba của Công ty và của Tập đoàn, các nhà phát triển, quảng cáo, đối tác, công ty sự kiện hoặc nhà tài trợ có thể liên hệ với khách hàng vì bất kỳ lý do gì.</li>
        </ul>
        <p>Chi tiết đơn hàng của Thành viên sẽ được chúng tôi lưu trữ nhưng vì lý do bảo mật, Thành viên không thể yêu cầu thông tin đó từ PlayOnPitch. Tuy nhiên, Thành viên có thể kiểm tra thông tin bằng cách đăng nhập vào tài khoản riêng của mình trên PlayOnPitch. Tại đó, Thành viên có thể theo dõi đầy đủ chi tiết nhật ký đơn hàng của mình. Khách hàng cần bảo đảm là thông tin được đăng nhập được giữ bí mật và không tiết lộ cho bên thứ ba.</p>
        <p>Nếu khách hàng không đồng ý cho Công ty sử dụng Thông tin cá nhân của khách hàng cho bất kỳ Mục đích nào nói trên, xin vui lòng thông báo trước cho Công ty qua các thông tin liên hệ hỗ trợ có trong website/Ứng dụng.</p>
        <p>Trong trường hợp có bất kỳ thay đổi nào về Thông tin cá nhân mà khách hàng đã cung cấp cho công ty, ví dụ, nếu khách hàng thay đổi địa chỉ thư điện tử, số điện thoại, chi tiết thanh toán hoặc nếu khách hàng muốn hủy bỏ tài khoản của khách hàng, xin vui lòng cập nhật thông tin của khách hàng bằng cách gửi yêu cầu tới thông tin liên hệ hỗ trợ được cung cấp trong Website/Ứng dụng.</p>
        <p>Trong khả năng tốt nhất của mình, công ty sẽ thực hiện các thay đổi như yêu cầu trong thời gian hợp lý kể từ khi nhận được thông báo thay đổi.</p>
        <p>Bằng việc gửi thông tin, khách hàng cho phép việc sử dụng các thông tin đó như quy định trong đơn điền thông tin và trong Điều khoản sử dụng.</p>
        <h3>2. Phạm vi sử dụng thông tin</h3>
        <p>Nền tảng đặt sân trực tuyến PlayOnPitch không mua bán, chia sẻ hay trao đổi thông tin cá nhân của Thành viên thu thập trên trang web cho một bên thứ ba nào khác.</p>
        <ul>
            <li>Công Ty TNHH 3 thành viên sẽ cung cấp cho các cơ sở thể thao thông tin cần thiết để chuyển giao các đơn đặt hàng đến cho thành viên quản lý của cơ sở thể thao. Nếu thành viên lựa chọn hình thức thanh toán trực tuyến Công Ty TNHH 3 thành viên sẽ cung cấp cổng thanh toán với các thông tin cần thiết để xử lý thanh toán. Mọi thông tin giao dịch sẽ được bảo mật nhưng trong trường hợp cơ quan pháp luật yêu cầu, chúng tôi sẽ buộc phải cung cấp những thông tin này cho các cơ quan pháp luật.</li>
            <li>Sau khi đơn hàng được đặt thành công, chỉ nhân viên của Công Ty Cổ phần Phần mềm Vitex Việt Nam và chính thành viên mới có thể đăng nhập vào phần thông tin cá nhân.</li>
            <li>Thông tin sẽ được lưu trữ trên hệ thống của PlayOnPitch và đươc điều hành ngay tại văn phòng Công Ty Cổ phần Phần mềm Vitex Việt Nam</li>
            <li>Thành viên có thể thay đổi, xem hoặc xoá thông tin của họ bằng cách đăng nhập vào phần “Trang cá nhân” hoặc gửi email cho chúng tôi qua địa chỉ namhuynhkhachoai@gmail.com</li>
        </ul>
        <h3>3. Thời gian lưu trữ thông tin</h3>
        <p>Nền tảng đặt sân trực tuyến PlayOnPitch sẽ lưu trữ các Thông tin cá nhân do Thành viên cung cấp trên các hệ thống nội bộ của chúng tôi trong quá trình cung cấp dịch vụ cho Thành viên hoặc cho đến khi hoàn thành mục đích thu thập hoặc khi Khách hàng có yêu cầu hủy các thông tin đã cung cấp.</p>
        <h3>4. Địa chỉ của đơn vị thu thập và quản lý thông tin cá nhân Nền tảng đặt sân trực tuyến PlayOnPitch:</h3>
        <ul>
            <li>Địa chỉ: 184 Lê Đại Hành, phường 17, Quận 11, TP HCM</li>
            <li>Tel/Fax: 0868 988 143</li>
            <li>Email: namhuynhkhachoai@gmail.com</li>
        </ul>
        <h3>5. Phương tiện và công cụ để người dùng tiếp cận và chỉnh sửa dữ liệu cá nhân của mình </h3>
        <p>Thành viên có thể thay đổi, xem hoặc xoá thông tin bằng cách đăng nhập vào phần “Thành viên” trên Nền tảng đặt sân trực tuyến PlayOnPitch hoặc gửi email cho chúng tôi qua địa chỉ namhuynhkhachoai@gmail.com để được trợ giúp.</p>
        <h3>6. Cam kết bảo mật thông tin cá nhân khách hàng</h3>
        <p>Nền tảng đặt sân trực tuyến PlayOnPitch cam kết không mua bán, trao đổi hay chia sẻ thông tin dẫn đến việc làm lộ thông tin cá nhân của Thành viên vì mục đích thương mại, vi phạm những cam kết được đặt ra trong quy định chính sách bảo mật thông tin khách hàng.</p>
        <p>Nền tảng đặt sân trực tuyến PlayOnPitch sẽ không chia sẻ thông tin Thành viên trừ những trường hợp cụ thể như sau:</p>
        <ul>
            <li>Theo yêu cầu pháp lý từ một cơ quan chính phủ hoặc khi chúng tôi tin rằng việc làm đó là cần thiết và phù hợp nhằm tuân theo các yêu cầu pháp lý.</li>
            <li>Để bảo vệ Nền tảng đặt sân trực tuyến PlayOnPitch và các bên thứ ba khác: Chúng tôi chỉ đưa ra thông tin tài khoản và những thông tin cá nhân khác khi tin chắc rằng việc đưa những thông tin đó là phù hợp với luật pháp, bảo vệ quyền lợi, tài sản của người sử dụng dịch vụ, của Datsan247 và các bên thứ ba khác.</li>
            <li>Những thông tin cá nhân một cách hạn chế nhất sẽ chỉ được chia sẻ với bên thứ ba hoặc nhà tài trợ. Thông tin vắn tắt này sẽ không chứa đầy đủ toàn bộ thông tin của thành viên và chỉ mang ý nghĩa giúp xác định những thành viên nhất định đang sử dụng dịch vụ PlayOnPitch</li>
        </ul>
        <p>Trong những trường hợp còn lại, chúng tôi sẽ có thông báo cụ thể cho Thành viên khi phải tiết lộ thông tin cho một bên thứ ba và thông tin này chỉ được cung cấp khi được sự phản hồi đồng ý từ phía Thành viên.</p>
        <h3>7. Thỏa thuận bảo mật thông tin</h3>
        <p>Nền tảng đặt sân trực tuyến PlayOnPitch có trách nhiệm yêu cầu các bên xử lý thông tin, các bên tham gia hợp đồng đảm bảo việc phòng vệ, chống mất mát hoặc truy cập trái phép, sử dụng, thay đổi, tiết lộ hoặc sử dụng sai mục đích. Nền tảng đặt sân trực tuyến PlayOnPitch có thỏa thuận và cơ chế kiểm soát thông tin cá nhân đối với thành viên, đối tác nhằm đảm bảo trách nhiệm của Nền tảng đặt sân trực tuyến PlayOnPitch đối với thông tin cá nhân của Thành viên thông qua những phương pháp dưới đây:</p>
        <ul>
            <li>Hướng dẫn thành viên, đối tác chính sách nội bộ của Nền tảng đặt sân trực tuyến PlayOnPitch.</li>
            <li>Hợp đồng;</li>
            <li>Buộc Thành viên, đối tác phải tuân thủ nguyên tắc do Nền tảng đặt sân trực tuyến PlayOnPitch.</li>
            <li>Tuân thủ quy tắc và luật liên quan;</li>
        </ul>
        <h3>8. Trường hợp thành viên gửi khiếu nại có liên quan đến việc bảo mật thông tin</h3>
        <p>Ngay khi tiếp nhận thông tin, Nền tảng đặt sân trực tuyến PlayOnPitch sẽ nhanh chóng thực hiện việc kiểm tra, xác minh. Trong trường hợp đúng như phản ánh của Thành viên thì Nền tảng đặt sân trực tuyến PlayOnPitch.sẽ liên hệ trực tiếp với Thành viên để xử lý vấn đề trên tin thần khắc phục và thiện chí. Trường hợp hai bên không thể tự thoả thuận thì sẽ đưa ra Tòa án Nhân Dân có thẩm quyền tại Thành Phố Hà Nội để giải quyết.</p>
        <h3>VI. Điều khoản cam kêt</h3>
        <ul>
            <li>Mọi thành viên và đối tác khi sử dụng PlayOnPitch là đã chấp thuận tuân theo quy chế này.</li>
            <li>Mọi thắc mắc của đối tác, thành viên vui lòng liên hệ với PlayOnPitch theo thông tin dưới đây</li>
            <li>Địa chỉ liên lạc chính thức của website PlayOnPitch</li>
            <li>Nền tảng đặt sân trực tuyến PlayOnPitch</li>
            <li>CÔNG TY TNHH 3 thành viên</li>
            <li>Địa chỉ: 184 Lê Đại Hành, phường 17, Quận 11, TP HCM</li>
            <li>Tel: 0868 988 143</li>
            <li>Email: namhuynhkhachoai@gmail.com</li>
        </ul>

    </div>
</div>
<div>
    <form id="form-data" method="post">
        @csrf
        <section class="registration">
            <div class="form">
                <h2 style="margin-right: 250px">Bạn muốn đăng ký sử dụng website quản lý sân bóng MIỄN PHÍ?</h2>
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
            <li><a href="{{route('user.commodity_policy.index')}}">Chính sách đặt sân</a></li>
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


