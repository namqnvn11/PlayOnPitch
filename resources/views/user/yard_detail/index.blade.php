<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Play On Pitch</title>
    <link rel="stylesheet" href="{{ asset('css/yarddetail.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/avatar-js@1.0.0/dist/avatar.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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

<div class="content-wrapper">
        <!-- Main Image and Booking Info Section -->
        <div class="main-section">
            <div class="image-gallery">
                <h2>{{$yard->boss->company_name}}</h2>
                <img class="main-image" src="{{asset('img/sanbong.jpg')}}" alt="Main Field Image">

                <div class="thumbnails">
                    <img src="{{asset('img/sanbong.jpg')}}" alt="Thumbnail 1">
                    <img src="{{asset('img/sanbong.jpg')}}" alt="Thumbnail 2">
                    <img src="{{asset('img/sanbong.jpg')}}" alt="Thumbnail 3">
                    <img src="{{asset('img/sanbong.jpg')}}" alt="Thumbnail 4">
                    <img src="{{asset('img/sanbong.jpg')}}" alt="Thumbnail 4">
                </div>
            </div>

            <div class="booking-info">
                <div class="booking-controls">
                <select class="time-select">
                    <option value="">Chọn giờ</option>
                </select>
                    <a href="{{ url('user/choice_yard/index') }}/{{$yard->Boss->id}}" class="book-now">Đặt sân ngay</a>
                </div>

                <div class="owner-info">
                    <h3>THÔNG TIN CHỦ SÂN</h3>
                    <p><i class="fa fa-user"></i> {{ $yard->boss->full_name}} </p>
                    <p><i class="fa fa-phone"></i> {{ $yard->boss->phone}} </p>
                    <p><i class="fa fa-envelope"></i> {{ $yard->boss->email}} </p>
                    <p><i class="fa fa-map-marker"></i> {{ $yard->boss->company_address}} </p>
                    <img class="map" src="{{asset('img/sanbong.jpg')}}" alt="Map Image">
                </div>
        </div>

        <!-- General Information Section -->

    </div>
    <div class="general-info">
        <h3>Giới thiệu chung</h3>
        <p>...</p> <!-- Replace with actual description content -->
    </div>

    <div class="review-section">
        <h3>Đánh giá</h3>
        <form action="{{route('user.yarddetail.rating')}}" method="post" id="review-form">
            @csrf
            <div class="rating">
                <span class="star" data-value="5">★</span>
                <span class="star" data-value="4">★</span>
                <span class="star" data-value="3">★</span>
                <span class="star" data-value="2">★</span>
                <span class="star" data-value="1">★</span>
            </div>
            <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
            <input type="hidden" name="yard_id" value="{{$yard->id}}">
            <input type="hidden" id="rating-value" value="0" name="point">
            <textarea id="review-input" placeholder="Nhập đánh giá của bạn..." rows="3" name="comment"></textarea>
            <button type="submit">Gửi đánh giá</button>
        </form>
        <div id="reviews">
            @foreach($ratings as $rating)
                <div class="review-item">
                    <div class="review-header">
                        <div class="review-user-info">
                            <img src="https://www.gravatar.com/avatar/{{ md5(strtolower($rating->User->full_name)) }}?s=100&d=identicon" alt="{{ $rating->User->name }}'s avatar" class="user-avatar">
                            <span class="review-user">{{ $rating->User->full_name }}</span>
                        </div>
                        <div class="review-rating">
                            @for($i = 1; $i <= 5; $i++)
                                <span class="star1 {{ $rating->point >= $i ? 'filled' : '' }}">★</span>
                            @endfor
                            <span class="rating-point">({{ $rating->point }})</span>
                        </div>

                    </div>
                    <div class="ellipsis-menu" style="float: right">
                        <span class="ellipsis">...</span>
                        <div class="dropdown-content">
                            <a href="#" class="report-link" data-bs-toggle="modal" data-bs-target="#modalReport" data-rating-id="{{ $rating->id }}">Báo cáo bài viết</a>
                        </div>
                    </div>
                    <div class="review-comment">
                        <p>{{ $rating->comment }}</p>
                    </div>
                </div>
            @endforeach
        </div>
        @if ($ratings->hasMorePages())
            <div id="load-more" class="text-center">
                <button id="loadMoreBtn" class="btn" style="background-color: #309C3E; color: white">Xem thêm</button>
            </div>
        @endif
    </div>
</div>


<div style="background-color: #2e7d32">
    <form action="{{route('user.storeRegister')}}" id="form-data" method="post">
        @csrf
        <section class="registration">
            <div class="form">
                <h2 style="margin-right: 200px">Bạn muốn đăng ký sử dụng<br> website quản lý sân bóng MIỄN PHÍ?</h2>
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

@include('user.yard_detail.elements.modal_report')

<script> const getDistrictsUrl = "{{ route('boss.yard.getDistricts') }}";</script>

<script src="{{ asset('js/user/home/index.js?t='.config('constants.app_version') )}}"></script>
<script>
    const STORE_URL = "{{ route('user.storeRegister') }}";
</script>
<script src="{{asset('assets/libraries/toastr/toastr.min.js' ) }}"></script>
<script src="{{asset('js/notification.js')}}"></script>
<script src="{{asset('js/registerBoss.js?t='.config('constants.app_version'))}}"></script>
<script src="{{asset('js/user/yard_detail/index.js?='.config('constants.app_version'))}}"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const loadMoreButton = document.getElementById('loadMoreBtn');
        const reviewsContainer = document.getElementById('reviews');

        loadMoreButton.addEventListener('click', function() {
            const currentPage = {{ $ratings->currentPage() }};
            const nextPage = currentPage + 1;
            const url = "{{ route('user.yarddetail.loadMore', ['id' => $yard->id]) }}?page=" + nextPage;

            fetch(url)
                .then(response => response.json())
                .then(data => {

                    if (data.reviews && data.reviews.length > 0) {
                        // Duyệt qua các đánh giá trả về
                        data.reviews.forEach(review => {
                            const reviewItem = document.createElement('div');
                            reviewItem.classList.add('review-item');
                            reviewItem.innerHTML = `
                            <div class="review-header">
                                <div class="review-user-info">
                                    <img src="https://www.gravatar.com/avatar/${review.user.full_name}?s=100&d=identicon" alt="${review.user.full_name}'s avatar" class="user-avatar">
                                    <span class="review-user">${review.user.full_name}</span>
                                </div>
                                <div class="review-rating">
                                    ${[...Array(5)].map((_, i) => `
                                        <span class="star1 ${review.point >= i + 1 ? 'filled' : ''}">★</span>
                                    `).join('')}
                                    <span class="rating-point">(${review.point})</span>
                                </div>
                            </div>
                            <div class="ellipsis-menu" style="float: right">
                                <span class="ellipsis">...</span>
                                <div class="dropdown-content">
                                    <a href="#" class="report-link" data-bs-toggle="modal" data-bs-target="#modalReport" data-rating-id="${review.id}">Báo cáo bài viết</a>
                                </div>
                            </div>
                            <div class="review-comment">
                                <p>${review.comment}</p>
                            </div>
                        `;
                            reviewsContainer.appendChild(reviewItem);
                        });
                    }

                    if (!data.hasMorePages) {
                        loadMoreButton.style.display = 'none';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    });
</script>

