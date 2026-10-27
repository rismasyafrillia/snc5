<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pesan Tiket - {{ $event->name }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/order.css') }}">
</head>
<body class="order-page">

    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-dark snc-navbar">
        <div class="container">
            <a class="navbar-brand snc-brand" href="{{ route('home') }}">
                <span class="brand-symbol">S</span>
                <span>
                    <strong>SPARKLING</strong>
                    <small>NGANJUK CARNIVAL #5</small>
                </span>
            </a>

            <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse" data-bs-target="#sncNavbar"
                aria-controls="sncNavbar" aria-expanded="false"
                aria-label="Buka navigasi">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="sncNavbar">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-3">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pages.about') }}">Tentang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('defile.index') }}">Defile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pages.gallery') }}">Galeri</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pages.event-info') }}">Info Acara</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-gold nav-order-btn active"
                            href="{{ route('orders.create') }}">Pesan Tiket ↗</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- Header halaman --}}
    <header class="order-hero">
        <div class="order-hero-overlay"></div>
        <div class="container order-hero-content">
            <p class="section-eyebrow">BE PART OF THE CELEBRATION</p>
            <h1>Amankan <em>Tempatmu.</em></h1>
            <p>
                Jadilah bagian dari perayaan seni, budaya, dan kreativitas
                dalam Sparkling Nganjuk Carnival #5.
            </p>
            <div class="order-event-meta">
                <span>21 NOVEMBER 2026</span>
                <span class="meta-separator">✦</span>
                <span>18.00 WIB</span>
            </div>
        </div>
    </header>

    <main class="order-main">
        <div class="container">
            <div class="order-heading">
                <p class="section-eyebrow">TICKET RESERVATION</p>
                <h2>Pemesanan <em>Tiket</em></h2>
                <p>Pilih tiket dan lengkapi data pemesan untuk melanjutkan.</p>
            </div>

            @if ($errors->any())
                <div class="order-alert" role="alert">
                    <strong>Ada data yang perlu diperiksa.</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if ($ticketTypes->isNotEmpty())
                <form action="{{ route('orders.store') }}" method="POST" id="orderForm">
                    @csrf

                    <input type="hidden" name="event_id" value="{{ $event->id }}">

                    <div class="order-layout">
                        <section class="ticket-selection">
                            <div class="form-section-heading">
                                <span class="form-step">01</span>
                                <div>
                                    <h3>Pilih Tiket</h3>
                                    <p>Tentukan jumlah tiket yang ingin dipesan.</p>
                                </div>
                            </div>

                            <div class="ticket-list">
                                @foreach ($ticketTypes as $index => $ticket)
                                    <article class="ticket-card">
                                        <div class="ticket-card-top">
                                            <div>
                                                <span class="ticket-label">TICKET {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                                <h4>{{ $ticket->name }}</h4>
                                            </div>
                                            <div class="ticket-price">
                                                <small>Mulai dari</small>
                                                <strong>Rp{{ number_format($ticket->price, 0, ',', '.') }}</strong>
                                            </div>
                                        </div>

                                        @if ($ticket->description)
                                            <p class="ticket-description">{{ $ticket->description }}</p>
                                        @endif

                                        <input
                                            type="hidden"
                                            name="items[{{ $index }}][ticket_type_id]"
                                            value="{{ $ticket->id }}"
                                        >

                                        <div class="ticket-quantity-row">
                                            <label for="quantity_{{ $ticket->id }}">
                                                Jumlah tiket
                                            </label>

                                            <div class="quantity-control">
                                                <button type="button"
                                                    class="quantity-btn"
                                                    data-action="decrease"
                                                    data-target="quantity_{{ $ticket->id }}"
                                                    aria-label="Kurangi jumlah tiket">−</button>

                                                <input
                                                    class="quantity-input"
                                                    type="number"
                                                    id="quantity_{{ $ticket->id }}"
                                                    name="items[{{ $index }}][quantity]"
                                                    min="0"
                                                    max="10"
                                                    value="{{ old('items.'.$index.'.quantity', 0) }}"
                                                    required
                                                    data-price="{{ $ticket->price }}"
                                                >

                                                <button type="button"
                                                    class="quantity-btn"
                                                    data-action="increase"
                                                    data-target="quantity_{{ $ticket->id }}"
                                                    aria-label="Tambah jumlah tiket">+</button>
                                            </div>
                                        </div>
                                    </article>
                                @endforeach
                            </div>

                            <p class="ticket-note">
                                Maksimal 10 tiket per jenis. Pastikan jumlah tiket sudah sesuai sebelum melanjutkan.
                            </p>
                        </section>

                        <aside class="order-sidebar">
                            <div class="buyer-card">
                                <div class="form-section-heading">
                                    <span class="form-step">02</span>
                                    <div>
                                        <h3>Data Pemesan</h3>
                                        <p>Isi informasi kontak yang aktif.</p>
                                    </div>
                                </div>

                                <div class="form-field">
                                    <label for="buyer_name">Nama lengkap <span>*</span></label>
                                    <input
                                        type="text"
                                        id="buyer_name"
                                        name="buyer_name"
                                        value="{{ old('buyer_name') }}"
                                        maxlength="255"
                                        placeholder="Masukkan nama lengkap"
                                        autocomplete="name"
                                        required
                                    >
                                </div>

                                <div class="form-field">
                                    <label for="buyer_email">Alamat email <span>*</span></label>
                                    <input
                                        type="email"
                                        id="buyer_email"
                                        name="buyer_email"
                                        value="{{ old('buyer_email') }}"
                                        maxlength="255"
                                        placeholder="nama@email.com"
                                        autocomplete="email"
                                        required
                                    >
                                </div>

                                <div class="form-field">
                                    <label for="buyer_phone">Nomor telepon</label>
                                    <input
                                        type="tel"
                                        id="buyer_phone"
                                        name="buyer_phone"
                                        value="{{ old('buyer_phone') }}"
                                        maxlength="30"
                                        placeholder="Contoh: 08xxxxxxxxxx"
                                        autocomplete="tel"
                                    >
                                </div>

                                <div class="order-summary">
                                    <p class="summary-label">RINGKASAN PESANAN</p>
                                    <div class="summary-row">
                                        <span>Jumlah tiket</span>
                                        <strong id="totalQuantity">0 tiket</strong>
                                    </div>
                                    <div class="summary-total">
                                        <span>Estimasi total</span>
                                        <strong id="totalPrice">Rp0</strong>
                                    </div>
                                    <p class="summary-note">
                                        Total dihitung otomatis berdasarkan jumlah dan harga tiket yang dipilih.
                                    </p>
                                </div>

                                <button type="submit" class="order-submit-btn">
                                    Buat Pesanan <span>↗</span>
                                </button>

                                <p class="order-terms">
                                    Dengan melanjutkan, pastikan data pemesanan yang kamu masukkan sudah benar.
                                </p>
                            </div>
                        </aside>
                    </div>
                </form>
            @else
                <div class="empty-ticket-state">
                    <span>✦</span>
                    <h3>Tiket Belum Tersedia</h3>
                    <p>Jenis tiket untuk acara ini belum tersedia. Silakan kembali lagi nanti.</p>
                    <a href="{{ route('pages.event-info') }}">Kembali ke Info Acara</a>
                </div>
            @endif
        </div>
    </main>

    <footer class="site-footer">
        <div class="container footer-bottom">
            <p>© {{ date('Y') }} Sparkling Nganjuk Carnival #5</p>
            <p>ASMARADANA — The Symphony of Love</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const quantityInputs = document.querySelectorAll('.quantity-input');
            const totalQuantity = document.getElementById('totalQuantity');
            const totalPrice = document.getElementById('totalPrice');

            function formatRupiah(value) {
                return 'Rp' + new Intl.NumberFormat('id-ID').format(value);
            }

            function updateSummary() {
                let quantity = 0;
                let total = 0;

                quantityInputs.forEach(function (input) {
                    const count = Math.max(0, Math.min(10, Number(input.value) || 0));
                    const price = Number(input.dataset.price) || 0;

                    quantity += count;
                    total += count * price;
                });

                totalQuantity.textContent = quantity + (quantity === 1 ? ' tiket' : ' tiket');
                totalPrice.textContent = formatRupiah(total);
            }

            quantityInputs.forEach(function (input) {
                input.addEventListener('input', updateSummary);
                input.addEventListener('change', function () {
                    let value = Number(input.value) || 0;
                    value = Math.max(0, Math.min(10, value));
                    input.value = value;
                    updateSummary();
                });
            });

            document.querySelectorAll('.quantity-btn').forEach(function (button) {
                button.addEventListener('click', function () {
                    const input = document.getElementById(button.dataset.target);
                    if (!input) return;

                    let value = Number(input.value) || 0;

                    if (button.dataset.action === 'increase') {
                        value = Math.min(10, value + 1);
                    } else {
                        value = Math.max(0, value - 1);
                    }

                    input.value = value;
                    updateSummary();
                });
            });

            updateSummary();
        });
    </script>
</body>
</html>