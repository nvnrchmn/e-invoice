@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Buat Invoice Baru</h2>
        <form action="{{ route('invoices.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Nomor Invoice</label>
                <input type="text" name="number" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Nama Client</label>
                <input type="text" name="client_name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Deskripsi</label>
                <textarea name="description" class="form-control"></textarea>
            </div>
            <div class="mb-3">
                <label>Jumlah</label>
                <input type="number" step="0.01" name="amount" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Simpan</button>
        </form>
    </div>
@endsection