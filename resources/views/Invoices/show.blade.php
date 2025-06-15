@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Detail Invoice</h2>
        <div class="card">
            <div class="card-body">
                <h5>Nomor: {{ $invoice->number }}</h5>
                <p>Client: {{ $invoice->client_name }}</p>
                <p>Jumlah: {{ $invoice->formatted_amount }}</p>
                <p>Deskripsi: {{ $invoice->description }}</p>

                <hr>
                @if ($isValid)
                    <div class="alert alert-success mt-3">
                        <strong>Status Keaslian Tanda Tangan:</strong> <span class="badge bg-success">Valid ✅</span>
                    </div>
                @else
                    <div class="alert alert-danger mt-3">
                        <strong>Status Keaslian Tanda Tangan:</strong> <span class="badge bg-danger">Tidak Sah ❌</span>
                    </div>
                @endif

                {{-- Tombol Kembali --}}
                <a href="{{ route('invoices.index') }}" class="btn btn-secondary mt-3">← Kembali</a>

                {{-- Tombol Download PDF --}}
                @if ($isValid)
                    <a href="{{ route('invoices.download', $invoice->id) }}" class="btn btn-success mt-3">
                        ⬇️ Download PDF
                    </a>
                @endif
            </div>
        </div>
    </div>
@endsection