<footer class="snc-footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-identity">
                <a class="footer-brand" href="{{ route('home') }}">
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

        </div>

        <div class="footer-bottom">
            <span>© {{ date('Y') }} Sparkling Nganjuk Carnival #5</span>
            <span>ASMARADANA — The Symphony of Love</span>
        </div>

        @include('partials.contact-person')
    </div>
</footer>
