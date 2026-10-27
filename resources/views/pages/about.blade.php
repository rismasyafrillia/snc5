
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang SNC #5 | Sparkling Nganjuk Carnival</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/about.css') }}">
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
                        <a class="nav-link" href="{{ route('home') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('pages.about') }}">Tentang</a>
                    </li>
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

    {{-- HERO --}}
    <header class="about-hero">
        <div class="about-hero-overlay"></div>

        <div class="container about-hero-content">
            <span class="about-eyebrow">MENGENAL LEBIH DEKAT</span>
            <h1>Ketika Budaya<br>Menjadi <em>Cerita</em></h1>

            <p>
                Sparkling Nganjuk Carnival #5 hadir sebagai ruang pertemuan
                kreativitas, seni pertunjukan, fashion, dan kekayaan budaya
                dalam satu perayaan.
            </p>

            <a href="#tentang-snc" class="about-button">
                Jelajahi Cerita Kami <span>↓</span>
            </a>
        </div>

        <div class="about-hero-number">SNC <span>#05</span></div>
        <div class="about-hero-caption">ART · CULTURE · CREATIVITY</div>
    </header>

    {{-- TENTANG SNC --}}
    <section class="about-intro section-space" id="tentang-snc">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <div class="about-image-frame">
                        <img
                            src="{{ asset('images/about-snc.jpg') }}"
                            alt="Ilustrasi perayaan seni dan budaya Indonesia"
                            class="about-main-image"
                        >
                        <div class="about-image-label">
                            <span>SPARKLING NGANJUK</span>
                            <strong>Carnival #5</strong>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <span class="section-eyebrow">OUR STORY</span>
                    <h2 class="section-title">
                        Merayakan Kreativitas,<br>
                        Menghidupkan <em>Budaya</em>
                    </h2>

                    <p class="about-body">
                        Sparkling Nganjuk Carnival #5 merupakan perayaan seni
                        pertunjukan dan fashion carnival yang mengangkat
                        kreativitas kostum, tradisi, busana, serta cerita dan
                        kearifan lokal.
                    </p>

                    <p class="about-body">
                        Melalui perpaduan seni dan budaya, kegiatan ini menjadi
                        wadah untuk menampilkan gagasan kreatif sekaligus
                        memperkenalkan kekayaan budaya kepada masyarakat.
                    </p>

                    <div class="about-quote">
                        <span class="quote-mark">“</span>
                        <p>
                            Setiap karya membawa cerita. Setiap tradisi
                            menyimpan makna.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- TEMA --}}
    <section class="about-theme section-space">
        <div class="container">
            <div class="theme-card">
                <div class="theme-decoration theme-decoration-one"></div>
                <div class="theme-decoration theme-decoration-two"></div>

                <div class="theme-content">
                    <span class="section-eyebrow">THE THEME OF 2026</span>
                    <h2>ASMARADANA</h2>
                    <p class="theme-english">The Symphony of Love</p>

                    <div class="theme-divider">
                        <span></span> ✦ <span></span>
                    </div>

                    <p class="theme-tagline">
                        Merayakan Cinta, Menyatukan Budaya,<br>
                        Menyambut Kehidupan Baru.
                    </p>

                    <p class="theme-description">
                        Sebuah tema yang merangkai cinta, keindahan, dan
                        keberagaman dalam harmoni seni dan budaya.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- NILAI DAN TUJUAN --}}
    <section class="about-values section-space">
        <div class="container">
            <div class="text-center about-section-heading">
                <span class="section-eyebrow">WHAT WE CELEBRATE</span>
                <h2 class="section-title">
                    Lebih dari Sekadar <em>Carnival</em>
                </h2>
                <p>
                    Sebuah perayaan yang mempertemukan karya, identitas,
                    dan potensi lokal.
                </p>
            </div>

            <div class="row g-4 mt-3">
                <div class="col-md-4">
                    <article class="value-card">
                        <span class="value-number">01</span>
                        <div class="value-icon">✧</div>
                        <h3>Kreativitas</h3>
                        <p>
                            Menghadirkan karya kostum, busana, dan seni
                            pertunjukan dengan gagasan yang beragam.
                        </p>
                    </article>
                </div>

                <div class="col-md-4">
                    <article class="value-card">
                        <span class="value-number">02</span>
                        <div class="value-icon">❋</div>
                        <h3>Warisan Budaya</h3>
                        <p>
                            Mengangkat tradisi, simbol, cerita, dan
                            kearifan lokal melalui ekspresi seni.
                        </p>
                    </article>
                </div>

                <div class="col-md-4">
                    <article class="value-card">
                        <span class="value-number">03</span>
                        <div class="value-icon">◇</div>
                        <h3>Potensi Lokal</h3>
                        <p>
                            Membuka ruang apresiasi bagi kreativitas
                            dan potensi ekonomi kreatif daerah.
                        </p>
                    </article>
                </div>
            </div>
        </div>
    </section>

    {{-- PENUTUP --}}
    <section class="about-closing">
        <div class="container text-center">
            <span class="section-eyebrow">BE PART OF THE STORY</span>
            <h2>Setiap Budaya Punya Cerita.<br>
                Setiap Cerita Layak <em>Dirayakan.</em>
            </h2>
            <p>
                Temukan ragam ekspresi seni dan budaya dalam
                Sparkling Nganjuk Carnival #5.
            </p>
            <a href="{{ route('defile.index') }}" class="about-button">
                Jelajahi Defile <span>→</span>
            </a>
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