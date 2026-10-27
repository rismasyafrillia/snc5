<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Maharajani | Sparkling Nganjuk Carnival #5</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/maharajani.css') }}">
</head>
<body>

{{-- NAVBAR --}}
<nav class="navbar navbar-expand-lg snc-navbar">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <span class="brand-mark">SNC</span>
            <span class="brand-name">SPARKLING NGANJUK<br>CARNIVAL #5</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#sncNavbar" aria-controls="sncNavbar"
            aria-expanded="false" aria-label="Buka navigasi">
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
                    <a href="{{ route('orders.create') }}" class="btn btn-snc">Pesan Tiket</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

{{-- HERO --}}
<header class="maharajani-hero">
    <div class="maharajani-pattern"></div>

    <div class="container position-relative">
        <div class="maharajani-copy">
            <a href="{{ route('defile.index') }}" class="maharajani-back">
                <span>←</span> Kembali ke Semua Defile
            </a>

            <span class="maharajani-eyebrow">DEFILE 02 · SPARKLING NGANJUK CARNIVAL #5</span>

            <h1>Maha<span>rajani</span></h1>

            <p class="maharajani-subtitle">The Royal Romance of Nusantara</p>

            <div class="maharajani-divider"></div>

            <p class="maharajani-description">
                Menghidupkan romansa kerajaan Nusantara melalui
                keagungan raja dan ratu, kisah cinta legendaris,
                serta pesona busana pengantin tradisional.
            </p>

            <a href="#makna-maharajani" class="btn btn-maharajani">
                Temukan Keagungannya <span>↓</span>
            </a>
        </div>

        <div class="maharajani-art" aria-hidden="true">
            <div class="royal-halo halo-one"></div>
            <div class="royal-halo halo-two"></div>
            <div class="royal-halo halo-three"></div>
            <div class="royal-crown">♛</div>
            <div class="royal-star royal-star-one">✦</div>
            <div class="royal-star royal-star-two">✧</div>
            <div class="royal-star royal-star-three">✦</div>
            <span class="royal-art-caption">ROYALTY · ROMANCE · LEGACY</span>
        </div>
    </div>

    <div class="maharajani-index">02 / 03</div>
</header>

{{-- INTRODUCTION --}}
<section class="maharajani-intro" id="makna-maharajani">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-5">
                <span class="section-kicker">THE ROYAL ROMANCE OF NUSANTARA</span>

                <h2>
                    Cinta dalam<br>
                    <em>Balutan Keagungan</em>
                </h2>

                <div class="maharajani-heading-line"></div>
            </div>

            <div class="col-lg-7">
                <p class="maharajani-lead">
                    Di balik mahkota dan singgasana, tersimpan kisah
                    tentang cinta, kesetiaan, dan kejayaan yang hidup
                    dalam cerita Nusantara.
                </p>

                <p class="maharajani-body">
                    Maharajani mengangkat romantisme kerajaan Nusantara
                    melalui figur raja dan ratu, pasangan legendaris,
                    karakter wayang, serta keanggunan busana pengantin
                    tradisional. Kemegahan masa lampau menjadi sumber
                    inspirasi bagi karya karnaval yang berkarakter kuat.
                </p>

                <p class="maharajani-body">
                    Mahkota, sayap, ornamen kerajaan, dan kekayaan kain
                    tradisional dapat diterjemahkan menjadi elemen visual
                    yang megah, elegan, dan romantis. Seluruhnya berpadu
                    dalam eksplorasi artistik yang menghormati kekayaan
                    budaya Nusantara.
                </p>
            </div>
        </div>
    </div>
</section>

{{-- ROYAL STATEMENT --}}
<section class="maharajani-statement">
    <div class="container">
        <div class="maharajani-statement-frame">
            <div class="statement-crown">♛</div>

            <span class="section-kicker">A LEGACY OF LOVE</span>

            <h2>
                Di balik kejayaan,<br>
                ada kisah cinta yang <em>abadi.</em>
            </h2>

            <p>
                Kemegahan bukan hanya tentang kekuasaan,
                tetapi juga tentang kisah, kesetiaan,
                dan warisan yang terus dikenang.
            </p>

            <div class="statement-decoration">✦ ─── ✦</div>
        </div>
    </div>
</section>

{{-- INSPIRATION --}}
<section class="maharajani-inspiration">
    <div class="container">
        <div class="text-center maharajani-section-heading">
            <span class="section-kicker">THE ROYAL INSPIRATION</span>
            <h2>Terinspirasi dari <em>Legenda</em></h2>
            <p>
                Eksplorasi karakter, kisah, dan elemen visual
                yang membangun dunia Maharajani.
            </p>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <article class="maharajani-card">
                    <span class="maharajani-card-number">01</span>
                    <div class="maharajani-card-symbol">♛</div>
                    <h3>Raja & Ratu</h3>
                    <p>
                        Karakter kerajaan dengan kesan berwibawa,
                        megah, dan anggun sebagai representasi
                        keagungan masa lampau.
                    </p>
                </article>
            </div>

            <div class="col-md-4">
                <article class="maharajani-card">
                    <span class="maharajani-card-number">02</span>
                    <div class="maharajani-card-symbol">♡</div>
                    <h3>Romansa Legenda</h3>
                    <p>
                        Kisah pasangan legendaris Nusantara dan
                        karakter wayang sebagai inspirasi cerita
                        cinta dalam balutan seni karnaval.
                    </p>
                </article>
            </div>

            <div class="col-md-4">
                <article class="maharajani-card">
                    <span class="maharajani-card-number">03</span>
                    <div class="maharajani-card-symbol">❖</div>
                    <h3>Busana & Ornamen</h3>
                    <p>
                        Mahkota, sayap, ornamen kerajaan, dan
                        kain tradisional yang memperkuat karakter
                        visual nan elegan dan romantis.
                    </p>
                </article>
            </div>
        </div>
    </div>
</section>

{{-- CLOSING --}}
<section class="maharajani-closing">
    <div class="container">
        <span class="section-kicker">THE SYMPHONY CONTINUES</span>

        <h2>
            Keagungan yang Dikenang,<br>
            <em>Romansa yang Diceritakan.</em>
        </h2>

        <p>
            Maharajani merupakan bagian dari ASMARADANA —
            The Symphony of Love, sebuah perayaan cinta,
            budaya, dan kreativitas Nusantara.
        </p>

        <div class="maharajani-navigation">
            <a href="{{ route('defile.puspawara') }}" class="maharajani-nav-link">
                <span>←</span>
                <span>
                    <small>DEFILE SEBELUMNYA</small>
                    <strong>Puspawara</strong>
                </span>
            </a>

            <a href="{{ route('defile.asmara-fantasia') }}" class="maharajani-nav-link next">
                <span>
                    <small>DEFILE SELANJUTNYA</small>
                    <strong>Asmara Fantasia</strong>
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