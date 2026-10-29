<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sparkling Nganjuk Carnival #5 | ASMARADANA</title>
    <meta name="description" content="Jelajahi Sparkling Nganjuk Carnival #5, ASMARADANA — The Symphony of Love. Merayakan Cinta, Menyatukan Budaya, Menyambut Kehidupan Baru.">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
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

<main>

    <!-- HERO -->
    <section class="hero-section">
        <div class="hero-overlay"></div>

        <div class="hero-visual">
            <div class="hero-art">
                <span class="hero-art-top">THE SYMPHONY OF LOVE</span>
                <span class="hero-art-flower">✳</span>
                <span class="hero-art-bottom">ASMARADANA · 2026</span>
            </div>
        </div>

        <div class="hero-decoration decoration-one"></div>
        <div class="hero-decoration decoration-two"></div>

        <div class="container hero-content">
            <p class="eyebrow">A CELEBRATION OF CULTURE, ART & LOVE</p>
            <p class="hero-edition">THE 5TH EDITION · NGANJUK, INDONESIA</p>

            <h1>ASMA<span>RA</span>DANA</h1>
            <p class="hero-subtitle">The Symphony of Love</p>

            <div class="gold-line"></div>

            <p class="hero-tagline">
                Merayakan Cinta, Menyatukan Budaya,<br class="d-none d-md-block">
                Menyambut Kehidupan Baru.
            </p>

            <div class="hero-actions">
                <a href="{{ route('orders.create') }}" class="btn btn-gold">
                    Jelajahi Tiket <span>↗</span>
                </a>

                <a href="{{ route('defile.index') }}" class="btn btn-outline-gold">
                    Temukan Tiga Defile
                </a>
            </div>

            <div class="hero-bottom-label">
                <span>ART · CULTURE · FASHION · PERFORMANCE</span>
                <span>SPARKLING NGANJUK CARNIVAL #5</span>
            </div>
        </div>
    </section>

    <!-- INTRODUCTION -->
    <section class="intro-section section-padding">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-5">
                    <p class="eyebrow dark-eyebrow">THE STORY BEHIND ASMARADANA</p>

                    <h2 class="section-title">
                        Ketika Budaya<br>
                        Menjadi <em>Cerita.</em>
                    </h2>

                    <div class="gold-line"></div>
                </div>

                <div class="col-lg-7">
                    <p class="intro-copy">
                        Sebuah perayaan tentang cinta yang diwujudkan melalui
                        keindahan seni, busana, tradisi, dan imajinasi.
                    </p>

                    <p class="body-copy">
                        Pada edisi kelima, Sparkling Nganjuk Carnival menghadirkan
                        ASMARADANA — The Symphony of Love. Sebuah perjalanan
                        kreatif yang merangkai kekayaan budaya Nusantara dengan
                        ekspresi fashion carnival dan seni pertunjukan.
                    </p>

                    <a href="{{ route('pages.about') }}" class="text-link">
                        Kenali Sparkling Nganjuk Carnival <span>→</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- THEME -->
    <section class="theme-section section-padding">
        <div class="container text-center">
            <p class="eyebrow">THE THEME OF 2026</p>

            <h2 class="theme-title">ASMARADANA</h2>
            <p class="theme-subtitle">The Symphony of Love</p>

            <div class="gold-line mx-auto"></div>

            <p class="theme-description">
                Merayakan cinta, menyatukan budaya, dan menyambut kehidupan baru
                melalui harmoni tradisi, seni, dan kreativitas.
            </p>
        </div>
    </section>

    <!-- THREE DEFILES -->
    <section class="defile-section section-padding">
        <div class="container">
            <div class="section-heading text-center">
                <p class="eyebrow dark-eyebrow">THREE WORLDS OF LOVE</p>

                <h2 class="section-title">
                    Tiga Defile,<br>
                    <em>Tiga Cerita Istimewa.</em>
                </h2>

                <p class="body-copy mt-3">
                    Menelusuri cinta melalui sakralnya tradisi, megahnya kerajaan,
                    dan luasnya imajinasi.
                </p>
            </div>

            <div class="row g-4 mt-4">

                <!-- PUSPAWARA -->
                <div class="col-md-4">
                    <article class="defile-card">
                        <div class="defile-art defile-art-one">
                            <span class="defile-art-number">01</span>
                            <span class="defile-art-symbol">❋</span>
                            <span class="defile-art-label">SACRED HERITAGE</span>
                        </div>

                        <div class="defile-card-body">
                            <p class="defile-kicker">THE SACRED WEDDING HERITAGE</p>
                            <h3>Puspawara</h3>

                            <p>
                                Mengangkat kesakralan tradisi pernikahan Nusantara
                                melalui simbol, ragam hias, busana, dan ritual
                                yang sarat makna.
                            </p>

                            <a href="{{ route('defile.puspawara') }}" class="text-link">
                                Jelajahi Puspawara <span>→</span>
                            </a>
                        </div>
                    </article>
                </div>

                <!-- MAHARAJANI -->
                <div class="col-md-4">
                    <article class="defile-card">
                        <div class="defile-art defile-art-two">
                            <span class="defile-art-number">02</span>
                            <span class="defile-art-symbol">♛</span>
                            <span class="defile-art-label">ROYAL ROMANCE</span>
                        </div>

                        <div class="defile-card-body">
                            <p class="defile-kicker">THE ROYAL ROMANCE OF NUSANTARA</p>
                            <h3>Maharajani</h3>

                            <p>
                                Kisah cinta kerajaan Nusantara hadir melalui
                                kemegahan raja-ratu, romantisme legenda,
                                dan pesona busana tradisional.
                            </p>

                            <a href="{{ route('defile.maharajani') }}" class="text-link">
                                Jelajahi Maharajani <span>→</span>
                            </a>
                        </div>
                    </article>
                </div>

                <!-- ASMARA FANTASIA -->
                <div class="col-md-4">
                    <article class="defile-card">
                        <div class="defile-art defile-art-three">
                            <span class="defile-art-number">03</span>
                            <span class="defile-art-symbol">✧</span>
                            <span class="defile-art-label">ENCHANTED UNIVERSE</span>
                        </div>

                        <div class="defile-card-body">
                            <p class="defile-kicker">THE ENCHANTED UNIVERSE OF LOVE</p>
                            <h3>Asmara Fantasia</h3>

                            <p>
                                Ruang bagi imajinasi tanpa batas, terinspirasi
                                dari alam, flora, fauna, mitologi, dan potensi
                                lokal yang diolah menjadi karya carnival.
                            </p>

                            <a href="{{ route('defile.asmara-fantasia') }}" class="text-link">
                                Jelajahi Asmara Fantasia <span>→</span>
                            </a>
                        </div>
                    </article>
                </div>

            </div>

            <div class="text-center mt-5">
                <a href="{{ route('defile.index') }}" class="btn btn-maroon">
                    Kenali Seluruh Defile <span>↗</span>
                </a>
            </div>
        </div>
    </section>

    <!-- EXPERIENCE -->
    <section class="experience-section section-padding">
        <div class="container">
            <div class="section-heading text-center">
                <p class="eyebrow dark-eyebrow">THE EXPERIENCE</p>

                <h2 class="section-title">
                    Lebih dari Sekadar <em>Perayaan.</em>
                </h2>

                <p class="body-copy">
                    Sebuah pertemuan seni, budaya, dan kreativitas dalam
                    satu perayaan yang penuh cerita.
                </p>
            </div>

            <div class="row g-4 mt-4">
                <div class="col-md-4">
                    <article class="experience-card">
                        <div class="experience-number">01</div>
                        <div class="experience-icon">✳</div>
                        <h3>Fashion Carnival</h3>
                        <p>
                            Kreasi kostum artistik yang menghadirkan keindahan
                            tradisi, detail busana, dan imajinasi visual.
                        </p>
                    </article>
                </div>

                <div class="col-md-4">
                    <article class="experience-card">
                        <div class="experience-number">02</div>
                        <div class="experience-icon">✧</div>
                        <h3>Seni Pertunjukan</h3>
                        <p>
                            Ekspresi seni yang menyatukan gerak, penampilan,
                            dan cerita dalam sebuah panggung perayaan.
                        </p>
                    </article>
                </div>

                <div class="col-md-4">
                    <article class="experience-card">
                        <div class="experience-number">03</div>
                        <div class="experience-icon">❋</div>
                        <h3>Budaya & Kreativitas</h3>
                        <p>
                            Inspirasi dari warisan Nusantara dan potensi lokal
                            yang diterjemahkan menjadi karya kreatif.
                        </p>
                    </article>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('pages.event-info') }}" class="text-link">
                    Lihat informasi acara <span>→</span>
                </a>
            </div>
        </div>
    </section>

    <!-- TICKETS -->
    <section class="ticket-section section-padding">
        <div class="container">
            <div class="ticket-heading text-center">
                <p class="eyebrow dark-eyebrow">YOUR INVITATION TO ASMARADANA</p>

                <h2 class="section-title">
                    Jadilah Bagian dari<br>
                    <em>Cerita Ini.</em>
                </h2>

                <p class="body-copy mt-3">
                    Pilih tiketmu dan bersiaplah menjadi bagian dari
                    Sparkling Nganjuk Carnival #5.
                </p>
            </div>

            <div class="row g-4 mt-3">

                <div class="col-md-4">
                    <article class="ticket-card">
                        <p class="ticket-number">01 / TICKET</p>
                        <h3>Premium</h3>
                        <p class="ticket-price">Rp50.000</p>
                        <p class="ticket-description">
                            Pilihan tiket untuk menikmati perayaan ASMARADANA.
                        </p>
                        <a href="{{ route('orders.create') }}" class="btn btn-ticket">
                            Pilih Tiket <span>↗</span>
                        </a>
                    </article>
                </div>

                <div class="col-md-4">
                    <article class="ticket-card ticket-card-featured">
                        <p class="ticket-number">02 / TICKET</p>
                        <h3>Regular</h3>
                        <p class="ticket-price">Rp30.000</p>
                        <p class="ticket-description">
                            Nikmati pengalaman Sparkling Nganjuk Carnival #5.
                        </p>
                        <a href="{{ route('orders.create') }}" class="btn btn-ticket">
                            Pilih Tiket <span>↗</span>
                        </a>
                    </article>
                </div>

                <div class="col-md-4">
                    <article class="ticket-card">
                        <p class="ticket-number">03 / TICKET</p>
                        <h3>Festival</h3>
                        <p class="ticket-price">Rp15.000</p>
                        <p class="ticket-description">
                            Jadilah bagian dari kemeriahan perayaan budaya dan seni.
                        </p>
                        <a href="{{ route('orders.create') }}" class="btn btn-ticket">
                            Pilih Tiket <span>↗</span>
                        </a>
                    </article>
                </div>

            </div>

        </div>
    </section>

    <!-- FINAL CTA -->
    <section class="final-cta-section">
        <div class="container">
            <p class="eyebrow">LET THE STORY BEGIN</p>

            <h2>
                Cinta, Budaya,<br>
                dan <em>Segala Keindahannya.</em>
            </h2>

            <p>
                Temukan cerita di balik setiap karya dalam
                Sparkling Nganjuk Carnival #5.
            </p>

            <div class="hero-actions">
                <a href="{{ route('orders.create') }}" class="btn btn-gold">
                    Pesan Tiket <span>↗</span>
                </a>

                <a href="{{ route('pages.gallery') }}" class="btn btn-outline-gold">
                    Kunjungi Galeri
                </a>
            </div>
        </div>
    </section>

</main>

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
