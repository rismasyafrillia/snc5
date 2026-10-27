<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Puspawara | Sparkling Nganjuk Carnival #5</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/puspawara.css') }}">
</head>
<body>

{{-- NAVBAR --}}
<nav class="navbar navbar-expand-lg snc-navbar">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <span class="brand-mark">SNC</span>
            <span class="brand-name">
                SPARKLING NGANJUK<br>CARNIVAL #5
            </span>
        </a>

        <button class="navbar-toggler" type="button"
            data-bs-toggle="collapse" data-bs-target="#sncNavbar"
            aria-controls="sncNavbar" aria-expanded="false"
            aria-label="Buka navigasi">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="sncNavbar">
            <ul class="navbar-nav ms-auto align-items-lg-center">
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
                <li class="nav-item ms-lg-3">
                    <a href="{{ route('orders.create') }}" class="btn btn-snc">
                        Pesan Tiket
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

{{-- HERO --}}
<header class="puspawara-hero">
    <div class="puspawara-hero-pattern"></div>

    <div class="container position-relative">
        <div class="puspawara-hero-content">
            <a href="{{ route('defile.index') }}" class="puspawara-back">
                <span>←</span> Kembali ke Semua Defile
            </a>

            <span class="puspawara-eyebrow">DEFILE 01 · SPARKLING NGANJUK CARNIVAL #5</span>

            <h1>Puspa<span>wara</span></h1>

            <p class="puspawara-subtitle">
                The Sacred Wedding Heritage
            </p>

            <div class="puspawara-line"></div>

            <p class="puspawara-hero-description">
                Menelusuri pesona tradisi, simbol, dan kemegahan
                pernikahan Nusantara melalui karya seni karnaval
                yang sarat makna dan filosofi.
            </p>

            <a href="#makna-puspawara" class="btn btn-puspawara">
                Jelajahi Kisah <span>↓</span>
            </a>
        </div>

        <div class="puspawara-hero-art" aria-hidden="true">
            <div class="puspawara-art-ring ring-one"></div>
            <div class="puspawara-art-ring ring-two"></div>
            <div class="puspawara-art-ring ring-three"></div>
            <div class="puspawara-art-flower">✺</div>
            <div class="puspawara-art-spark spark-one">✦</div>
            <div class="puspawara-art-spark spark-two">✧</div>
            <div class="puspawara-art-spark spark-three">✦</div>
            <span class="puspawara-art-caption">TRADITION · SYMBOL · HERITAGE</span>
        </div>
    </div>

    <div class="puspawara-hero-bottom">PUSPawara · 01 / 03</div>
</header>

{{-- INTRODUCTION --}}
<section class="puspawara-intro" id="makna-puspawara">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-5">
                <span class="section-kicker">THE MEANING BEHIND THE ART</span>

                <h2>
                    Keindahan Tradisi,<br>
                    <em>Warisan Abadi</em>
                </h2>

                <div class="puspawara-heading-line"></div>
            </div>

            <div class="col-lg-7">
                <p class="puspawara-lead">
                    Pernikahan dalam budaya Nusantara bukan sekadar
                    penyatuan dua insan, tetapi juga perayaan nilai,
                    doa, simbol, dan warisan yang diteruskan lintas generasi.
                </p>

                <p class="puspawara-body">
                    Puspawara mengangkat kemegahan dan kesakralan tradisi
                    pernikahan Indonesia sebagai inspirasi seni karnaval.
                    Berbagai perlengkapan pernikahan atau <em>ubo rampe</em>,
                    ragam ornamen, serta prosesi adat diterjemahkan menjadi
                    gagasan visual yang kaya karakter.
                </p>

                <p class="puspawara-body">
                    Melalui pendekatan artistik, tradisi dihadirkan dalam
                    bentuk karya karnaval yang spektakuler tanpa melepaskan
                    identitas, makna, dan filosofi yang melekat di dalamnya.
                </p>
            </div>
        </div>
    </div>
</section>

