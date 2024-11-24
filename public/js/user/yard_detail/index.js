  document.addEventListener('DOMContentLoaded', () => {
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
    });

    document.addEventListener('DOMContentLoaded', function() {
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
    });
  document.addEventListener('DOMContentLoaded', function() {
      document.querySelectorAll('.report-link').forEach(function(link) {
          link.addEventListener('click', function(e) {
              const ratingId = this.getAttribute('data-rating-id');
              document.getElementById('ratingId').value = ratingId; // Gán ID bài viết vào input hidden
          });
      });
  });



