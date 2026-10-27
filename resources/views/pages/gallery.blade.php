<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri | Sparkling Nganjuk Carnival #5</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/gallery.css') }}">
</head>
<body>

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
                    <a class="nav-link active" href="{{ route('home') }}">Beranda</a>
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
                    <a class="btn btn-gold nav-order-btn" href="{{ route('orders.create') }}">
                        Pesan Tiket ↗
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<header class="gallery-hero">
    <div class="gallery-hero-pattern"></div>
    <div class="container text-center position-relative">
        <span class="gallery-eyebrow">VISUAL JOURNEY · SNC #5</span>
        <h1>Merangkai Cerita<br><em>Dalam Sebuah Perayaan</em></h1>
        <p>
            Setiap detail menyimpan cerita, setiap warna membawa makna.
            Temukan keindahan budaya dan imajinasi dalam semangat
            Sparkling Nganjuk Carnival.
        </p>
        <a href="#gallery-content" class="gallery-scroll">Jelajahi Galeri <span>↓</span></a>
    </div>
</header>

<section class="gallery-section" id="gallery-content">
    <div class="container">
        <div class="gallery-heading">
            <div>
                <span class="section-kicker">THE VISUAL COLLECTION</span>
                <h2>Ruang <em>Kreativitas</em></h2>
            </div>
            <p>
                Dari warisan tradisi hingga imajinasi tanpa batas,
                setiap karya menjadi bagian dari simfoni cinta.
            </p>
        </div>

        <div class="gallery-grid">
            <article class="gallery-card gallery-card-large">
                <div class="gallery-art art-puspawara">
                    <span class="art-number">01</span>
                    <div class="art-orbit orbit-one"></div>
                    <div class="art-orbit orbit-two"></div>
                    <div class="art-flower">✺</div>
                    <span class="art-caption">SACRED HERITAGE</span>
                </div>
                <div class="gallery-card-info">
                    <div>
                        <span>DEFILE 01</span>
                        <h3>Puspawara</h3>
                    </div>
                    <p>Warisan pernikahan yang sakral.</p>
                </div>
            </article>

            <article class="gallery-card">
                <div class="gallery-art art-maharajani">
                    <span class="art-number">02</span>
                    <div class="art-crown">♛</div>
                    <div class="art-sparkle sparkle-one">✦</div>
                    <div class="art-sparkle sparkle-two">✧</div>
                    <span class="art-caption">ROYAL ROMANCE</span>
                </div>
                <div class="gallery-card-info">
                    <div>
                        <span>DEFILE 02</span>
                        <h3>Maharajani</h3>
                    </div>
                    <p>Romansa kerajaan Nusantara.</p>
                </div>
            </article>

            <article class="gallery-card">
                <div class="gallery-art art-fantasia">
                    <span class="art-number">03</span>
                    <div class="fantasia-moon">☾</div>
                    <div class="fantasia-star star-one">✦</div>
                    <div class="fantasia-star star-two">✧</div>
                    <div class="fantasia-star star-three">✦</div>
                    <span class="art-caption">ENCHANTED UNIVERSE</span>
                </div>
                <div class="gallery-card-info">
                    <div>
                        <span>DEFILE 03</span>
                        <h3>Asmara Fantasia</h3>
                    </div>
                    <p>Alam semesta cinta yang memesona.</p>
                </div>
            </article>

            <article class="gallery-card gallery-card-wide">
                <div class="gallery-art art-asmaradana">
                    <span class="art-number">04</span>
                    <div class="asmaradana-symbol">❋</div>
                    <div class="asmaradana-copy">
                        <span>SPARKLING NGANJUK CARNIVAL #5</span>
                        <h3>ASMARADANA</h3>
                        <p>The Symphony of Love</p>
                    </div>
                </div>
                <div class="gallery-card-info">
                    <div>
                        <span>THE 2026 THEME</span>
                        <h3>Merayakan Cinta</h3>
                    </div>
                    <p>Menyatukan budaya, menyambut kehidupan baru.</p>
                </div>
            </article>
        </div>

        <div class="gallery-note">
            <span class="gallery-note-icon">✦</span>
            <p>
                <strong>Galeri dokumentasi akan segera hadir.</strong><br>
                Visual di atas merupakan ilustrasi dekoratif sementara,
                bukan dokumentasi resmi kegiatan.
            </p>
        </div>
    </div>
</section>

<section class="gallery-cta">
    <div class="container text-center">
        <span class="section-kicker">BE PART OF THE STORY</span>
        <h2>Saksikan Keindahan<br><em>Asmaradana</em></h2>
        <p>Jadilah bagian dari perayaan budaya dan kreativitas di Sparkling Nganjuk Carnival #5.</p>
        <a href="{{ route('orders.create') }}" class="btn btn-snc">Jelajahi Tiket <span>↗</span></a>
    </div>
</section>

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