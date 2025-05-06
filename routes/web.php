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
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Auth\ForgotPasswordController;

// Halaman utama
Route::get('/', [HomeController::class, 'index'])->name('home');

// FAQ
Route::get('/faq', [FaqController::class, 'index'])->name('faq');

// katalog
Route::get('/komputer', [HomeController::class, 'KomputerCatalog'])->name('komputer');
Route::get('/laptop', [HomeController::class, 'LaptopCatalog'])->name('laptop');
Route::get('/perlengkapan', [HomeController::class, 'perlengkapanCatalog'])->name('perlengkapan');
Route::get('/laptop', [HomeController::class, 'LaptopCatalog'])->name('laptop');
Route::get('/akse-laptop', [HomeController::class, 'perlengkapanLaptop'])->name('akse-laptop');

// Login & Register
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Notifikasi dibaca
Route::post('/notifikasi-read', [NotifikasiController::class, 'read'])->name('notif.read');

// Route untuk Pesanan
Route::get('/dashboard/pesanan/create', [CustomerController::class, 'createPesanan'])->name('customer.pesanan.create');
Route::post('/dashboard/pesanan', [CustomerController::class, 'storePesanan'])->name('customer.pesanan.store');

// Route Customer (hanya jika login)
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'customerDashboard'])->name('dashboard');

    // Profile
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    // Order
    Route::get('/order', [OrderController::class, 'create'])->name('customer.order');
    Route::post('/order', [OrderController::class, 'store'])->name('customer.order.store');

    // Pesanan Customer
    Route::get('/dashboard/pesanan', [CustomerController::class, 'pesananIndex'])->name('customer.pesanan.index');
    Route::get('/dashboard/pesanan/{id}', [CustomerController::class, 'pesananDetail'])->name('customer.pesanan.detail');
    Route::post('/dashboard/pesanan', [CustomerController::class, 'storePesanan'])->name('customer.pesanan.store');
    Route::get('/pesanan/create', [CustomerController::class, 'createPesanan'])->name('pesanan.create');

   
    Route::patch('/notifications/{id}/read', [NotifikasiController::class, 'markAsRead'])->name('notifications.read');
    Route::patch('/notifications/read-all', [NotifikasiController::class, 'markAllAsRead'])->name('notifications.readAll');

    
    // Riwayat Servis
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/riwayat', [CustomerController::class, 'riwayatServis'])->name('riwayat.servis');
    Route::post('/review/store', [ReviewController::class, 'store'])->name('review.store');
});


    // Ulasan
    Route::get('/dashboard/ulasan', [CustomerController::class, 'ulasan'])->name('customer.ulasan');
    Route::post('/dashboard/ulasan', [CustomerController::class, 'storeReview'])->name('ulasan.store');

    // Pembayaran
    Route::get('/dashboard/pembayaran', [CustomerController::class, 'pembayaran'])->name('customer.pembayaran');
});

// Route Admin
Route::prefix('admin')->middleware(['auth'])->group(function () {
    // Admin Dashboard
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // Orders Management
    Route::get('/orders/{id}/edit', [AdminController::class, 'editStatus'])->name('admin.orders.edit');
    Route::get('/pesanan', [AdminController::class, 'statusList'])->name('admin.kelola.pesanan');
    Route::get('/pesanan/{id}', [AdminController::class, 'detail'])->name('admin.pesanan.detail');
    Route::post('/pesanan/{id}/kirim-harga', [PesananController::class, 'kirimHarga'])->name('pesanan.kirimHarga');
    Route::post('/admin/pesanan/{id}/update-status', [PesananController::class, 'updateStatus'])->name('admin.kelola-pesanan');
    Route::get('/kelola-pesanan', [AdminController::class, 'kelolaPesanan'])->name('admin.orders');
    Route::get('/data-pengguna', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/admin/pembayaran', [PembayaranController::class, 'index'])->name('admin.pembayaran');
    Route::get('/admin/orders/all', [OrderController::class, 'index'])->name('admin.orders.all');
    Route::post('/admin/orders/status', [OrderController::class, 'updateStatus'])->name('admin.orders.status');

    Route::get('/kelola-catalog', [AdminController::class, 'kelolaCatalog'])->name('admin.catalog');
    Route::get('/admin/tambah-catalog', [ AdminController::class, 'tambahCatalog'])->name('admin.tambahCatalog');
    Route::post('/admin/store', [AdminController::class, 'store'])->name('catalog.store');
    Route::get('/admin/edit-catalog/{id}', [AdminController::class, 'editCatalog'])->name('admin.editCatalog');
    Route::put('/admin/update-catalog/{id}', [AdminController::class, 'updateCatalog'])->name('admin.updateCatalog');
    Route::get('/admin/edit-profile', [AdminController::class, 'editProfile'])->name('admin.editProfile');
    Route::put('/admin/update-profile', [AdminController::class, 'updateProfile'])->name('admin.updateProfile');
    Route::delete('/admin/delete-catalog/{id}', [AdminController::class, 'deleteCatalog'])->name('admin.deleteCatalog');
 
    Route::get('/admin/edit-harga/{id}', [AdminController::class, 'editHarga'])->name('admin.editHarga');
    Route::put('/admin/update-harga/{id}', [AdminController::class, 'updateHarga'])->name('admin.updateHarga');
    // File: routes/web.php
    Route::resource('customers', CustomerController::class);

    Route::prefix('admin')->group(function () {
        Route::resource('orders', OrderController::class);
    });


    // Service & Purchase History
    // Route::get('/service-history', [ServiceController::class, 'history'])->name('service.history');
    // Route::get('/riwayat-pembelian', [PurchaseController::class, 'history'])->name('purchase.history');
    Route::get('/customer/riwayat', [CustomerController::class, 'riwayat'])->name('customer.riwayat');

    // Manage Orders Status
    Route::get('/ubah-status/{id}', [AdminController::class, 'editStatus'])->name('admin.orders.editStatus');
    Route::patch('/ubah-status/{id}', [AdminController::class, 'updateStatus'])->name('admin.orders.updateStatus');
    Route::patch('/tolak-pesanan/{id}', [AdminController::class, 'rejectOrder'])->name('admin.orders.reject');

    // Customer Management
    Route::get('/kelola-customer', [CustomerController::class, 'index'])->name('admin.customers.index');
    Route::resource('customers', CustomerController::class);

    // Payment Management
    Route::get('payments', [PaymentController::class, 'index'])->name('admin.payments.index');
    Route::get('payments/{id}', [PaymentController::class, 'show'])->name('admin.payments.show');
    Route::post('payments/{id}/verify', [PaymentController::class, 'verify'])->name('admin.payments.verify');
    Route::post('payments/{id}/reject', [PaymentController::class, 'reject'])->name('admin.payments.reject');

    // Manage Users
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users');  // Daftar pengguna
    Route::get('/admin/users/create', [UserController::class, 'create'])->name('admin.users.create');  // Form tambah pengguna
    Route::post('/admin/users', [UserController::class, 'store'])->name('admin.users.store');  // Simpan pengguna baru
    Route::get('/admin/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');  // Form edit pengguna
    Route::put('/admin/users/{user}', [UserController::class, 'update'])->name('admin.users.update');  // Update pengguna
    Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');  // Hapus pengguna
});

// Review Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/review/{orderId}/create', [ReviewController::class, 'create'])->name('review.create');
    Route::post('/review/{orderId}', [ReviewController::class, 'store'])->name('review.store');
});
