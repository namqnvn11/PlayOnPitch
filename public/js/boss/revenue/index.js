document.addEventListener('DOMContentLoaded', function () {
    if (typeof revenueData === 'undefined') {
        console.error('Dữ liệu revenueData không tồn tại');
        return;
    }

    console.log('Dữ liệu Revenue:', revenueData);

    const ctx = document.getElementById('revenueChart').getContext('2d');

    const labels = revenueData.map(item => item.yard_name);
    const totalRevenue = revenueData.map(item => item.total_revenue);
    const reservationCounts = revenueData.map(item => item.reservation_count);

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Total Revenue (VNĐ)',
                    data: totalRevenue,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Reservation Count',
                    data: reservationCounts,
                    backgroundColor: 'rgba(255, 99, 132, 0.6)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Yards'
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Values'
                    },
                    ticks: {
                        callback: function (value) {
                            return new Intl.NumberFormat('vi-VN').format(value);
                        }
                    }
                }
            }
        }
    });
});
