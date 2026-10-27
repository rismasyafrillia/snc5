<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Info Acara | Sparkling Nganjuk Carnival #5</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/event-info.css') }}">
</head>
<body>

    {{-- NAVBAR --}}
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top snc-navbar">
        <div class="container">
            <a class="navbar-brand snc-brand" href="{{ route('home') }}">
                <span class="brand-symbol">S</span>
                <span>
                    <strong>SPARKLING</strong>
                    <small>NGANJUK CARNIVAL #5</small>
                </span>
            </a>

            <button class="navbar-toggler" type="button"
                    data-bs-toggle="collapse" data-bs-target="#mainNavbar"
                    aria-controls="mainNavbar" aria-expanded="false"
                    aria-label="Buka navigasi">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNavbar">
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
                        <a class="nav-link active" href="{{ route('pages.event-info') }}">Info Acara</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-gold nav-order-btn" href="{{ route('orders.create') }}">
                            Pesan Tiket ↗
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- HERO --}}
    <header class="event-hero">
        <div class="event-hero-overlay"></div>
        <div class="event-hero-decoration event-decoration-one"></div>
        <div class="event-hero-decoration event-decoration-two"></div>

        <div class="container event-hero-content">
            <p class="event-eyebrow">SPARKLING NGANJUK CARNIVAL #5</p>
            <p class="event-edition">EVENT INFORMATION · 2026</p>

            <h1>Ruang untuk<br><span>Merayakan</span></h1>

            <p class="event-hero-subtitle">
                ASMARADANA — The Symphony of Love
            </p>

            <div class="event-gold-line"></div>

            <p class="event-hero-description">
                Temukan informasi seputar rangkaian acara, pengalaman seni,
                dan perayaan budaya dalam Sparkling Nganjuk Carnival #5.
            </p>

            <div class="event-hero-actions">
                <a href="#detail-acara" class="btn-gold">
                    Lihat Info Acara <span>↓</span>
                </a>
                <a href="#rangkaian-acara" class="btn-outline-gold">
                    Rangkaian Acara
                </a>
            </div>

            <div class="event-bottom-label">
                <span>ART & PERFORMANCE</span>
                <span>FASHION & CULTURE</span>
                <span>CREATIVITY & LOCAL POTENTIAL</span>
            </div>
        </div>
    </header>

    {{-- PENGANTAR --}}
    <section class="event-intro section-padding" id="detail-acara">
        <div class="container">
            <div class="row g-5 align-items-start">
                <div class="col-lg-5">
                    <p class="event-section-eyebrow">01 / EVENT OVERVIEW</p>
                    <h2 class="section-title">
                        Satu Perayaan,<br>
                        Beragam <em>Ekspresi.</em>
                    </h2>
                </div>

                <div class="col-lg-7">
                    <p class="event-intro-lead">
                        Seni, mode, dan budaya bertemu dalam satu panggung
                        perayaan kreativitas.
                    </p>

                    <p class="event-body">
                        Sparkling Nganjuk Carnival #5 merupakan kegiatan seni
                        pertunjukan dan fashion carnival yang mengangkat
                        kreativitas kostum, tradisi, busana, serta cerita dan
                        kearifan lokal.
                    </p>

                    <p class="event-body">
                        Dalam rangkaian kegiatan tahun 2026, perayaan ini
                        mengusung tema ASMARADANA — The Symphony of Love,
                        dengan semangat merayakan cinta, menyatukan budaya,
                        dan menyambut kehidupan baru.
                    </p>
                </div>
            </div>

            <div class="event-detail-grid">
                <article class="event-detail-card">
                    <span class="event-detail-number">01</span>
                    <span class="event-detail-icon">✧</span>
                    <p class="event-detail-label">NAMA KEGIATAN</p>
                    <h3>Sparkling Nganjuk Carnival #5</h3>
                    <p class="event-detail-note">
                        Perayaan seni pertunjukan dan fashion carnival.
                    </p>
                </article>

                <article class="event-detail-card">
                    <span class="event-detail-number">02</span>
                    <span class="event-detail-icon">◇</span>
                    <p class="event-detail-label">TEMA 2026</p>
                    <h3>ASMARADANA</h3>
                    <p class="event-detail-note">
                        The Symphony of Love.
                    </p>
                </article>

                <article class="event-detail-card">
                    <span class="event-detail-number">03</span>
                    <span class="event-detail-icon">⌖</span>
                    <article class="event-detail-card">
                        <span class="event-detail-number">03</span>
                        <span class="event-detail-icon">⌖</span>
                        <p class="event-detail-label">TANGGAL & WAKTU</p>
                        <h3>21 November 2026</h3>
                        <p class="event-detail-note">
                            Sabtu, pukul 18.00 WIB
                        </p>
                    </article>
                    <p class="event-detail-note">
                        Jadwal dan lokasi resmi akan diumumkan oleh penyelenggara.
                    </p>
                </article>
            </div>
        </div>
    </section>

    {{-- TEMA ACARA --}}
    <section class="event-theme">
        <div class="container text-center">
            <p class="event-section-eyebrow">THE THEME OF 2026</p>

            <div class="event-theme-ornament">✧</div>

            <h2>ASMARADANA</h2>
            <p class="event-theme-english">The Symphony of Love</p>

            <div class="event-theme-divider">
                <span></span>
                <span class="event-theme-star">✦</span>
                <span></span>
            </div>

            <p class="event-theme-tagline">
                Merayakan Cinta, Menyatukan Budaya,<br>
                Menyambut Kehidupan Baru.
            </p>

            <p class="event-theme-description">
                Sebuah perayaan yang merangkai cinta, kreativitas, dan
                keberagaman melalui harmoni seni dan budaya.
            </p>
        </div>
    </section>

    {{-- RANGKAIAN ACARA --}}
    <section class="event-program section-padding" id="rangkaian-acara">
        <div class="container">
            <div class="event-program-heading text-center">
                <p class="event-section-eyebrow">02 / EVENT HIGHLIGHTS</p>
                <h2 class="section-title">
                    Rangkaian <em>Perayaan</em>
                </h2>
                <p class="event-body">
                    Dua ruang perayaan yang menghadirkan seni, kreativitas,
                    serta potensi ekonomi kreatif.
                </p>
            </div>

            <div class="row g-4 mt-4">
                <div class="col-lg-6">
                    <article class="program-card">
                        <div class="program-art program-art-carnival">
                            <span class="program-art-number">01</span>
                            <span class="program-art-symbol">✧</span>
                            <span class="program-art-caption">ART · FASHION · CULTURE</span>
                        </div>

                        <div class="program-card-body">
                            <p class="event-section-eyebrow">ART & PERFORMANCE</p>
                            <h3>Sparkling Nganjuk Carnival</h3>
                            <p class="event-body">
                                Menampilkan kreativitas kostum, fashion carnival,
                                seni pertunjukan, dan ekspresi budaya yang
                                terinspirasi dari tradisi serta kearifan lokal.
                            </p>
                            <a href="{{ route('defile.index') }}" class="event-text-link">
                                Jelajahi Defile <span>→</span>
                            </a>
                        </div>
                    </article>
                </div>

                <div class="col-lg-6">
                    <article class="program-card">
                        <div class="program-art program-art-fair">
                            <span class="program-art-number">02</span>
                            <span class="program-art-symbol">◇</span>
                            <span class="program-art-caption">CREATIVE ECONOMY · UMKM</span>
                        </div>

                        <div class="program-card-body">
                            <p class="event-section-eyebrow">CREATIVE ECONOMY EXPO</p>
                            <h3>Sparkling Nganjuk Fair</h3>
                            <p class="event-body">
                                Ruang bazar dan pameran bagi pelaku UMKM serta
                                ekonomi kreatif untuk memperkenalkan produk,
                                memperluas pemasaran, dan menjangkau masyarakat.
                            </p>
                            <span class="event-text-note">
                                Informasi tenant dan bazar akan diumumkan lebih lanjut.
                            </span>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </section>

    {{-- INFORMASI PENGUNJUNG --}}
    <section class="event-visitor section-padding">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6">
                    <p class="event-section-eyebrow">03 / VISITOR INFORMATION</p>
                    <h2 class="section-title">
                        Bersiap Menjadi<br>
                        Bagian dari <em>Cerita.</em>
                    </h2>
                    <p class="event-body mt-4">
                        Nantikan informasi resmi mengenai jadwal, lokasi,
                        rangkaian kegiatan, serta akses pengunjung melalui
                        kanal informasi penyelenggara.
                    </p>
                </div>

                <div class="col-lg-6">
                    <div class="visitor-info-panel">
                        <div class="visitor-info-row">
                            <span class="visitor-info-icon">01</span>
                            <div class="visitor-info-row">
                                <div>
                                    <h3>Jadwal Acara</h3>
                                    <p>Sabtu, 21 November 2026, mulai pukul 18.00 WIB.</p>
                                </div>
                            </div>
                        </div>

                        <div class="visitor-info-row">
                            <span class="visitor-info-icon">02</span>
                            <div>
                                <h3>Lokasi Kegiatan</h3>
                                <p>Informasi lokasi resmi menyusul.</p>
                            </div>
                        </div>

                        <div class="visitor-info-row">
                            <span class="visitor-info-icon">03</span>
                            <div>
                                <h3>Tiket dan Akses</h3>
                                <p>Informasi tiket mengikuti pengumuman resmi.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="event-closing">
        <div class="container text-center">
            <p class="event-section-eyebrow">BE PART OF THE CELEBRATION</p>
            <h2>Budaya Bertemu.<br><em>Cerita Dimulai.</em></h2>
            <p>
                Ikuti perjalanan Sparkling Nganjuk Carnival #5 dan nantikan
                informasi terbaru mengenai rangkaian perayaannya.
            </p>

            <a href="{{ route('pages.about') }}" class="btn-gold">
                Kenali SNC #5 <span>→</span>
            </a>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="site-footer">
        <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
            <a class="footer-brand" href="{{ route('home') }}">
                SPARKLING NGANJUK CARNIVAL #5
            </a>

            <p>ASMARADANA — The Symphony of Love</p>

            <p>© {{ date('Y') }} Sparkling Nganjuk Carnival.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>