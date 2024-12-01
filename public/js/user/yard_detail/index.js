document.addEventListener('DOMContentLoaded', () => {
    // Xử lý đánh giá sao
    const stars = document.querySelectorAll('.star');
    const ratingValue = document.getElementById('rating-value');

    stars.forEach((star) => {
        star.addEventListener('click', () => {
            const selectedValue = star.getAttribute('data-value');
            ratingValue.value = selectedValue;

            stars.forEach((s) => {
                s.classList.remove('selected');
                if (s.getAttribute('data-value') <= selectedValue) {
                    s.classList.add('selected');
                }
            });
            console.log("Đánh giá của bạn là: " + ratingValue.value);
        });
    });

    ratingValue.addEventListener('change', (event) => {
        console.log('Giá trị rating-value thay đổi:', event.target.value);
    });

    // Xử lý menu dấu ba chấm (ellipsis menu)
    const ellipsisMenus = document.querySelectorAll('.ellipsis-menu');

    ellipsisMenus.forEach(menu => {
        menu.addEventListener('click', function() {
            ellipsisMenus.forEach(m => {
                if (m !== menu) {
                    m.classList.remove('active');
                }
            });

            menu.classList.toggle('active');
        });
    });

    document.addEventListener('click', function(e) {
        if (!e.target.closest('.ellipsis-menu')) {
            ellipsisMenus.forEach(menu => {
                menu.classList.remove('active');
            });
        }
    });

    // Xử lý khi nhấn vào liên kết báo cáo
    document.querySelectorAll('.report-link').forEach(function(link) {
        link.addEventListener('click', function() {
            const ratingId = this.getAttribute('data-rating-id');
            document.getElementById('ratingId').value = ratingId; // Gán ID bài viết vào input hidden
        });
    });

    // xử lý hình ảnh
    const thumbnails = document.querySelectorAll('#image-gallery .thumbnail');
    thumbnails[0].classList.add('active');

});

function imageOnclick(imgSrc,imageElement) {
    const thumbnails = document.querySelectorAll('#image-gallery .thumbnail');
    console.log(thumbnails.length)
    thumbnails.forEach(thumbnail => thumbnail.classList.remove('active'));
    imageElement.classList.add('active');
    let mainImage = document.getElementById('mainImage');
    mainImage.src = imgSrc;
}
