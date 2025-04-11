<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReviewController; // ✅ Tambahin ini

// Halaman utama
Route::get('/', [HomeController::class, 'index'])->name('home');
// FAQ
Route::get('/faq', [FaqController::class, 'index'])->name('faq');

// Login & Register
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Notifikasi dibaca
Route::post('/notifikasi-read', [NotifikasiController::class, 'read'])->name('notif.read');

// Route untuk Pesanan
Route::get('/pesanan/create', [PesananController::class, 'create'])->name('pesanan.create');
Route::post('/pesanan/store', [PesananController::class, 'store'])->name('pesanan.store');

// Route Customer (hanya jika login)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'customerDashboard'])->name('dashboard');

    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/order', [OrderController::class, 'create'])->name('customer.order');
    Route::post('/order', [OrderController::class, 'store'])->name('customer.order.store');
});

// Route Admin
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/orders/{id}/edit', [AdminController::class, 'editStatus'])->name('admin.orders.edit');
    Route::get('/pesanan', [AdminController::class, 'statusList'])->name('admin.kelola.pesanan');
    Route::get('/pesanan/{id}', [AdminController::class, 'detail'])->name('admin.pesanan.detail');
    Route::post('/pesanan/{id}/kirim-harga', [PesananController::class, 'kirimHarga'])->name('pesanan.kirimHarga');
    Route::get('/kelola-pesanan', [AdminController::class, 'kelolaPesanan'])->name('admin.orders');
    Route::get('/data-pengguna', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/service-history', [ServiceController::class, 'history'])->name('service.history');
    Route::get('/riwayat-pembelian', [PurchaseController::class, 'history'])->name('purchase.history');
    Route::get('/ubah-status-pesanan', [AdminController::class, 'statusList'])->name('admin.orders.status');
    Route::get('/ubah-status/{id}', [AdminController::class, 'editStatus'])->name('admin.orders.editStatus');
    Route::patch('/ubah-status/{id}', [AdminController::class, 'updateStatus'])->name('admin.orders.updateStatus');
    Route::patch('/tolak-pesanan/{id}', [AdminController::class, 'rejectOrder'])->name('admin.orders.reject');
    Route::get('/detail-pesanan/{id}', [AdminController::class, 'detail'])->name('admin.orders.detail');
    Route::get('/admin/orders/status/{status}', [AdminController::class, 'statusBy'])->name('admin.orders.byStatus');
    Route::get('/admin/orders/{status}/status', [OrderController::class, 'status'])->name('admin.orders.byStatus');
    Route::post('/admin/orders/{id}/status', [AdminController::class, 'updateStatus'])->name('admin.orders.update');
    Route::get('/admin/orders/all', [AdminController::class, 'allOrders'])->name('admin.orders.all');
    Route::get('/admin/pesanan/{id}', [AdminController::class, 'showPesanan']);
    Route::get('/admin/detail-pesanan/{id}', [AdminController::class, 'detailPesanan']);
    Route::delete('/admin/orders/{id}', [OrderController::class, 'destroy'])->name('order.destroy');
    Route::get('/admin/pesanan/{id}', [AdminController::class, 'showPesanan'])->name('admin.pesanan.show');
    Route::post('/admin/pesanan/{id}/konfirmasi', [AdminController::class, 'konfirmasiPesanan'])->name('admin.pesanan.konfirmasi');
});

// Route khusus untuk Customer
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/riwayat', [CustomerController::class, 'riwayat'])->name('customer.riwayat');
    Route::get('/dashboard/tracking', [CustomerController::class, 'tracking'])->name('customer.tracking');
    Route::get('/dashboard/ulasan', [CustomerController::class, 'ulasan'])->name('customer.ulasan');
    Route::post('/dashboard/ulasan', [CustomerController::class, 'storeReview'])->name('ulasan.store');
});

// Review terpisah (jika mau pakai controller khusus)
Route::middleware(['auth'])->group(function () {
    Route::get('/review/{orderId}/create', [ReviewController::class, 'create'])->name('review.create');
    Route::post('/review/{orderId}', [ReviewController::class, 'store'])->name('review.store');
});

// Pembayaran
Route::post('/payment/store', [PaymentController::class, 'store'])->name('payment.store');
Route::get('/dashboard/pembayaran', [CustomerController::class, 'pembayaran'])->name('customer.pembayaran');
Route::post('/admin/orders/{id}/status', [AdminController::class, 'updateStatus'])->name('admin.orders.status');
