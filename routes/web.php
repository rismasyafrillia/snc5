<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CheckInController;
use App\Http\Controllers\DeployWebhookController;
use App\Http\Controllers\TicketOrderController;
use Illuminate\Support\Facades\Route;

// Beranda
Route::view('/', 'home')->name('home');

Route::view('/tentang', 'pages.about')->name('pages.about');

// Halaman informasi
Route::view('/tentang', 'pages.about')->name('pages.about');
Route::view('/defile', 'defile.index')->name('defile.index');
Route::view('/defile/puspawara', 'defile.puspawara')->name('defile.puspawara');
Route::view('/defile/maharajani', 'defile.maharajani')->name('defile.maharajani');
Route::view('/defile/asmara-fantasia', 'defile.asmara-fantasia')->name('defile.asmara-fantasia');
Route::view('/galeri', 'pages.gallery')->name('pages.gallery');
Route::view('/info-acara', 'pages.event-info')->name('pages.event-info');

Route::view('/defile/puspawara', 'defile.puspawara')->name('defile.puspawara');
Route::view('/defile/maharajani', 'defile.maharajani')->name('defile.maharajani');
Route::view('/defile/asmara-fantasia', 'defile.asmara-fantasia')->name('defile.asmara-fantasia');

// Pemesanan tiket
Route::get('/pesan-tiket', [
    TicketOrderController::class,
    'create',
])->name('orders.create');

Route::post('/orders', [
    TicketOrderController::class,
    'store',
])->name('orders.store');

Route::get('/orders/{order_code}/success', [
    TicketOrderController::class,
    'success',
])->name('orders.success');

Route::get('/orders/{order_code}/payment', [
    TicketOrderController::class,
    'payment',
])->name('orders.payment');

Route::get(
    '/orders/{order_code}/status',
    [TicketOrderController::class, 'checkStatus']
)->name('orders.status');

Route::post('/deploy/github-webhook', [DeployWebhookController::class, 'handle'])
    ->name('deploy.github-webhook');

Route::get('/check-in', [CheckInController::class, 'index'])
    ->name('check-in.index');

Route::post('/check-in', [CheckInController::class, 'verify'])
    ->name('check-in.verify');

// Login admin
Route::get('/admin/login', [
    AdminController::class,
    'login',
])->name('admin.login');

Route::post('/admin/login', [
    AdminController::class,
    'authenticate',
])->name('admin.authenticate');

// Dashboard admin
Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [
        AdminController::class,
        'dashboard',
    ])->name('dashboard');

    Route::get('/check-ins/export', [
        AdminController::class,
        'exportCheckedInTickets',
    ])->name('check-ins.export');

    Route::put('/tickets/{ticketType}', [
        AdminController::class,
        'updateTicket',
    ])->name('tickets.update');

    Route::post('/orders/{order}/confirm-payment', [
        AdminController::class,
        'confirmPayment',
    ])->name('orders.confirm-payment');

    Route::post('/orders/{order}/confirm-expired-payment', [
        AdminController::class,
        'confirmExpiredPayment',
    ])->name('orders.confirm-expired-payment');

    Route::post('/logout', [
        AdminController::class,
        'logout',
    ])->name('logout');
});
