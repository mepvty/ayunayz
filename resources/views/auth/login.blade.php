<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - AYU-NE</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #fce4ec 0%, #fff0f3 40%, #fce4ec 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            background: white;
            border-radius: 24px;
            padding: 40px 36px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 4px 30px rgba(0,0,0,0.06);
        }

        .logo {
            height: 36px;
            width: auto;
            object-fit: contain;
            margin: 0 auto 20px auto;
            display: block;
        }

        h1 {
            text-align: center;
            font-size: 24px;
            font-weight: 800;
            color: #3b1a1a;
            margin-bottom: 6px;
        }

        .subtitle {
            text-align: center;
            font-size: 13px;
            color: #b07070;
            margin-bottom: 28px;
        }

        label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #3b1a1a;
            margin-bottom: 7px;
        }

        .input-wrapper {
            position: relative;
            margin-bottom: 18px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 13px 16px;
            border: 1.5px solid #f0d5d5;
            border-radius: 12px;
            font-size: 13px;
            color: #3b1a1a;
            background: #fff;
            outline: none;
            transition: border 0.2s;
        }

        input::placeholder {
            color: #d4a0a0;
        }

        input:focus {
            border-color: #e8a0a8;
        }

        .eye-icon {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #c9a0a0;
            font-size: 16px;
            background: none;
            border: none;
        }

        .forgot {
            text-align: right;
            margin-top: -10px;
            margin-bottom: 22px;
        }

        .forgot a {
            font-size: 12px;
            color: #e07080;
            text-decoration: none;
            font-weight: 500;
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: #f4a0aa;
            color: white;
            font-size: 15px;
            font-weight: 700;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            transition: background 0.2s;
            margin-bottom: 20px;
        }

        .btn-login:hover {
            background: #e8858f;
        }

        .divider {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 16px;
        }

        .divider hr {
            flex: 1;
            border: none;
            border-top: 1px solid #f0d5d5;
        }

        .divider span {
            font-size: 12px;
            color: #c4a0a0;
        }

        .btn-social {
            width: 100%;
            padding: 12px;
            background: white;
            border: 1.5px solid #f0d5d5;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 600;
            color: #3b1a1a;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 12px;
            transition: background 0.2s;
            text-decoration: none;
        }

        .btn-social:hover {
            background: #fff5f6;
        }

        .btn-social img {
            width: 18px;
            height: 18px;
        }

        .signup-text {
            text-align: center;
            font-size: 13px;
            color: #b07070;
            margin-top: 6px;
        }

        .signup-text a {
            color: #e07080;
            font-weight: 700;
            text-decoration: none;
        }

        .error-message {
            background: #ffe0e3;
            color: #c0404a;
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 12px;
            margin-bottom: 16px;
        }
    </style>
</head>
<body>
    <div class="card">
        <img src="{{ asset('images/AYU-NE.png') }}" alt="AYU-NE" class="logo">
        <h1>Hey Aybies!</h1>
        <p class="subtitle">Log in untuk masuk ke zona bersinarmu!</p>

        @if($errors->any())
            <div class="error-message">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <label for="email">Nama Pengguna / Email</label>
            <div class="input-wrapper">
                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="Masukkan nama pengguna atau email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                >
            </div>

            <label for="password">Password</label>
            <div class="input-wrapper">
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Masukkan password"
                    required
                >
                <button type="button" class="eye-icon" onclick="togglePassword()">👁</button>
            </div>

            <div class="forgot">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">Lupa Password?</a>
                @endif
            </div>

            <button type="submit" class="btn-login">Log In</button>
        </form>

        <div class="divider">
            <hr><span>atau</span><hr>
        </div>

        <a href="#" class="btn-social">
            <img src="https://upload.wikimedia.org/wikipedia/commons/5/51/Facebook_f_logo_%282019%29.svg" alt="Facebook">
            Login dengan Facebook
        </a>

        <a href="#" class="btn-social">
            <img src="https://upload.wikimedia.org/wikipedia/commons/c/c1/Google_%22G%22_logo.svg" alt="Google">
            Login dengan Google
        </a>

        <p class="signup-text">
            Tidak memiliki akun? <a href="{{ route('register') }}">Sign Up</a>
        </p>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            input.type = input.type === 'password' ? 'text' : 'password';
        }
    </script>
</body>
</html>