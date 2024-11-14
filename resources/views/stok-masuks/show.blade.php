@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="my-3">Detail Obat</h2>

    
    <a href="">Edit Barang</a>
    
    <div class="card">
        <div class="card-header">
            <h5>{{ $obat->nama_obat }} ({{ $obat->kode_obat }})</h5>
        </div>
        <div class="card-body">

            @if ($obat->foto_obat)
                <img src="{{ asset($obat->foto_obat) }}" alt="">
            @else
                <p>Belum ada foto</p>
            @endif

            <p><strong>Kekuatan Obat:</strong> {{ $obat->kekuatan_obat }}</p>
            <p><strong>Kemasan Obat:</strong> {{ $obat->kemasan->nama_kemasan ?? 'N/A' }}</p>
            <p><strong>Bentuk Sediaan:</strong> {{ $obat->bentukSediaan->nama_bentuk_sediaan ?? 'N/A' }}</p>
            <p><strong>Satuan:</strong> {{ $obat->satuan->nama_satuan ?? 'N/A' }}</p>
            <p><strong>Stok Obat:</strong> {{ $obat->stok_obat }}</p>

        </div>
        <div class="card-footer">
            <a href="{{ route('data-obat.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection