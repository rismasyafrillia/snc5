<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Asmara Fantasia | Sparkling Nganjuk Carnival #5</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/asmara-fantasia.css') }}">
</head>
<body>

{{-- NAVBAR --}}
<nav class="navbar navbar-expand-lg snc-navbar">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <span class="brand-mark">SNC</span>
            <span class="brand-name">SPARKLING NGANJUK<br>CARNIVAL #5</span>
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
                    <a href="{{ route('orders.create') }}" class="btn btn-snc">Pesan Tiket</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

{{-- HERO --}}
<header class="fantasia-hero">
    <div class="fantasia-background-pattern"></div>

    <div class="container position-relative">
        <div class="fantasia-copy">
            <a href="{{ route('defile.index') }}" class="fantasia-back">
                <span>←</span> Kembali ke Semua Defile
            </a>

            <span class="fantasia-eyebrow">DEFILE 03 · SPARKLING NGANJUK CARNIVAL #5</span>

            <h1>Asmara<br><em>Fantasia</em></h1>

            <p class="fantasia-subtitle">
                The Enchanted Universe of Love
            </p>

            <div class="fantasia-divider"></div>

            <p class="fantasia-description">
                Ketika cinta menjelma menjadi keajaiban, keindahan,
                dan kemakmuran. Sebuah ruang bagi imajinasi untuk
                melampaui batas tradisi dan menciptakan dunia yang memesona.
            </p>

            <a href="#makna-fantasia" class="btn btn-fantasia">
                Masuki Dunia Imajinasi <span>↓</span>
            </a>
        </div>

        <div class="fantasia-art" aria-hidden="true">
            <div class="fantasia-orbit orbit-one"></div>
            <div class="fantasia-orbit orbit-two"></div>
            <div class="fantasia-orbit orbit-three"></div>

            <div class="fantasia-moon">☾</div>
            <div class="fantasia-flower flower-one">✿</div>
            <div class="fantasia-flower flower-two">✺</div>

            <span class="fantasia-star star-one">✦</span>
            <span class="fantasia-star star-two">✧</span>
            <span class="fantasia-star star-three">✦</span>
            <span class="fantasia-star star-four">✧</span>

            <span class="fantasia-art-caption">IMAGINATION · WONDER · LOVE</span>
        </div>
    </div>

    <div class="fantasia-index">03 / 03</div>
</header>

{{-- INTRODUCTION --}}
<section class="fantasia-intro" id="makna-fantasia">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-5">
                <span class="section-kicker">THE ENCHANTED UNIVERSE OF LOVE</span>

                <h2>
                    Saat Imajinasi<br>
                    Menjadi <em>Keajaiban</em>
                </h2>

                <div class="fantasia-heading-line"></div>
            </div>

            <div class="col-lg-7">
                <p class="fantasia-lead">
                    Cinta tidak selalu hadir dalam bentuk yang dikenal.
                    Terkadang, ia tumbuh menjadi keajaiban yang melampaui
                    batas kenyataan.
                </p>

                <p class="fantasia-body">
                    Asmara Fantasia membuka ruang eksplorasi bagi gagasan
                    kreatif yang melampaui inspirasi tradisi dan kemegahan
                    kerajaan. Cinta diterjemahkan melalui keajaiban alam,
                    keindahan flora dan fauna, dunia mitologi, hingga
                    benda-benda simbolis yang menyimpan makna.
                </p>

                <p class="fantasia-body">
                    Melalui kebebasan berekspresi, peserta dapat
                    mengembangkan karakter dan kostum karnaval yang unik,
                    berani, serta penuh imajinasi. Potensi lokal Nganjuk
                    juga dapat menjadi sumber inspirasi untuk menciptakan
                    karya yang memiliki karakter dan identitas tersendiri.
                </p>
            </div>
        </div>
    </div>
</section>

{{-- STATEMENT --}}
<section class="fantasia-statement">
    <div class="container">
        <div class="fantasia-statement-inner">
            <div class="fantasia-statement-symbol">✧</div>

            <span class="section-kicker">BEYOND THE ORDINARY</span>

            <h2>
                Ketika cinta menjadi keajaiban,<br>
                <em>imajinasi tidak mengenal batas.</em>
            </h2>

            <p>
                Sebuah dunia tempat alam, mitologi, simbol,
                dan kreativitas berpadu menjadi perayaan
                keindahan yang tak terduga.
            </p>

            <div class="fantasia-statement-stars">✦ &nbsp; ✧ &nbsp; ✦</div>
        </div>
    </div>
