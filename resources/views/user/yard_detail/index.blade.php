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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl5/0NI+RMpF8zZOZlLlDZRQo2LfND5VNAus8mJo1h" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@flasher/flasher@1.1.2/dist/flasher.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

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
            <li><a href="{{route('user.clause.index')}}">Điều khoản</a></li>
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

<div class="content-wrapper">
        <!-- Main Image and Booking Info Section -->
    <div class="main-section">
        <div class="image-gallery">
            <div class="flex items-center mb-3">
                <div class="text-[24px] font-bold mr-3">{{$boss->company_name}} </div>
                <div class="average-rating-container flex items-center mt-1">
                    <h3 id="averageRating">
                        @php
                            $fullStars = floor($averageRating); // Số sao đầy
                            $halfStar = ($averageRating - $fullStars) >= 0.5 ? 1 : 0; // Kiểm tra nửa sao
                            $emptyStars = 5 - $fullStars - $halfStar; // Số sao rỗng
                        @endphp

                            <!-- Hiển thị các sao đầy -->
                        @for ($i = 0; $i < $fullStars; $i++)
                            <span class="star1 filled">★</span>
                        @endfor

                        <!-- Hiển thị một nửa sao nếu có -->
                        @if ($halfStar)
                            <span class="star1 filled-half">★</span>
                        @endif

                        <!-- Hiển thị các sao rỗng -->
                        @for ($i = 0; $i < $emptyStars; $i++)
                            <span class="star1">★</span>
                        @endfor

                        {{--                        ({{ number_format($averageRating, 2) }})--}}
                    </h3>
                </div>
            </div>

            <img class="main-image" src="{{$boss->images()->first()->img??asset('img/sanbong.jpg')}}" alt="Main Field Image" id="mainImage">

            <div class="thumbnails" id="image-gallery">
                @foreach($boss->images()->get() as $image)
                    <img class="thumbnail" src="{{$image->img}}" alt="Thumbnail {{$image->id}}" ONCLICK="imageOnclick('{{$image->img}}',this)">
                @endforeach
                @if($boss->images()->count()==0)
                    <img class="border" src="{{asset('img/sanbong.jpg')}}" alt="Thumbnail 1">
                @endif
            </div>
        </div>
        <div class="booking-info">
            <div class="booking-controls">
                <a href="{{ url('user/choice_yard/index', [$boss->id]) }}?selectTime={{ \Carbon\Carbon::now()->toDateString() }}" class="book-now">Đặt sân ngay</a>
            </div>
            <div class="owner-info">
                <h3>THÔNG TIN CHỦ SÂN</h3>
                <p><i class="fa fa-user"></i> {{ $boss->full_name}} </p>
                <p><i class="fa fa-phone"></i> {{ $boss->phone}} </p>
                <p><i class="fa fa-envelope"></i> {{ $boss->email}} </p>
                <p><i class="fa fa-map-marker"></i> {{ $boss->company_address}} </p>
                <img class="map" src="{{asset('img/sanbong.jpg')}}" alt="Map Image">
            </div>
        </div>
    </div>
    <div class="general-info w-[65%]">
        <h3>Giới thiệu chung</h3>
        <div class="text-[17px] mt-2 text-justify">{{$boss->description}}</div>
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
            <input type="hidden" name="yard_id" value="{{$boss->Yards()->first()->id}}">
            <input type="hidden" id="rating-value" value="0" name="point">
            <textarea id="review-input" placeholder="Nhập đánh giá của bạn..." rows="3" name="comment"></textarea>
            <button type="submit">Gửi đánh giá</button>
        </form>
        <div id="reviews">
            @foreach($ratings as $rating)
                <div class="review-item">
                    <div class="review-header">
                        <div class="review-user-info">
                            <img src="{{$rating->User->image->img??'https://www.gravatar.com/avatar/'. md5(strtolower($rating->User->full_name)) .'?s=100&d=identicon'}}" alt="{{ $rating->User->name }}'s avatar" class="user-avatar">
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
        @if ($ratings->hasPages())
            <x-paginate-container >
                {!! $ratings->appends(request()->input())->links('pagination::bootstrap-4') !!}
            </x-paginate-container >
        @endif
    </div>
</div>


<div>
    <form action="{{route('user.storeRegister')}}" method="post">
        @csrf
        <section class="registration">
            <div class="form">
                <h2 style="margin-right: 200px">Bạn muốn đăng ký sử dụng website quản lý sân bóng MIỄN PHÍ?</h2>
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

