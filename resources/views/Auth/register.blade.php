<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - TechFix</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .register-container {
            display: flex;
            height: 100vh;
        }
        .left-panel {
            background-color: #d9d9d9;
            width: 40%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
            text-align: center;
        }
        .right-panel {
            background-color: #0cc2c2;
            width: 60%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .register-box {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            width: 400px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        .btn-techfix {
            background-color: #E81500;
            border: none;
            color: white;
        }
        .btn-techfix:hover {
            background-color: #c71300;
        }
        .btn-secondary {
            background-color: #333;
            border: none;
        }
        .error-text {
            color: red;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <!-- Sidebar Kiri -->
        <div class="left-panel">
            <h2>TechFix</h2>
            <p>Panggil TechFix saja. Teknisi kami siap mendatangi kamu di mana saja, gratis antar jemput, bergaransi, dan hanya bayar ketika urusan selesai diperbaiki.</p>
        </div>

        <!-- Form Registrasi -->
        <div class="right-panel">
            <div class="register-box">
                <h3 class="text-center">Daftar</h3>

                <!-- Menampilkan Error Validasi -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('register') }}" method="POST">
                    @csrf

                    <!-- Nama Lengkap -->
                    <div class="mb-3">
                        <input type="text" name="name" class="form-control" placeholder="Nama Lengkap" value="{{ old('name') }}" required>
                        @error('name') <small class="error-text">{{ $message }}</small> @enderror
                    </div>

                    <!-- Nomor Telepon -->
                    <div class="mb-3">
                        <input type="text" name="phone" class="form-control" placeholder="No. Telepon" value="{{ old('phone') }}" required>
                        @error('phone') <small class="error-text">{{ $message }}</small> @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required>
                        @error('email') <small class="error-text">{{ $message }}</small> @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                        @error('password') <small class="error-text">{{ $message }}</small> @enderror
                    </div>

                    <!-- Konfirmasi Password -->
                    <div class="mb-3">
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi Password" required>
                    </div>

                    <!-- Checkbox Syarat & Ketentuan -->
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="terms" required>
                        <label class="form-check-label" for="terms">Saya menyetujui <a href="#" class="text-danger">syarat dan ketentuan</a></label>
                    </div>

                    <!-- Tombol Daftar -->
                    <button type="submit" class="btn btn-techfix w-100">Daftar</button>
                </form>

                <hr>

                <!-- Link Login -->
                <p class="text-center">Sudah punya akun?</p>
                <a href="{{ route('login') }}" class="btn btn-secondary w-100">Masuk</a>
            </div>
        </div>
    </div>
</body>
</html>
