
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
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.report-link').forEach(function (link) {
        link.addEventListener('click', function () {
            const ratingId = this.getAttribute('data-rating-id');
            document.getElementById('rating-id').value = ratingId;

            // Mở modal
            const modal = new bootstrap.Modal(document.getElementById('modal-report'));
            modal.show();
        });
    });

    document.getElementById('report-form').addEventListener('submit', function (e) {
        e.preventDefault();

        const form = this;
        const formData = new FormData(form);

        // Reset lỗi cũ
        form.querySelectorAll('.is-invalid').forEach(function (el) {
            el.classList.remove('is-invalid');
        });
        form.querySelectorAll('.invalid-feedback').forEach(function (el) {
            el.textContent = '';
        });

        // Gửi dữ liệu qua AJAX
        $.ajax({
            url: REPORT_URL,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    console.log('Success response received. Reloading the page...');
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);

                    const modal = bootstrap.Modal.getInstance(document.getElementById('modal-report'));
                    modal.hide();

                    form.reset();


                }
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;

                    // Hiển thị lỗi
                    for (const field in errors) {
                        const input = form.querySelector(`[name="${field}"]`);
                        if (input) {
                            input.classList.add('is-invalid');
                            const errorElement = input.parentElement.querySelector('.invalid-feedback');
                            if (errorElement) {
                                errorElement.textContent = errors[field][0];
                            }
                        }
                    }
                } else {
                    console.error('An unexpected error occurred:', xhr.responseText);
                }
            }
        });
    });
});




