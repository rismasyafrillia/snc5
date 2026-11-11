
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pembayaran - SNC #5</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/order.css') }}">
</head>
<body class="order-page success-page">

    <nav class="navbar navbar-expand-lg navbar-dark snc-navbar">
        <div class="container">
            <a class="navbar-brand snc-brand" href="{{ route('home') }}">
                <span class="brand-symbol">S</span>
                <span>
                    <strong>SPARKLING</strong>
                    <small>NGANJUK CARNIVAL #5</small>
                </span>
            </a>

            <a href="{{ route('home') }}" class="success-nav-link">
                Kembali ke Beranda ↗
            </a>
        </div>
    </nav>

    <main class="success-main">
        <div class="container">
            <section class="success-card">

                <div class="success-icon">
                    <svg viewBox="0 0 48 48" fill="none" aria-hidden="true">
                        <circle cx="24" cy="24" r="21" stroke="currentColor" stroke-width="1.5"/>
                        <path d="M14 24.5L21 31L34 17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>

                <p class="section-eyebrow">ORDER CONFIRMATION</p>

                @if ($order->status === 'pending')
                    <h1>Menunggu <em>Pembayaran</em></h1>
                @elseif ($order->status === 'paid')
                    <h1>Pembayaran <em>Terkonfirmasi</em></h1>
                @elseif ($order->status === 'expired')
                    <h1>Pesanan <em>Kedaluwarsa</em></h1>
                @else
                    <h1>Status <em>Pesanan</em></h1>
                @endif

                <p class="success-description">
                    Terima kasih telah menjadi bagian dari Sparkling Nganjuk Carnival #5.
                    Pesanan tiketmu sudah tercatat dalam sistem.
                    Mohon cantumkan <strong>nama lengkap pemesan</strong>
                    pada keterangan pembayaran atau berita transfer.
                    Pastikan nama yang dicantumkan sesuai dengan nama
                    saat melakukan pemesanan tiket agar pembayaran
                    mudah diverifikasi oleh admin.
                </p>

                <div class="ticketing-brand ticketing-brand-text">
                    <span>Ticketing by</span>
                    <strong>SWATANTRA</strong>
                    <small>CREATIVE EVENT</small>
                </div>

                <div class="order-code-box">
                    <span>KODE PESANAN</span>
                    <strong>{{ $order->order_code }}</strong>
                </div>

                @if ($order->status === 'pending')
                @if ($paymentQrImage)
                    <div class="qris-payment">
                        <img
                            class="qris-code"
                            src="data:image/png;base64,{{ $paymentQrImage }}"
                            alt="QRIS dinamis untuk pesanan {{ $order->order_code }}"
                        >
                        <p>
                            Bayar tepat sebesar
                            <strong>Rp{{ number_format($order->total_amount, 0, ',', '.') }}</strong>
                            menggunakan aplikasi yang mendukung QRIS.
                        </p>
                    </div>
                @elseif ($paymentError)
                    <div class="payment-notice" role="alert">
                        <span class="notice-symbol">!</span>
                        <div>
                            <strong>QRIS belum dapat ditampilkan</strong>
                            <p>{{ $paymentError }}</p>
                        </div>
                    </div>
                @endif

                <div class="payment-notice">
                    <span class="notice-symbol">!</span>
                    <div>
                        <strong>Pesanan menunggu pembayaran</strong>
                        <p>
                            Selesaikan pembayaran dalam
                            <strong
                                id="payment-countdown"
                                data-expires-at="{{ ($order->expires_at ?? $order->created_at->copy()->addMinutes(15))->timestamp }}"
                                role="timer"
                                aria-label="Waktu tersisa untuk pembayaran"
                            >--:--</strong>.
                            Batas waktu:
                            <strong>{{ ($order->expires_at ?? $order->created_at->copy()->addMinutes(15))->timezone('Asia/Jakarta')->format('H:i') }} WIB</strong>.
                            Setelah pembayaran berhasil, admin akan memeriksa dan mengonfirmasi transaksi secara manual.
                        </p>
                    </div>
                </div>
            @elseif ($order->status === 'paid')
                <div class="payment-notice">
                    <span class="notice-symbol">✓</span>
                    <div>
                        <strong>Pembayaran telah dikonfirmasi</strong>
                        <p>Pesanan ini telah tercatat sebagai lunas.</p>
                    </div>
                </div>
            @elseif ($order->status === 'expired')
                <div class="payment-notice" role="alert">
                    <span class="notice-symbol">!</span>
                    <div>
                        <strong>Batas pembayaran 15 menit telah berakhir</strong>
                        <p>Reservasi tiket telah dilepas. Silakan buat pesanan baru jika masih ingin membeli tiket.</p>
                    </div>
                </div>
            @else
                <div class="payment-notice">
                    <span class="notice-symbol">!</span>
                    <div>
                        <strong>Status pesanan: {{ $order->status }}</strong>
                        <p>Silakan periksa status pesanan atau hubungi penyelenggara.</p>
                    </div>
                </div>
            @endif

                <div class="success-divider"></div>

                <div class="success-section-heading">
                    <span class="form-step">01</span>
                    <div>
                        <h2>Informasi Pemesan</h2>
                        <p>Data yang digunakan saat melakukan pemesanan.</p>
                    </div>
                </div>

                <div class="order-information">
                    <div class="information-row">
                        <span>Nama lengkap</span>
                        <strong>{{ $order->buyer_name }}</strong>
                    </div>

                    <div class="information-row">
                        <span>Email</span>
                        <strong>{{ $order->buyer_email }}</strong>
                    </div>

                    <div class="information-row">
                        <span>Nama acara</span>
                        <strong>{{ $order->event->name }}</strong>
                    </div>

                    <div class="information-row">
                        <span>Status pesanan</span>
                        <strong class="status-label">{{ $order->status }}</strong>
                    </div>
                </div>

                <div class="success-divider"></div>

                <div class="success-section-heading">
                    <span class="form-step">02</span>
                    <div>
                        <h2>Rincian Tiket</h2>
                        <p>Periksa kembali tiket yang telah kamu pesan.</p>
                    </div>
                </div>

                <div class="success-ticket-list">
                    @foreach ($order->items as $item)
                        <div class="success-ticket-item">
                            <div class="success-ticket-symbol">✦</div>

                            <div class="success-ticket-name">
                                <strong>{{ $item->ticketType->name }}</strong>
                                <span>{{ $item->quantity }} tiket</span>
                            </div>

                            <strong class="success-ticket-price">
                                Rp{{ number_format($item->subtotal, 0, ',', '.') }}
                            </strong>
                        </div>
                    @endforeach
                </div>

                <div class="success-total">
                    <span>Total Pesanan</span>
                    <strong>
                        Rp{{ number_format($order->total_amount, 0, ',', '.') }}
                    </strong>
                </div>

                <p class="success-disclaimer">
                    @if ($order->status === 'pending')
                        Pembayaran akan dinyatakan lunas setelah diverifikasi oleh admin.
                    @else
                        Simpan kode pesanan ini untuk referensi tiket.
                    @endif
                </p>

                <div class="success-support">
                    <p class="success-spam-note">
                        Jika tiket belum muncul di email, periksa folder Spam.
                    </p>
                    @if (in_array($order->status, ['pending', 'expired'], true))
                        <p class="success-spam-note">
                            Jika tiket belum muncul di email/folder spam, kirim capture riwayat transaksi melalui WhatsApp di bawah ini. Admin akan memverifikasi pembayaran melalui riwayat transaksi merchant.
                        </p>
                        <a
                            class="payment-whatsapp-btn"
                            href="{{ $paymentWhatsappUrl }}"
                            target="_blank"
                            rel="noopener noreferrer"
                        >
                            <span>Konfirmasi pembayaran via WhatsApp</span>
                            <span aria-hidden="true">↗</span>
                        </a>
                    @endif
                </div>

                <a href="{{ route('home') }}" class="success-home-btn">
                    Kembali ke Beranda <span>↗</span>
                </a>

            </section>

            <p class="success-footer-note">
                ASMARADANA — THE SYMPHONY OF LOVE
                <span>·</span>
                21 NOVEMBER 2026
            </p>
        </div>
    </main>

    @if ($order->status === 'pending')
        <script>
            const paymentCountdown = document.getElementById('payment-countdown');
            const paymentExpiresAt = Number(paymentCountdown.dataset.expiresAt);
            let hasReloadedAtExpiry = false;
            let countdownInterval;

            function updatePaymentCountdown() {
                const remainingSeconds = Math.max(
                    0,
                    paymentExpiresAt - Math.floor(Date.now() / 1000)
                );
                const minutes = Math.floor(remainingSeconds / 60);
                const seconds = remainingSeconds % 60;

                paymentCountdown.textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;

                if (remainingSeconds === 0 && !hasReloadedAtExpiry) {
                    hasReloadedAtExpiry = true;
                    window.clearInterval(countdownInterval);
                    window.location.reload();
                }
            }

            countdownInterval = window.setInterval(updatePaymentCountdown, 1000);
            updatePaymentCountdown();
        </script>
    @endif

</body>
</html>