{{-- VISUAL STATEMENT --}}
<section class="puspawara-statement">
    <div class="container">
        <div class="puspawara-statement-inner">
            <span class="statement-ornament">✺</span>

            <span class="section-kicker">THE SACRED WEDDING HERITAGE</span>

            <h2>
                Bukan sekadar kemegahan,<br>
                melainkan <em>makna yang diwariskan.</em>
            </h2>

            <p>
                Setiap ornamen menyimpan cerita. Setiap simbol membawa doa.
                Setiap tradisi menjaga warisan budaya Nusantara.
            </p>

            <span class="statement-bottom">✦</span>
        </div>
    </div>
</section>

{{-- INSPIRATION --}}
<section class="puspawara-inspiration">
    <div class="container">
        <div class="text-center puspawara-section-heading">
            <span class="section-kicker">THE INSPIRATION</span>
            <h2>Merangkai Tradisi Menjadi <em>Karya</em></h2>
            <p>
                Tiga unsur yang menjadi sumber inspirasi dalam eksplorasi
                artistik Defile Puspawara.
            </p>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <article class="puspawara-inspiration-card">
                    <div class="inspiration-number">01</div>
                    <div class="inspiration-symbol">❋</div>
                    <h3>Ubo Rampe</h3>
                    <p>
                        Perlengkapan dalam tradisi pernikahan sebagai sumber
                        inspirasi bentuk, detail, dan simbol dalam karya
                        kostum karnaval.
                    </p>
                </article>
            </div>

            <div class="col-md-4">
                <article class="puspawara-inspiration-card">
                    <div class="inspiration-number">02</div>
                    <div class="inspiration-symbol">✧</div>
                    <h3>Ornamen & Busana</h3>
                    <p>
                        Kekayaan detail busana adat, motif, dan ornamen
                        pernikahan Nusantara yang menghadirkan karakter
                        visual serta keanggunan.
                    </p>
                </article>
            </div>

            <div class="col-md-4">
                <article class="puspawara-inspiration-card">
                    <div class="inspiration-number">03</div>
                    <div class="inspiration-symbol">❈</div>
                    <h3>Ritual & Filosofi</h3>
                    <p>
                        Nilai dan makna dalam prosesi pernikahan adat yang
                        menjadi pengingat akan pentingnya menjaga identitas
                        serta warisan budaya.
                    </p>
                </article>
            </div>
        </div>
    </div>
</section>

{{-- CLOSING --}}
<section class="puspawara-closing">
    <div class="container">
        <span class="section-kicker">A JOURNEY THROUGH NUSANTARA</span>

        <h2>
            Merayakan Warisan,<br>
            Menjaga <em>Keindahan Tradisi.</em>
        </h2>

        <p>
            Puspawara menjadi salah satu kisah dalam ASMARADANA —
            The Symphony of Love, sebuah perayaan cinta, budaya,
            dan kehidupan baru.
        </p>

        <div class="puspawara-navigation">
            <a href="{{ route('defile.index') }}" class="puspawara-nav-link">
                <span>←</span>
                <span>
                    <small>KEMBALI KE</small>
                    <strong>Semua Defile</strong>
                </span>
            </a>

            <a href="{{ route('defile.maharajani') }}" class="puspawara-nav-link next">
                <span>
                    <small>DEFIlE SELANJUTNYA</small>
                    <strong>Maharajani</strong>
                </span>
                <span>→</span>
            </a>
        </div>
    </div>
</section>

{{-- FOOTER --}}
<footer class="snc-footer">
    <div class="container">
        <div class="footer-content">
            <div>
                <a class="navbar-brand footer-brand" href="{{ route('home') }}">
                    <span class="brand-mark">SNC</span>
                    <span class="brand-name">
                        SPARKLING NGANJUK<br>CARNIVAL #5
                    </span>
                </a>

                <p>
                    Merayakan Cinta, Menyatukan Budaya,<br>
                    Menyambut Kehidupan Baru.
                </p>
            </div>

            <div class="footer-links">
                <a href="{{ route('pages.about') }}">Tentang</a>
                <a href="{{ route('defile.index') }}">Defile</a>
                <a href="{{ route('pages.gallery') }}">Galeri</a>
                <a href="{{ route('pages.event-info') }}">Info Acara</a>
            </div>
        </div>

        <div class="footer-bottom">
            <span>© {{ date('Y') }} Sparkling Nganjuk Carnival #5</span>
            <span>ASMARADANA — The Symphony of Love</span>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>