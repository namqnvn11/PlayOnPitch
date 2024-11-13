<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f2f2f2;
        }
        .login-container {
            max-width: 400px;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: white;
        }
        .google-icon {
            font-size: 20px;
            color: #4285F4;
        }
        .btn-custom {
            background-color: #28A745; /* Màu nền xanh lá cây */
            color: white; /* Màu chữ trắng */
        }
        .btn-custom:hover {
            background-color: #218838; /* Màu nền khi hover */
        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center vh-100">
<div class="login-container text-center">
    <h2 class="mb-3">XIN CHÀO</h2>
    <p class="text-muted mb-4">Vui lòng nhập email và mật khẩu để tiếp tục</p>

    <!-- Login Form -->
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <!-- Email Input -->
        <div class="mb-3">
            <input type="email" class="form-control" id="login-email" name="email" placeholder="Nhập email" value="{{ old('email') }}">
            @foreach ($errors->get('email') as $error)
                <p class="text-danger" style="float: left">{{ $error }}</p>
            @endforeach
        </div>

        <!-- Password Input -->
        <div class="mb-3">
            <input type="password" class="form-control" id="login-password" name="password" placeholder="Nhập mật khẩu">
            @foreach ($errors->get('password') as $error)
                <p class="text-danger" style="float: left">{{ $error }}</p>
            @endforeach
        </div>

        <!-- Forgot Password Link -->
        <div class="mb-3 text-end">
            <a href="{{ route('password.request') }}" class="text-muted">Quên mật khẩu?</a>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-custom w-100">Tiếp tục</button>

        <!-- Separator -->
        <div class="my-3 text-muted">Hoặc</div>

        <!-- Google Login Button -->
        <a href="{{ route('auth.google') }}" class="btn btn-light w-100 d-flex align-items-center justify-content-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 48 48" class="me-2">
                <path fill="#FFC107" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"></path>
                <path fill="#FF3D00" d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"></path>
                <path fill="#4CAF50" d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z"></path>
                <path fill="#1976D2" d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z"></path>
            </svg>
            Tiếp tục với Google
        </a>

        <!-- Register Link -->
        <p class="mt-4 text-muted">Chưa có tài khoản? <a href="{{ route('register') }}" class="text-primary">Đăng ký</a></p>
    </form>
</div>

<!-- Bootstrap JS and Icons -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>
