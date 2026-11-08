
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Admin - SNC #5</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: #f1f5f9;
            color: #172033;
            font-family: Arial, sans-serif;
        }

        header {
            background: #0b1730;
            color: white;
            padding: 20px 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
        }

        .dashboard-clock {
            margin-left: auto;
            color: #e2e8f0;
            font-size: 13px;
            font-variant-numeric: tabular-nums;
            text-align: right;
            white-space: nowrap;
        }

        header strong {
            font-size: 20px;
        }

        main {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .page-heading {
            margin-bottom: 24px;
        }

        .page-heading h1 {
            margin-bottom: 8px;
        }

        .panel {
            background: white;
            padding: 24px;
            border-radius: 14px;
            margin-bottom: 20px;
            box-shadow: 0 4px 20px rgba(15, 23, 42, 0.04);
        }

        .panel h2 {
            margin-top: 0;
        }

        .panel-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .admin-menu {
            display: flex;
            gap: 4px;
            margin-bottom: 20px;
            overflow-x: auto;
            border-bottom: 1px solid #cbd5e1;
        }

        .admin-menu button {
            flex: 0 0 auto;
            padding: 12px 18px;
            border: 0;
            border-bottom: 3px solid transparent;
            border-radius: 0;
            background: transparent;
            color: #475569;
        }

        .admin-menu button:hover {
            background: #e2e8f0;
            color: #172033;
        }

        .admin-menu button[aria-selected="true"] {
            border-bottom-color: #166534;
            background: white;
            color: #14532d;
        }

        .admin-menu button:focus-visible {
            outline: 2px solid #166534;
            outline-offset: -2px;
        }

        [data-admin-panel][hidden] {
            display: none;
        }

        .export-link {
            display: inline-block;
            padding: 10px 14px;
            border-radius: 7px;
            background: #166534;
            color: white;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            white-space: nowrap;
        }

        .export-link:hover {
            background: #14532d;
            color: white;
        }

        .export-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .muted {
            color: #64748b;
        }

        .success {
            padding: 13px 16px;
            color: #166534;
            background: #dcfce7;
            border-radius: 8px;
        }

        .error {
            padding: 13px 16px;
            color: #b91c1c;
            background: #fee2e2;
            border-radius: 8px;
        }

        .table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            min-width: 950px;
            border-collapse: collapse;
        }

        th,
        td {
            text-align: left;
            padding: 14px 12px;
            border-bottom: 1px solid #e2e8f0;
            vertical-align: middle;
        }

        th {
            background: #f8fafc;
            color: #475569;
            font-size: 13px;
            white-space: nowrap;
        }

        td {
            font-size: 14px;
        }

        tbody tr:hover {
            background: #fafcff;
        }

        .ticket-name {
            font-weight: 700;
            margin-bottom: 5px;
        }

        .ticket-code {
            font-size: 12px;
            color: #64748b;
        }

        input,
        select {
            width: 100%;
            min-width: 90px;
            padding: 10px;
            border: 1px solid #cbd5e1;
            border-radius: 7px;
            background: white;
            color: #172033;
            font-size: 14px;
        }

        input:focus,
        select:focus {
            outline: 2px solid #cbd5e1;
            border-color: #0b1730;
        }

        button {
            padding: 10px 14px;
            border: 0;
            border-radius: 7px;
            background: #0b1730;
            color: white;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            white-space: nowrap;
        }

        button:hover {
            background: #1e3358;
        }

        .confirm-payment {
            background: #166534;
        }

        .confirm-payment:hover {
            background: #14532d;
        }

        .logout {
            background: white;
            color: #0b1730;
        }

        .logout:hover {
            background: #e2e8f0;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .status-active {
            color: #166534;
            background: #dcfce7;
        }

        .status-inactive {
            color: #991b1b;
            background: #fee2e2;
        }

        .ticket-count {
            line-height: 1.8;
            white-space: nowrap;
        }

        .action-cell {
            min-width: 100px;
        }

        .empty-state {
            text-align: center;
            color: #64748b;
            padding: 28px;
        }

        .table-note {
            font-size: 13px;
            line-height: 1.6;
            margin-top: 16px;
        }

        @media (max-width: 600px) {
            header {
                padding: 18px 20px;
                flex-wrap: wrap;
            }

            header strong {
                font-size: 17px;
            }

            .dashboard-clock {
                order: 3;
                width: 100%;
                margin-left: 0;
                text-align: left;
                white-space: normal;
            }

            main {
                margin-top: 20px;
                padding: 0 14px;
            }

            .panel {
                padding: 16px;
            }

            .panel-heading {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>
</head>

<body>

<header>
    <div>
        <strong>Admin SNC #5</strong>
        <div style="color: #cbd5e1; margin-top: 5px; font-size: 13px;">
            Pengelolaan tiket
        </div>
    </div>

    <time class="dashboard-clock" id="dashboardClock" aria-label="Waktu saat ini di Jakarta"></time>

    <form method="POST" action="{{ route('admin.logout') }}">
        @csrf
        <button class="logout" type="submit">Keluar</button>
    </form>
</header>

<main>
    <div class="page-heading">
        <h1>Dashboard</h1>
        <p class="muted">{{ $event->name }}</p>
    </div>

    @if (session('success'))
        <div class="success" role="status">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="error" role="alert">
            <strong>Ada data yang perlu diperiksa:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <nav class="admin-menu" role="tablist" aria-label="Menu dashboard">
        <button
            id="tab-konfirmasi"
            type="button"
            role="tab"
            aria-controls="admin-panel-konfirmasi"
            aria-selected="true"
            tabindex="0"
            data-admin-tab="konfirmasi"
        >
            Konfirmasi
        </button>
        <button
            id="tab-checkin"
            type="button"
            role="tab"
            aria-controls="admin-panel-checkin"
            aria-selected="false"
            tabindex="-1"
            data-admin-tab="checkin"
        >
            Check-in
        </button>
        <button
            id="tab-tiket"
            type="button"
            role="tab"
            aria-controls="admin-panel-tiket"
            aria-selected="false"
            tabindex="-1"
            data-admin-tab="tiket"
        >
            Tiket
        </button>
    </nav>

    <div
        id="admin-panel-tiket"
        class="admin-tab-panel"
        role="tabpanel"
        aria-labelledby="tab-tiket"
        tabindex="0"
        data-admin-panel="tiket"
    >
    <section class="panel">
        <h2>Pengaturan Tiket</h2>

        <p class="muted">
            Kelola harga, kuota total, dan status penjualan setiap kategori tiket.
        </p>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Kategori</th>
                        <th>Harga (Rp)</th>
                        <th>Kuota Total</th>
                        <th>Stok Tiket</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($ticketTypes as $ticket)
                        <tr>
                            <td>
                                <div class="ticket-name">
                                    {{ $ticket->name }}
                                </div>
                                <div class="ticket-code">
                                    {{ $ticket->code }}
                                </div>
                            </td>

                            <td>
                                <form
                                    id="ticket-form-{{ $ticket->id }}"
                                    method="POST"
                                    action="{{ route('admin.tickets.update', $ticket) }}"
                                >
                                    @csrf
                                    @method('PUT')

                                    <input
                                        type="number"
                                        name="price"
                                        min="0"
                                        step="1000"
                                        value="{{ $ticket->price }}"
                                        required
                                        aria-label="Harga tiket {{ $ticket->name }}"
                                    >
                                </form>
                            </td>

                            <td>
                                <input
                                    type="number"
                                    name="quota"
                                    form="ticket-form-{{ $ticket->id }}"
                                    min="0"
                                    value="{{ $ticket->quota }}"
                                    required
                                    aria-label="Kuota tiket {{ $ticket->name }}"
                                >
                            </td>

                            <td>
                                <div class="ticket-count">
                                    <div>
                                        Reservasi:
                                        <strong>{{ $ticket->reserved_quantity }}</strong>
                                    </div>
                                    <div>
                                        Terjual:
                                        <strong>{{ $ticket->sold_quantity }}</strong>
                                    </div>
                                    <div>
                                        Tersisa:
                                        <strong>{{ max(0, $ticket->quota - $ticket->reserved_quantity - $ticket->sold_quantity) }}</strong>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div>
                                    @if ($ticket->status === 'active')
                                        <span class="status-badge status-active">
                                            Aktif
                                        </span>
                                    @else
                                        <span class="status-badge status-inactive">
                                            Nonaktif
                                        </span>
                                    @endif
                                </div>

                                <select
                                    name="status"
                                    form="ticket-form-{{ $ticket->id }}"
                                    aria-label="Status tiket {{ $ticket->name }}"
                                >
                                    <option
                                        value="active"
                                        @selected($ticket->status === 'active')
                                    >
                                        Aktif
                                    </option>

                                    <option
                                        value="inactive"
                                        @selected($ticket->status === 'inactive')
                                    >
                                        Nonaktif
                                    </option>
                                </select>
                            </td>

                            <td class="action-cell">
                                <button
                                    type="submit"
                                    form="ticket-form-{{ $ticket->id }}"
                                >
                                    Simpan
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty-state">
                                Belum ada kategori tiket untuk event ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <p class="table-note muted">
            Perubahan harga, kuota, dan status disimpan setelah tombol
            <strong>Simpan</strong> ditekan. Pastikan kuota tidak lebih kecil
            daripada jumlah tiket yang sudah dipesan atau terjual.
        </p>
    </section>
    </div>

    <div
        id="admin-panel-konfirmasi"
        class="admin-tab-panel"
        role="tabpanel"
        aria-labelledby="tab-konfirmasi"
        tabindex="0"
        data-admin-panel="konfirmasi"
    >
    <section class="panel">
        <h2>Konfirmasi Pembayaran QRIS</h2>
        <p class="muted">
            Cocokkan transaksi QRIS di rekening sebelum mengonfirmasi pesanan.
        </p>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Pesanan</th>
                        <th>Pemesan</th>
                        <th>Tiket</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pendingOrders as $order)
                        <tr>
                            <td>
                                <div class="ticket-name">{{ $order->order_code }}</div>
                                <div class="ticket-code">{{ $order->created_at->timezone('Asia/Jakarta')->format('d/m/Y H:i') }} WIB</div>
                            </td>
                            <td>
                                <div>{{ $order->buyer_name }}</div>
                                <div class="ticket-code">{{ $order->buyer_email }}</div>
                                <div class="ticket-code">WA: {{ $order->buyer_phone ?: 'Tidak dicantumkan' }}</div>
                            </td>
                            <td>
                                @foreach ($order->items as $item)
                                    <div>{{ $item->ticketType->name }} × {{ $item->quantity }}</div>
                                @endforeach
                            </td>
                            <td>Rp{{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            <td class="action-cell">
                                <form
                                    method="POST"
                                    action="{{ route('admin.orders.confirm-payment', $order) }}"
                                    onsubmit="return confirm('Pastikan dana QRIS sudah diterima sebelum mengonfirmasi pembayaran ini.')"
                                >
                                    @csrf
                                    <button class="confirm-payment" type="submit">
                                        Konfirmasi
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="empty-state">
                                Tidak ada pembayaran QRIS yang menunggu konfirmasi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
    </div>

    <div
        id="admin-panel-checkin"
        class="admin-tab-panel"
        role="tabpanel"
        aria-labelledby="tab-checkin"
        tabindex="0"
        data-admin-panel="checkin"
    >
    <section class="panel">
        <div class="panel-heading">
            <h2>Pembayaran Terkonfirmasi</h2>
        </div>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Pesanan</th>
                        <th>Pemesan</th>
                        <th>Tiket</th>
                        <th>Total</th>
                        <th>Dikonfirmasi oleh</th>
                        <th>Waktu konfirmasi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($confirmedOrders as $confirmation)
                        @php($order = $confirmation['order'])
                        <tr>
                            <td>
                                <div class="ticket-name">{{ $order->order_code }}</div>
                                <div class="ticket-code">{{ $order->paid_at?->timezone('Asia/Jakarta')->format('d/m/Y H:i') }} WIB</div>
                            </td>
                            <td>
                                <div>{{ $order->buyer_name }}</div>
                                <div class="ticket-code">{{ $order->buyer_email }}</div>
                                <div class="ticket-code">WA: {{ $order->buyer_phone ?: 'Tidak dicantumkan' }}</div>
                            </td>
                            <td>
                                @foreach ($order->items as $item)
                                    <div>{{ $item->ticketType->name }} × {{ $item->quantity }}</div>
                                @endforeach
                            </td>
                            <td>Rp{{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            <td>{{ $confirmation['admin_name'] }}</td>
                            <td>{{ $confirmation['confirmed_at']?->timezone('Asia/Jakarta')->format('d/m/Y H:i') ?? 'Tidak tercatat' }} WIB</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty-state">
                                Belum ada pembayaran yang dikonfirmasi admin.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <section class="panel">
        <div class="panel-heading">
            <h2>Data Check-In ({{ $checkedInTickets->count() }})</h2>
            <a class="export-link" href="{{ route('admin.check-ins.export') }}">
                Unduh Check-In (CSV)
            </a>
        </div>
        <p class="muted">
            Daftar barcode tiket yang sudah digunakan untuk check-in, terbaru di atas.
        </p>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Barcode Tiket</th>
                        <th>Pesanan</th>
                        <th>Pemesan</th>
                        <th>WhatsApp</th>
                        <th>Kategori</th>
                        <th>Waktu Check-In</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($checkedInTickets as $ticket)
                        <tr>
                            <td><div class="ticket-code">{{ $ticket->ticket_code }}</div></td>
                            <td>{{ $ticket->orderItem->order->order_code }}</td>
                            <td>
                                <div>{{ $ticket->orderItem->order->buyer_name }}</div>
                                <div class="ticket-code">{{ $ticket->orderItem->order->buyer_email }}</div>
                            </td>
                            <td>{{ $ticket->orderItem->order->buyer_phone ?: 'Tidak dicantumkan' }}</td>
                            <td>{{ $ticket->orderItem->ticketType->name }}</td>
                            <td>{{ $ticket->checked_in_at->timezone('Asia/Jakarta')->format('d/m/Y H:i') }} WIB</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty-state">
                                Belum ada tiket yang melakukan check-in.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
    </div>
</main>

<script>
    const adminTabs = [...document.querySelectorAll('[data-admin-tab]')];
    const adminPanels = [...document.querySelectorAll('[data-admin-panel]')];

    const activateAdminTab = (name, focus = false) => {
        adminTabs.forEach((tab) => {
            const isSelected = tab.dataset.adminTab === name;
            tab.setAttribute('aria-selected', String(isSelected));
            tab.tabIndex = isSelected ? 0 : -1;
        });

        adminPanels.forEach((panel) => {
            panel.hidden = panel.dataset.adminPanel !== name;
        });

        if (focus) {
            adminTabs.find((tab) => tab.dataset.adminTab === name)?.focus();
        }

        window.history.replaceState(null, '', `#admin-panel-${name}`);
    };

    const initialPanel = document.getElementById(window.location.hash.slice(1));
    activateAdminTab(initialPanel?.dataset.adminPanel || 'konfirmasi');

    adminTabs.forEach((tab, index) => {
        tab.addEventListener('click', () => activateAdminTab(tab.dataset.adminTab));
        tab.addEventListener('keydown', (event) => {
            let nextIndex = index;

            if (event.key === 'ArrowRight') {
                nextIndex = (index + 1) % adminTabs.length;
            } else if (event.key === 'ArrowLeft') {
                nextIndex = (index - 1 + adminTabs.length) % adminTabs.length;
            } else if (event.key === 'Home') {
                nextIndex = 0;
            } else if (event.key === 'End') {
                nextIndex = adminTabs.length - 1;
            } else {
                return;
            }

            event.preventDefault();
            activateAdminTab(adminTabs[nextIndex].dataset.adminTab, true);
        });
    });

    const dashboardClock = document.getElementById('dashboardClock');
    const jakartaTime = new Intl.DateTimeFormat('id-ID', {
        timeZone: 'Asia/Jakarta',
        weekday: 'long',
        day: '2-digit',
        month: 'long',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        hourCycle: 'h23'
    });

    const updateDashboardClock = () => {
        dashboardClock.textContent = `${jakartaTime.format(new Date())} WIB`;
    };

    updateDashboardClock();
    window.setInterval(updateDashboardClock, 1000);
</script>
</body>
</html>
