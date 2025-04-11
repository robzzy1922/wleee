<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | TechFix</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
        }
        .login-container {
            display: flex;
            width: 900px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
            background-color: #14B8A6;
        }
        .login-sidebar {
            width: 50%;
            padding: 30px;
            color: white;
            text-align: center;
        }
        .login-sidebar img {
            width: 100px;
            margin-bottom: 20px;
        }
        .login-form {
            width: 50%;
            padding: 50px;
            background-color: white;
        }
        .btn-login {
            background-color: #E81500;
            border: none;
            padding: 10px;
            font-size: 1rem;
            color: white;
            cursor: pointer;
            border-radius: 5px;
            width: 100%;
        }
        .btn-login:hover {
            background-color: #c71300;
        }
        .forgot-password {
            display: block;
            text-align: center;
            margin-top: 10px;
            color: #E81500;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-sidebar">
            <h2>TechFix</h2>
            <p>Panggil TechFix saja. Teknisi kami siap mendatangi kamu di mana saja, gratis antar jemput, bergaransi, dan hanya bayar ketika urimu selesai diperbaiki.</p>
        </div>
        <div class="login-form">
            <h3 class="text-center mb-4">Masuk</h3>

            <!-- Tampilkan error jika login gagal -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Email / No Telepon</label>
                    <input type="text" class="form-control" name="email" value="{{ old('email') }}" placeholder="Masukkan email atau no telepon" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" placeholder="Masukkan password" required>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">Ingat Aktivitas Masuk Saya</label>
                    </div>
                    <a href="{{('password.request') }}">Lupa Password?</a>
                </div>
                <button type="submit" class="btn-login">Masuk</button>
                <p class="text-center mt-3">Belum punya akun? <a href="{{ route('register') }}" class="text-decoration-none text-danger">Daftar Sekarang</a></p>
            </form>
        </div>
    </div>
</body>
</html>
