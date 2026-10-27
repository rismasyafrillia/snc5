
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pesanan Berhasil - SNC #5</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/order.css') }}">
    @if ($order->status === 'pending')
        <script
            src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="{{ config('services.midtrans.client_key') }}">
        </script>
    @endif
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

                <h1>Pesanan <em>Berhasil</em><br>Dibuat.</h1>

                <p class="success-description">
                    Terima kasih telah menjadi bagian dari Sparkling Nganjuk Carnival #5.
                    Pesanan tiketmu sudah tercatat dalam sistem.
                </p>

                <div class="order-code-box">
                    <span>KODE PESANAN</span>
                    <strong>{{ $order->order_code }}</strong>
                </div>

                            @if ($order->status === 'pending')
                <div class="payment-notice">
                    <span class="notice-symbol">!</span>
                    <div>
                        <strong>Pesanan menunggu pembayaran</strong>
                        <p>
                            Selesaikan pembayaran melalui Midtrans sebelum batas
                            waktu pembayaran berakhir.
                        </p>
                    </div>
                </div>

                <button
                    type="button"
                    id="pay-button"
                    class="success-home-btn"
                    data-token-url="{{ route('orders.payment-token', ['order_code' => $order->order_code]) }}"
                >
                    Bayar Sekarang <span>↗</span>
                </button>

                <p id="payment-message" role="status" aria-live="polite"></p>
            @elseif ($order->status === 'paid')
                <div class="payment-notice">
                    <span class="notice-symbol">✓</span>
                    <div>
                        <strong>Pembayaran telah dikonfirmasi</strong>
                        <p>Pesanan ini telah tercatat sebagai lunas.</p>
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
                    Halaman ini merupakan konfirmasi bahwa pesanan telah tercatat,
                    bukan bukti bahwa pembayaran telah berhasil.
                </p>

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
    document.addEventListener('DOMContentLoaded', function () {
        const payButton = document.getElementById('pay-button');
        const message = document.getElementById('payment-message');

        if (!payButton) return;

        payButton.addEventListener('click', async function () {
            payButton.disabled = true;
            message.textContent = 'Menyiapkan pembayaran...';

            try {
                const response = await fetch(payButton.dataset.tokenUrl, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({})
                });

                const data = await response.json();

                if (!response.ok || !data.token) {
                    throw new Error(
                        data.message || 'Gagal menyiapkan pembayaran.'
                    );
                }

                window.snap.pay(data.token, {
                    onSuccess: async function () {
                    message.textContent =
                        'Pembayaran berhasil diproses. Memverifikasi status pesanan...';

                    const statusUrl = @json(
                        route('orders.status', ['order_code' => $order->order_code])
                    );

                    let attempts = 0;
                    const maxAttempts = 15;

                    const checkPayment = async () => {
                        try {
                            const response = await fetch(statusUrl, {
                                headers: {
                                    'Accept': 'application/json'
                                },
                                cache: 'no-store'
                            });

                            if (!response.ok) {
                                throw new Error('Gagal memeriksa status pesanan.');
                            }

                            const data = await response.json();

                            if (data.status === 'paid') {
                                window.location.reload();
                                return;
                            }

                            if (
                                ['expired', 'cancelled'].includes(data.status)
                            ) {
                                message.textContent =
                                    'Status pesanan: ' + data.status + '. Hubungi penyelenggara jika pembayaran sudah berhasil.';
                                payButton.disabled = false;
                                return;
                            }

                            attempts++;

                            if (attempts < maxAttempts) {
                                setTimeout(checkPayment, 2000);
                            } else {
                                message.textContent =
                                    'Pembayaran sedang diverifikasi. Silakan muat ulang halaman beberapa saat lagi.';
                                payButton.disabled = false;
                            }
                        } catch (error) {
                            message.textContent =
                                'Status pembayaran belum dapat diperiksa. Silakan muat ulang halaman.';
                            payButton.disabled = false;
                        }
                    };

                    checkPayment();
                },
                });
            } catch (error) {
                message.textContent = error.message ||
                    'Terjadi kesalahan saat membuka pembayaran.';
                payButton.disabled = false;
            }
        });
    });
    </script>
    @endif
</body>
</html>
