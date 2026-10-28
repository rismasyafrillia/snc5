
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Check-in Tiket SNC #5</title>

    <script src="https://unpkg.com/html5-qrcode"></script>
</head>
<body style="font-family: Arial, sans-serif; max-width: 600px; margin: 30px auto; padding: 20px; color: #222;">

    <h1>Check-in Tiket SNC #5</h1>
    <p>Arahkan kamera ke QR Code pada e-tiket peserta.</p>

    <div id="reader" style="width: 100%; max-width: 450px; margin: 20px auto;"></div>

    <p id="scanner-status" role="status" aria-live="polite">
        Tekan tombol di bawah untuk mengaktifkan kamera.
    </p>

    <button
        type="button"
        id="start-scan"
        style="padding: 12px 20px; cursor: pointer;"
    >
        Mulai Scan QR
    </button>

    <form id="checkin-form" method="POST" action="{{ route('check-in.verify') }}">
        @csrf
        <input type="hidden" name="qr_token" id="qr_token">
    </form>

    @if ($errors->any())
        <p style="color: red;">{{ $errors->first() }}</p>
    @endif

    @if (session('checkin_result'))
        @php($result = session('checkin_result'))
        @php($ticket = $result['ticket'] ?? null)

        @if ($result['result'] === 'success')
            <div style="padding: 15px; background: #e8f7e8;">
                <h2 style="color: green;">CHECK-IN BERHASIL</h2>
                <p>Kode tiket: {{ data_get($ticket, 'ticket_code', '-') }}</p>
                <p>Waktu: {{ data_get($ticket, 'checked_in_at', '-') }}</p>
            </div>
        @elseif ($result['result'] === 'used')
            <div style="padding: 15px; background: #fff0f0;">
                <h2 style="color: red;">TIKET SUDAH DIGUNAKAN</h2>
                <p>Kode tiket: {{ data_get($ticket, 'ticket_code', '-') }}</p>
            </div>
        @elseif ($result['result'] === 'unpaid')
            <h2 style="color: red;">PEMBAYARAN BELUM VALID</h2>
        @else
            <h2 style="color: red;">QR CODE TIDAK VALID</h2>
        @endif
    @endif

    <script>
        const statusText = document.getElementById('scanner-status');
        const startButton = document.getElementById('start-scan');
        const form = document.getElementById('checkin-form');

        let scanner = null;
        let submitting = false;

        startButton.addEventListener('click', async function () {
            startButton.disabled = true;
            statusText.textContent = 'Mengaktifkan kamera...';

            try {
                if (!window.Html5Qrcode) {
                    throw new Error('Library pemindai QR gagal dimuat. Periksa koneksi internet.');
                }

                scanner = new Html5Qrcode('reader');

                await scanner.start(
                    { facingMode: 'environment' },
                    {
                        fps: 10,
                        qrbox: { width: 250, height: 250 }
                    },
                    async function (decodedText) {
                        if (submitting) return;

                        submitting = true;
                        statusText.textContent = 'QR terbaca. Memeriksa tiket...';

                        document.getElementById('qr_token').value = decodedText;

                        try {
                            await scanner.stop();
                        } catch (error) {}

                        form.submit();
                    },
                    function () {}
                );

                statusText.textContent = 'Kamera aktif. Arahkan ke QR Code tiket.';
            } catch (error) {
                statusText.textContent = 'Kamera gagal dibuka: ' + error.message;
                startButton.disabled = false;
            }
        });
    </script>

</body>
</html>
