<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Cinnamon Bakery</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary: #D4A76A;
            --secondary: #2C1810;
            --accent: #FF9F1C;
            --light: #F9F5F0;
            --text: #4A4A4A;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--light);
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .login-card {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }

        .logo {
            text-align: center;
            margin-bottom: 30px;
            color: var(--secondary);
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .logo i { color: var(--primary); }

        h2 { text-align: center; margin-bottom: 25px; color: var(--secondary); font-weight: 600; }

        .form-group { margin-bottom: 20px; }

        label { display: block; margin-bottom: 8px; font-weight: 500; color: var(--text); }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #eee;
            border-radius: 10px;
            font-family: inherit;
            transition: all 0.3s;
            box-sizing: border-box;
        }

        .form-control:focus { outline: none; border-color: var(--primary); }

        .btn-login {
            width: 100%;
            padding: 12px;
            background: var(--secondary);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 10px;
        }

        .btn-login:hover { background: var(--primary); transform: translateY(-2px); }

        .error-msg { color: #f44336; font-size: 14px; margin-top: 5px; }

        .alert { padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; }
        .alert-danger { background: #ffebee; color: #c62828; }
        .alert-success { background: #e8f5e9; color: #2e7d32; }

        .remember-me { display: flex; align-items: center; gap: 8px; font-size: 14px; color: var(--text); }
        .footer-links { text-align: center; margin-top: 20px; font-size: 14px; }
        .footer-links a { color: var(--primary); text-decoration: none; }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="logo">
            <i class="fas fa-bread-slice"></i>
            <span>Cinnamon Admin</span>
        </div>

        <h2>Sign In</h2>

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if(session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <form action="{{ route('admin.login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="login">Email or Username</label>
                <input type="text" name="login" id="login" class="form-control" value="{{ old('login') }}" required autofocus>
                @error('login') <div class="error-msg">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
                @error('password') <div class="error-msg">{{ $message }}</div> @enderror
            </div>

            <div class="form-group remember-me">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember" style="margin-bottom:0">Remember Me</label>
            </div>

            <button type="submit" class="btn-login">Login to Dashboard</button>
        </form>

        <div class="footer-links">
            <a href="#">Forgot Password?</a>
        </div>
    </div>
</body>
</html>
