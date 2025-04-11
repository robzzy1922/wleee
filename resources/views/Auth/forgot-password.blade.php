@extends('layouts.app')

@section('content')
<div class="login-container">
    <div class="left-panel">
        <img src="/assets/logo.png" alt="Techfix Logo" class="logo">
        <h2>Techfix</h2>
        <p>Panggil Techfix saja. Teknisi kami siap mendatangimu di mana saja, gratis antar jemput. Bergaransi, dan hanya bayar ketika unitmu selesai diperbaiki.</p>
    </div>
    <div class="right-panel">
        <div class="login-box">
            <h3>Masuk</h3>
            <form action="{{ route('password.email') }}" method="POST">
                @csrf
                <label for="email">Email</label>
                <input type="email" name="email" required>
                <button type="submit" class="reset-btn">Kirim Link Lupa Password</button>
            </form>
            @if (session('status'))
                <p class="success-message">{{ session('status') }}</p>
            @endif
        </div>
    </div>
</div>

<style>
    .login-container {
        display: flex;
        height: 100vh;
    }
    .left-panel {
        width: 30%;
        background-color: #009688;
        color: white;
        text-align: center;
        padding: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    .right-panel {
        width: 70%;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .login-box {
        background: #009688;
        padding: 20px;
        border-radius: 10px;
        text-align: center;
        width: 300px;
    }
    input[type="email"] {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border-radius: 5px;
        border: 1px solid #ccc;
    }
    .reset-btn {
        background-color: red;
        color: white;
        padding: 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
    .success-message {
        color: green;
        margin-top: 10px;
    }
</style>
@endsection
