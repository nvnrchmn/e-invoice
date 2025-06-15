@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Edit Invoice</h2>
        <form action="{{ route('invoices.update', $invoice->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label>Nomor Invoice</label>
                <input type="text" value="{{ $invoice->number }}" class="form-control" disabled>
            </div>
            <div class="mb-3">
                <label>Nama Client</label>
                <input type="text" name="client_name" class="form-control" value="{{ $invoice->client_name }}" required>
            </div>
            <div class="mb-3">
                <label>Deskripsi</label>
                <textarea name="description" class="form-control">{{ $invoice->description }}</textarea>
            </div>
            <div class="mb-3">
                <label>Jumlah</label>
                <input type="number" step="0.01" name="amount" class="form-control" value="{{ $invoice->amount }}" required>
            </div>
            <button type="submit" class="btn btn-success">Perbarui</button>
        </form>
    </div>
@endsection