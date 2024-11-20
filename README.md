# Sử Dụng Ứng Dụng
## tạo lịch tự động
### khởi chạy worker để sẽ khởi động commend liên tục khi tới thời điểm (hoặc dùng Cron)\
```php
php artisan schedule:work
```
### Nếu muốn test lạo lịch lập tức thì chỉ cần
```php
php artisan schedule:run
```
### kiểm tra trong laravel.log để xem thông tin khởi chạy xong

### kiểm tra các tast tạo lich
```php
php artisan schedule:list
```
