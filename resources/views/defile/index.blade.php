<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Jelajahi Defile | Sparkling Nganjuk Carnival #5</title>
    <meta name="description" content="Jelajahi Puspawara, Maharajani, dan Asmara Fantasia dalam Sparkling Nganjuk Carnival #5 — ASMARADANA.">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/defile.css') }}">
</head>
<body>

<!-- NAVIGATION -->
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
                    <a class="nav-link active" href="{{ route('defile.index') }}">Defile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('pages.gallery') }}">Galeri</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('pages.event-info') }}">Info Acara</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('orders.create') }}" class="btn btn-gold nav-order-btn">
                        Pesan Tiket ↗
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main>

    <!-- PAGE HERO -->
    <section class="defile-hero">
        <div class="defile-hero-pattern"></div>

        <div class="container defile-hero-content">
            <p class="defile-breadcrumb">
                <a href="{{ route('home') }}">BERANDA</a>
                <span>/</span>
                DEFILE
            </p>

            <p class="eyebrow">THREE WORLDS · ONE SYMPHONY</p>

            <h1>
                Tiga Cerita,<br>
                <em>Satu Simfoni Cinta.</em>
            </h1>

            <p class="defile-hero-description">
                Dari sakralnya tradisi pernikahan Nusantara, megahnya
                kisah kerajaan, hingga kebebasan imajinasi tanpa batas.
                Temukan tiga dunia yang membentuk ASMARADANA.
            </p>

            <a href="#daftar-defile" class="defile-scroll-link">
                JELAJAHI TIGA DEFILE <span>↓</span>
            </a>
        </div>

        <div class="defile-hero-index">
            <span>01 — 03</span>
            <span>ASMARADANA 2026</span>
        </div>
    </section>

    <!-- INTRO -->
    <section class="defile-introduction">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-lg-4">
                    <p class="eyebrow dark-eyebrow">THE CONCEPT</p>
                    <h2 class="defile-intro-title">
                        Cinta dalam<br>
                        Beragam <em>Wujud.</em>
                    </h2>
                </div>

                <div class="col-lg-8">
                    <p class="defile-intro-copy">
                        ASMARADANA mengajak kita melihat cinta melalui
                        perspektif yang berbeda. Tradisi menyimpan makna,
                        legenda menghadirkan romansa, dan imajinasi membuka
                        kemungkinan yang tak terbatas.
                    </p>

                    <p class="defile-intro-note">
                        Setiap defile memiliki karakter, inspirasi, dan
                        bahasa visualnya sendiri dalam sebuah perayaan seni
                        dan fashion carnival.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- DEFILE LIST -->
    <section class="defile-list-section" id="daftar-defile">
        <div class="container">

            <div class="defile-list-heading">
                <div>
                    <p class="eyebrow dark-eyebrow">THE THREE CHAPTERS</p>
                    <h2>Jelajahi Setiap <em>Bab.</em></h2>
                </div>
                <p>
                    Tiga interpretasi cinta yang hadir melalui tradisi,
                    keagungan, dan keajaiban imajinasi.
                </p>
            </div>

            <!-- PUSPAWARA -->
            <article class="defile-feature defile-feature-one">
                <div class="defile-feature-art">
                    <div class="feature-art-frame">
                        <span class="feature-art-number">01</span>
                        <span class="feature-art-symbol">❋</span>
                        <span class="feature-art-caption">THE SACRED WEDDING HERITAGE</span>
                    </div>
                </div>

                <div class="defile-feature-content">
                    <p class="feature-index">CHAPTER ONE · TRADITION</p>
                    <h3>Puspawara</h3>

                    <p class="feature-subtitle">
                        The Sacred Wedding Heritage
                    </p>

                    <div class="feature-gold-line"></div>

                    <p class="feature-focus">
                        Pesona Tradisi, Simbol, dan Kemegahan Pernikahan Nusantara.
                    </p>

                    <p class="feature-description">
                        Menghadirkan keagungan dan kesakralan tradisi pernikahan
                        Indonesia melalui ubo rampe, ragam hias, busana, serta
                        ritual yang menyimpan filosofi mendalam. Tradisi
                        diterjemahkan menjadi karya fashion carnival yang
                        spektakuler tanpa kehilangan identitas dan maknanya.
                    </p>

                    <a href="{{ route('defile.puspawara') }}" class="defile-detail-link">
                        JELAJAHI PUSPAWARA <span>↗</span>
                    </a>
                </div>
            </article>

            <!-- MAHARAJANI -->
            <article class="defile-feature defile-feature-reverse defile-feature-two">
                <div class="defile-feature-art">
                    <div class="feature-art-frame">
                        <span class="feature-art-number">02</span>
                        <span class="feature-art-symbol">♛</span>
                        <span class="feature-art-caption">THE ROYAL ROMANCE OF NUSANTARA</span>
                    </div>
                </div>

                <div class="defile-feature-content">
                    <p class="feature-index">CHAPTER TWO · ROYALTY</p>
                    <h3>Maharajani</h3>

                    <p class="feature-subtitle">
                        The Royal Romance of Nusantara
                    </p>

                    <div class="feature-gold-line"></div>

                    <p class="feature-focus">
                        Keagungan Raja-Ratu, Romantisme Legenda, Pesona Pengantin Nusantara.
                    </p>

                    <p class="feature-description">
                        Cinta bertemu kemegahan dalam kisah raja dan ratu,
                        pasangan legendaris Nusantara, serta karakter pewayangan.
                        Mahkota, ornamen kerajaan, kain tradisional, dan busana
                        pengantin menjadi inspirasi untuk menghadirkan sosok
                        yang megah, anggun, dan romantis.
                    </p>

                    <a href="{{ route('defile.maharajani') }}" class="defile-detail-link">
                        JELAJAHI MAHARAJANI <span>↗</span>
                    </a>
                </div>
            </article>

            <!-- ASMARA FANTASIA -->
            <article class="defile-feature defile-feature-three">
                <div class="defile-feature-art">
                    <div class="feature-art-frame">
                        <span class="feature-art-number">03</span>
                        <span class="feature-art-symbol">✧</span>
                        <span class="feature-art-caption">THE ENCHANTED UNIVERSE OF LOVE</span>
                    </div>
                </div>

                <div class="defile-feature-content">
                    <p class="feature-index">CHAPTER THREE · IMAGINATION</p>
                    <h3>Asmara Fantasia</h3>

                    <p class="feature-subtitle">
                        The Enchanted Universe of Love
                    </p>

                    <div class="feature-gold-line"></div>

                    <p class="feature-focus">
                        Ketika Cinta Menjadi Keajaiban, Keindahan, dan Kemakmuran.
                    </p>

                    <p class="feature-description">
                        Sebuah ruang bagi imajinasi untuk melampaui batas tradisi
                        dan kerajaan. Alam, flora, fauna, mitologi, hingga objek
                        penuh simbol dapat diolah menjadi inspirasi kostum
                        carnival. Potensi lokal Nganjuk pun terbuka untuk
                        diterjemahkan menjadi karya yang berani dan unik.
                    </p>

                    <a href="{{ route('defile.asmara-fantasia') }}" class="defile-detail-link">
                        JELAJAHI ASMARA FANTASIA <span>↗</span>
                    </a>
                </div>
            </article>

        </div>
    </section>

    <!-- CLOSING -->
    <section class="defile-closing">
        <div class="container text-center">
            <p class="eyebrow">ONE CELEBRATION · ENDLESS STORIES</p>

            <h2>
                Setiap Karya Punya Cerita.<br>
                <em>Temukan Ceritamu.</em>
            </h2>

            <p>
                Jadilah bagian dari perayaan seni, budaya, dan cinta
                dalam Sparkling Nganjuk Carnival #5.
            </p>

            <a href="{{ route('orders.create') }}" class="btn btn-gold">
                Pesan Tiket <span>↗</span>
            </a>
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