@include('user.yard_detail.elements.modal_report')

<script>
    document.addEventListener('DOMContentLoaded', function () {
        @if (session('flasher'))
        Flasher.render({!! session('flasher') !!});
        @endif
    });
</script>

<script> const getDistrictsUrl = "{{ route('boss.yard.getDistricts') }}";</script>

<script src="{{ asset('js/user/home/index.js?t='.config('constants.app_version') )}}"></script>
<script>
    const STORE_URL = "{{ route('user.storeRegister') }}";
    const REPORT_URL = "{{ route('user.yarddetail.report') }}"
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{asset('assets/libraries/toastr/toastr.min.js' ) }}"></script>
<script src="{{asset('js/notification.js')}}"></script>
<script src="{{asset('js/registerBoss.js?t='.config('constants.app_version'))}}"></script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const loadMoreButton = document.getElementById('loadMoreBtn');
        const reviewsContainer = document.getElementById('reviews');
        const averageRatingDisplay = document.getElementById('averageRating');

        // Sự kiện click vào reviewsContainer
        reviewsContainer.addEventListener('click', function (event) {
            const target = event.target;

            // Xử lý dấu ba chấm
            if (target.classList.contains('ellipsis')) {
                // Đóng tất cả dropdown trước khi mở cái mới
                document.querySelectorAll('.dropdown-content').forEach(dropdown => {
                    dropdown.style.display = 'none';
                });

                // Mở hoặc đóng dropdown tương ứng
                const dropdownContent = target.nextElementSibling;
                if (dropdownContent) {
                    dropdownContent.style.display = dropdownContent.style.display === 'block' ? 'none' : 'block';
                }
            }

            // Xử lý link báo cáo
            if (target.classList.contains('report-link')) {
                const ratingId = target.dataset.ratingId;
                console.log('Báo cáo bài viết với ID:', ratingId);

                if (!ratingId) {
                    console.log('Không tìm thấy ratingId');
                }
            }
        });

        // Sự kiện click ra ngoài để đóng tất cả dropdown
        document.addEventListener('click', function (event) {
            const target = event.target;

            // Nếu click không thuộc dấu ba chấm hoặc dropdown-content, ẩn tất cả dropdown
            if (!target.closest('.ellipsis-menu') && !target.classList.contains('dropdown-content')) {
                document.querySelectorAll('.dropdown-content').forEach(dropdown => {
                    dropdown.style.display = 'none';
                });
            }
        });

        // Sự kiện load more
        loadMoreButton.addEventListener('click', function () {
            const currentPage = parseInt(loadMoreButton.getAttribute('data-current-page'), 10);
            const nextPage = currentPage + 1;
            const url = "{{ route('user.yarddetail.loadMore', ['id' => $boss->Yards()->first()->id]) }}?page=" + nextPage;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    if (data.reviews && data.reviews.length > 0) {
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
                                <div class="dropdown-content" style="display: none;">
                                    <a href="#" class="report-link" data-bs-toggle="modal" data-bs-target="#modalReport" data-rating-id="${review.id}">Báo cáo bài viết</a>
                                </div>
                            </div>
                            <div class="review-comment">
                                <p>${review.comment}</p>
                            </div>
                        `;
                            reviewsContainer.appendChild(reviewItem);
                        });

                        loadMoreButton.setAttribute('data-current-page', nextPage);
                    }

                    if (data.averageRating !== undefined) {
                        averageRatingDisplay.innerHTML = `
                        Average Rating:
                        ${[...Array(5)].map((_, i) => `
                            <span class="star1 ${data.averageRating >= i + 1 ? 'filled' : ''}">★</span>
                        `).join('')}
                        (${data.averageRating.toFixed(2)})
                    `;
                    }

                    if (!data.hasMorePages) {
                        loadMoreButton.style.display = 'none';
                    }
                })
                .catch(error => console.error('Error:', error));
        });


        document.addEventListener('click', function(event) {
            const target = event.target;

            // Nếu người dùng click ra ngoài dấu ba chấm và dropdown, ẩn tất cả dropdown
            if (!target.classList.contains('ellipsis') && !target.closest('.dropdown-content')) {
                document.querySelectorAll('.dropdown-content').forEach(dropdown => {
                    dropdown.style.display = 'none';
                });
            }
        });
    });
</script>
<script src="{{asset('js/user/yard_detail/index.js?='.config('constants.app_version'))}}"></script>






