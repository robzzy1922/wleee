@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Edit Profil</h2>
    <form action="{{ route('admin.profile.update') }}" method="POST">
        @csrf
        <div>
            <label>Nama</label>
            <input type="text" name="name" value="{{ auth()->user()->name }}" required>
        </div>
        <div>
            <label>Email</label>
            <input type="email" name="email" value="{{ auth()->user()->email }}" required>
        </div>
        <div>
            <label>Password (opsional)</label>
            <input type="password" name="password">
        </div>
        <div>
            <label>Konfirmasi Password</label>
            <input type="password" name="password_confirmation">
        </div>
        <button type="submit">Simpan</button>
    </form>
</div>
@endsection
