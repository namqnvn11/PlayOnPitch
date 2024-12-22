<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f2f2f2;
        }
        .register-container {
            max-width: 400px;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: white;
        }
        .btn-custom {
            background-color: #28A745; /* Green background color */
            color: white; /* White text color */
        }
        .btn-custom:hover {
            background-color: #218838; /* Background color on hover */
        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center vh-100">
<div class="register-container text-center">
    <h2 class="mb-3">REGISTER AN ACCOUNT</h2>
    <p class="text-muted mb-4">Please fill in the information below to create a new account</p>

    <!-- Registration Form -->
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name Input -->
        <div class="mb-3">
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" value="{{ old('name') }}">
            @foreach ($errors->get('name') as $error)
                <p class="text-danger" style="float: left">{{ $error }}</p>
            @endforeach
        </div>

        <div class="mb-3">
            <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter phone number" value="{{ old('phone') }}">
            @foreach ($errors->get('phone') as $error)
                <p class="text-danger" style="float: left">{{ $error }}</p>
            @endforeach
        </div>

        <!-- Email Input -->
        <div class="mb-3">
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" value="{{ old('email') }}" >
            @foreach ($errors->get('email') as $error)
                <p class="text-danger" style="float: left">{{ $error }}</p>
            @endforeach
        </div>

        <!-- Password Input -->
        <div class="mb-3">
            <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
            @foreach ($errors->get('password') as $error)
                <p class="text-danger" style="float: left">{{ $error }}</p>
            @endforeach
        </div>

        <!-- Confirm Password Input -->
        <div class="mb-3">
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm password">
            @foreach ($errors->get('password_confirmation') as $error)
                <p class="text-danger" style="float: left">{{ $error }}</p>
            @endforeach
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-custom w-100">Register</button>

        <!-- Separator -->
        <div class="my-3 text-muted">Or</div>

        <!-- Login Link -->
        <p class="mt-4 text-muted">Already have an account? <a href="{{ route('login') }}" class="text-primary">Log in</a></p>
    </form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
