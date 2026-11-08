
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>E-Tiket Sparkling Nganjuk Carnival #5</title>
</head>
<body style="font-family: Arial, sans-serif; color: #222; line-height: 1.6;">
    <div style="margin-bottom: 24px; text-align: center;">
        <p style="margin: 0 0 8px; color: #666; font-size: 12px;">Ticketing by</p>
        <p style="margin: 0; color: #46131f; font-family: Arial, sans-serif; font-size: 18px; font-weight: 700; letter-spacing: 3px;">SWATANTRA</p>
        <p style="margin: 4px 0 0; color: #9b7742; font-size: 10px; font-weight: 700; letter-spacing: 2px;">CREATIVE EVENT</p>
    </div>

    <h2>Pembayaran Berhasil!</h2>

    <p>Halo {{ $order->buyer_name }},</p>

    <p>
        Terima kasih telah melakukan pemesanan tiket
        <strong>Sparkling Nganjuk Carnival #5</strong>.
        Pembayaran kamu telah dikonfirmasi.
    </p>

    <p>
        <strong>Kode Pesanan:</strong>
        {{ $order->order_code }}
    </p>

    <p style="margin: 24px 0; padding: 16px; border-left: 3px solid #c9a76a; background: #fffaf2;">
        <strong>Penukaran tiket</strong><br>
        Sabtu, 21 November 2026<br>
        Stadion Anjuk Ladang<br>
        Pukul 12.00–19.00 WIB
    </p>

    <p>
        Simpan email ini dan tunjukkan QR Code tiket saat memasuki acara.
        Setiap QR Code hanya berlaku untuk satu tiket.
    </p>

    @foreach ($ticketImages as $ticket)
        <div style="margin: 24px 0; padding: 16px; border: 1px solid #ddd;">
            <h3>Tiket {{ $loop->iteration }}</h3>

            <p>
                <strong>Kode Tiket:</strong>
                {{ $ticket['ticket_code'] }}
            </p>

            <img
                src="{{ $message->embedData($ticket['qr_png'], $ticket['qr_cid'], 'image/png') }}"
                alt="QR Tiket {{ $ticket['ticket_code'] }}"
                width="250"
                height="250"
                style="display:block; width:250px; height:250px;"
            />

            <p>
                Tunjukkan QR Code ini kepada petugas saat check-in.
            </p>
        </div>
    @endforeach

    <p>Terima kasih dan sampai bertemu di acara!</p>

    <p>
        Salam,<br>
        <strong>Panitia Sparkling Nganjuk Carnival #5</strong>
    </p>
</body>
</html>
