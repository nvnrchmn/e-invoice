<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Verifikasi Invoice</title>
    <style>
        body {
            font-family: sans-serif;
            text-align: center;
            padding: 50px;
        }

        .valid {
            color: green;
            font-weight: bold;
        }

        .invalid {
            color: red;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h2>Verifikasi Invoice #{{ $invoice->number }}</h2>
    <p>Client: <strong>{{ $invoice->client_name }}</strong></p>
    <p>Jumlah: <strong>Rp {{ number_format($invoice->amount, 0, ',', '.') }}</strong></p>
    <p>Status Keaslian:</p>
    @if ($isValid)
        <p class="valid">✔ Valid - Tanda tangan cocok</p>
    @else
        <p class="invalid">✘ Tidak Valid - Tanda tangan tidak cocok</p>
    @endif
</body>

</html>