</section>

{{-- INSPIRATION --}}
<section class="fantasia-inspiration">
    <div class="container">
        <div class="text-center fantasia-section-heading">
            <span class="section-kicker">A WORLD OF POSSIBILITIES</span>

            <h2>Inspirasi Tanpa <em>Batas</em></h2>

            <p>
                Beragam kemungkinan artistik yang dapat dikembangkan
                menjadi karakter dan karya kostum karnaval.
            </p>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <article class="fantasia-card">
                    <div class="fantasia-card-number">01</div>
                    <div class="fantasia-card-symbol">❋</div>

                    <h3>Alam & Kehidupan</h3>

                    <p>
                        Keindahan flora, fauna, dan fenomena alam
                        sebagai inspirasi bentuk, warna, tekstur,
                        serta karakter kostum.
                    </p>

                    <span class="fantasia-card-footer">NATURE IN MOTION</span>
                </article>
            </div>

            <div class="col-md-4">
                <article class="fantasia-card">
                    <div class="fantasia-card-number">02</div>
                    <div class="fantasia-card-symbol">☾</div>

                    <h3>Mitologi & Fantasi</h3>

                    <p>
                        Dunia mitologi dan makhluk imajinatif
                        yang diterjemahkan menjadi karakter
                        penuh keajaiban dan daya tarik visual.
                    </p>

                    <span class="fantasia-card-footer">MYTHS REIMAGINED</span>
                </article>
            </div>

            <div class="col-md-4">
                <article class="fantasia-card">
                    <div class="fantasia-card-number">03</div>
                    <div class="fantasia-card-symbol">✧</div>

                    <h3>Simbol & Potensi Lokal</h3>

                    <p>
                        Benda simbolis, gagasan personal, serta
                        kekayaan lokal Nganjuk sebagai sumber
                        eksplorasi karya yang autentik.
                    </p>

                    <span class="fantasia-card-footer">LOCAL INSPIRATION</span>
                </article>
            </div>
        </div>
    </div>
</section>

{{-- CREATIVE FREEDOM --}}
<section class="fantasia-freedom">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <span class="section-kicker">YOUR IMAGINATION, YOUR STORY</span>

                <h2>
                    Ciptakan Dunia<br>
                    <em>Versimu Sendiri.</em>
                </h2>

                <p>
                    Asmara Fantasia memberi ruang bagi keberanian untuk
                    bereksperimen. Setiap ide dapat berkembang menjadi
                    karakter visual yang berbeda, dengan interpretasi
                    cinta dan keindahan yang unik.
                </p>

                <p>
                    Tidak hanya menampilkan kemegahan, defile ini juga
                    merayakan proses kreatif, eksplorasi gagasan,
                    dan potensi lokal sebagai bagian dari identitas
                    karya karnaval.
                </p>
            </div>

            <div class="col-lg-6">
                <div class="fantasia-quote">
                    <span class="quote-mark">“</span>

                    <blockquote>
                        Sebab keindahan terbesar terkadang lahir
                        dari sesuatu yang sebelumnya hanya
                        berani kita bayangkan.
                    </blockquote>

                    <span class="quote-line"></span>
                    <span class="quote-caption">ASMARA FANTASIA · SNC #5</span>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- CLOSING --}}
<section class="fantasia-closing">
    <div class="container">
        <span class="section-kicker">THE FINAL CHAPTER OF THE DEFILE JOURNEY</span>

        <h2>
            Tiga Kisah, Satu Simfoni.<br>
            <em>Cinta dalam Segala Bentuknya.</em>
        </h2>

        <p>
            Puspawara, Maharajani, dan Asmara Fantasia berpadu
            dalam ASMARADANA — The Symphony of Love.
        </p>

        <div class="fantasia-navigation">
            <a href="{{ route('defile.maharajani') }}" class="fantasia-nav-link">
                <span>←</span>
                <span>
                    <small>DEFILE SEBELUMNYA</small>
                    <strong>Maharajani</strong>
                </span>
            </a>

            <a href="{{ route('defile.index') }}" class="fantasia-nav-link next">
                <span>
                    <small>KEMBALI KE</small>
                    <strong>Semua Defile</strong>
                </span>
                <span>→</span>
            </a>
        </div>

        <a href="{{ route('orders.create') }}" class="btn btn-fantasia closing-ticket">
            Jadi Bagian dari Perayaan <span>↗</span>
        </a>
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