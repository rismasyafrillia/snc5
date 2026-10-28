
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketOrderController;
use App\Http\Controllers\MidtransWebhookController;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use App\Http\Controllers\CheckInController;

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

Route::post('/orders/{order_code}/payment-token', [
    TicketOrderController::class,
    'paymentToken',
])->name('orders.payment-token');

Route::post('/midtrans/webhook', [
    MidtransWebhookController::class,
    'handle',
])
    ->withoutMiddleware([ValidateCsrfToken::class])
    ->name('midtrans.webhook');

Route::get(
    '/orders/{order_code}/status',
    [TicketOrderController::class, 'checkStatus']
)->name('orders.status');   

Route::get('/check-in', [CheckInController::class, 'index'])
    ->name('check-in.index');

Route::post('/check-in', [CheckInController::class, 'verify'])
    ->name('check-in.verify');