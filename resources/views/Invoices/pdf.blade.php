<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $invoice->number }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #333;
            font-size: 12px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
        }

        .header .title h1 {
            margin: 0;
            font-size: 24px;
        }

        .invoice-details,
        .signature-section {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .invoice-details td {
            padding: 8px;
        }

        .invoice-details tr:nth-child(odd) {
            background-color: #f2f2f2;
        }

        .signature-box {
            background-color: #f9f9f9;
            border: 1px dashed #aaa;
            padding: 10px;
            word-break: break-word;
            font-size: 10px;
        }

        .valid {
            color: green;
            font-weight: bold;
        }

        .invalid {
            color: red;
            font-weight: bold;
        }

        .logo {
            height: 50px;
        }
    </style>
</head>

<body>

    <div class="header">
        <div class="logo">
            <img src="{{ public_path('images/logo-einvoice.png') }}" alt="Logo" class="logo">
        </div>
        <div class="title">
            <h1>INVOICE</h1>
            <p><strong>No:</strong> {{ $invoice->number }}</p>
        </div>
    </div>

    <table class="invoice-details">
        <tr>
            <td><strong>Client:</strong></td>
            <td>{{ $invoice->client_name }}</td>
        </tr>
        <tr>
            <td><strong>Jumlah:</strong></td>
            <td>Rp {{ number_format($invoice->amount, 0, ',', '.') }}</td>
        </tr>
        @if($invoice->description)
            <tr>
                <td><strong>Deskripsi:</strong></td>
                <td>{{ $invoice->description }}</td>
            </tr>
        @endif
        <tr>
            <td><strong>Tanggal:</strong></td>
            <td>{{ $invoice->created_at->format('d M Y H:i') }}</td>
        </tr>
    </table>

    <h4>Keaslian Tanda Tangan Digital</h4>
    <p>Status:
        @if($isValid)
            <span class="valid">✔ Valid</span>
        @else
            <span class="invalid">✘ Tidak Valid</span>
        @endif
    </p>

    @if(isset($svgBase64))
        <div style="text-align: right; margin-top: 30px;">
            <img src="{{ $svgBase64 }}" alt="QR Signature">
            <p style="font-size: 10px;">QR Code - Signature Hash</p>
        </div>
    @endif

    <p style="margin-top: 40px; font-size: 10px; color: #555;">
        *Dokumen ini ditandatangani secara digital menggunakan sistem RSA (asymmetric cryptography).
    </p>

</body>

</html>