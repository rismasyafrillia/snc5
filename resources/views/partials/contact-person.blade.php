<p class="contact-person">
    Ada kendala pembayaran atau tiket belum muncul? Hubungi Contact Person:
    <a
        href="https://wa.me/{{ config('services.contact_person.whatsapp') }}"
        target="_blank"
        rel="noopener noreferrer"
    >{{ preg_replace('/^62/', '0', config('services.contact_person.whatsapp')) }}</a>
</p>
