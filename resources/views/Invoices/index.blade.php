@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Daftar Invoice</h2>
        <a href="{{ route('invoices.create') }}" class="btn btn-primary mb-3">+ Buat Invoice</a>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nomor</th>
                    <th>Client</th>
                    <th>Jumlah</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoices as $invoice)
                    <tr>
                        <td>{{ $invoice->number }}</td>
                        <td>{{ $invoice->client_name }}</td>
                        <td>{{ $invoice->formatted_amount }}</td>
                        <td>
                            <a href="{{ route('invoices.show', $invoice->id) }}" class="btn btn-sm btn-info">Lihat</a>
                            <a href="{{ route('invoices.edit', $invoice->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('invoices.destroy', $invoice->id) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger"
                                    onclick="return confirm('Hapus invoice ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection