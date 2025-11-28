<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    <title>BrewBerry - Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            width: 100%;
            max-width: 1000px;
            display: flex;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .login-left {
            flex: 1;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 60px 40px;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .logo-section {
            margin-bottom: 40px;
        }

        .logo-icon {
            width: 140px;
            height: 140px;
            margin: 0 auto 20px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
            border: 3px solid rgba(255, 255, 255, 0.3);
            overflow: hidden;
        }

        .logo-icon img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            padding: 10px;
        }

        .brand-name {
            font-size: 42px;
            font-weight: 700;
            margin-bottom: 10px;
            letter-spacing: 1px;
        }

        .brand-tagline {
            font-size: 16px;
            opacity: 0.9;
            font-weight: 300;
        }

        .features {
            margin-top: 40px;
            text-align: left;
        }

        .feature-item {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .feature-item i {
            font-size: 24px;
            margin-right: 15px;
            opacity: 0.9;
        }

        .login-right {
            flex: 1;
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-header {
            margin-bottom: 40px;
        }

        .login-header h2 {
            font-size: 32px;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 10px;
        }

        .login-header p {
            color: #718096;
            font-size: 15px;
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #4a5568;
            font-weight: 500;
            font-size: 14px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper .fa-envelope,
        .input-wrapper .fa-lock {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #a0aec0;
            font-size: 16px;
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #a0aec0;
            font-size: 16px;
            cursor: pointer;
            transition: color 0.3s ease;
            z-index: 10;
        }

        .toggle-password:hover {
            color: #667eea;
        }

        .form-control {
            width: 100%;
            padding: 14px 15px 14px 45px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 15px;
            transition: all 0.3s ease;
            background: #f7fafc;
        }

        #password {
            padding-right: 45px;
        }

        .form-control:focus {
            outline: none;
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .remember-me {
            display: flex;
            align-items: center;
        }

        .remember-me input {
            margin-right: 8px;
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        .remember-me label {
            margin: 0;
            cursor: pointer;
            color: #4a5568;
            font-size: 14px;
        }

        .forgot-password {
            color: #667eea;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .forgot-password:hover {
            color: #764ba2;
        }

        .btn-login {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            color: white;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
            }

            .login-left {
                padding: 40px 30px;
            }

            .login-right {
                padding: 40px 30px;
            }

            .brand-name {
                font-size: 32px;
            }

            .features {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-left">
            <div class="logo-section">
                <div class="logo-icon">
                    <!-- Replace 'your-logo.png' with your actual logo path -->
                    <img src="{{ asset('images/BrewBerryLogo.png') }}" alt="BrewPoint Logo">
                </div>
                <h1 class="brand-name">BrewBerry</h1>
                <p class="brand-tagline">Complete Cafe Management Solution</p>
            </div>

            <div class="features">
                <div class="feature-item">
                    <i class="fas fa-shopping-cart"></i>
                    <div>
                        <strong>Order Management</strong><br>
                        <small>Streamline your orders</small>
                    </div>
                </div>
                <div class="feature-item">
                    <i class="fas fa-chart-line"></i>
                    <div>
                        <strong>Sales Analytics</strong><br>
                        <small>Track your performance</small>
                    </div>
                </div>
                <div class="feature-item">
                    <i class="fas fa-users"></i>
                    <div>
                        <strong>Staff Management</strong><br>
                        <small>Manage your team efficiently</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="login-right">


            <div class="login-header">
                <h2>Welcome !</h2>
                <p>Please login to access the system</p>
            </div>

            <form action="{{ route('LogInSubmit') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <div class="input-wrapper">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" id="email" class="form-control"
                            placeholder="Enter your email address" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" id="password" class="form-control"
                            placeholder="Enter your password" required>
                        <i class="fas fa-eye toggle-password" id="togglePassword"></i>
                    </div>
                </div>

                <div class="remember-forgot">
                    <div class="remember-me">

                        {{-- <input type="checkbox" id="remember" name="remember"> --}}
                        <label for="remember">© BrewBerry by Sarishma. </label>
                    </div>
                    {{-- <a href="#" class="forgot-password">Forgot Password?</a> --}}
                </div>

                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt"></i> Login
                </button>
            </form>
        </div>
    </div>
    <div id="globalSpinner" class="d-none text-center mt-3">
        <div class="spinner-border text-primary" role="status">
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const spinner = document.getElementById("globalSpinner");

            document.querySelectorAll("form").forEach(form => {
                form.addEventListener("submit", function(e) {
                    form.querySelectorAll("[type='submit']").forEach(btn => {
                        btn.disabled = true;
                        btn.innerHTML =
                            `<span class="spinner-border spinner-border-sm me-2" role="status"></span>Logging in...`;
                    });
                });
            });

            // Password toggle functionality
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');

            togglePassword.addEventListener('click', function() {
                // Toggle the type attribute
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);

                // Toggle the eye icon
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });
        });
    </script>
</body>

</html>
