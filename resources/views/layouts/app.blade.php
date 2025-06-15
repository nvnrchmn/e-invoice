<!DOCTYPE html>
<html>

<head>
    <title>E-Invoice System</title>
    {{-- Menambahkan logo pada tab di website --}}
    <link rel="icon" href="{{ asset('images/logo-einvoice.png') }}" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-dark bg-dark mb-3">
        <div class="container">
            <a class="navbar-brand" href="{{ route('invoices.index') }}">E-Invoice RSA</a>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>
</body>

</html>