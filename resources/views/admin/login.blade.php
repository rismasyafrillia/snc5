
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Admin - SNC #5</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            display: grid;
            place-items: center;
            background: #0b1730;
            color: #172033;
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        .login-card {
            background: white;
            padding: 32px;
            border-radius: 16px;
            width: 100%;
            max-width: 400px;
        }
        h1 { margin-top: 0; font-size: 25px; }
        p { color: #64748b; }
        label { display: block; margin: 18px 0 8px; }
        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
        }
        button {
            width: 100%;
            margin-top: 22px;
            padding: 13px;
            border: 0;
            border-radius: 8px;
            background: #0b1730;
            color: white;
            cursor: pointer;
        }
        .error { color: #b91c1c; font-size: 14px; }
    </style>
</head>
<body>
    <main class="login-card">
        <h1>Admin SNC #5</h1>
        <p>Masuk untuk mengelola tiket acara.</p>

        @if ($errors->any())
            <div class="error">
                @foreach ($errors->all() as $error)
                    <p class="error">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('admin.authenticate') }}">
            @csrf

            <label for="email">Email admin</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autocomplete="username"
            >

            <label for="password">Password</label>
            <input
                id="password"
                type="password"
                name="password"
                required
                autocomplete="current-password"
            >

            <button type="submit">Masuk</button>
        </form>
    </main>
</body>
</html>
