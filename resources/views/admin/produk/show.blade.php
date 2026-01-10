@extends('admin.layouts.main')

@section('title', 'Detail Produk')

@section('content')
    <div class="container py-4">
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">Detail Produk</h5>
                <a href="{{ route('produk.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="fw-semibold">Gambar Depan</h6>
                        @if ($produk->gambar)
                            <img src="{{ asset('storage/' . $produk->gambar) }}" alt="Gambar Produk"
                                class="img-fluid rounded shadow-sm mb-2">
                        @else
                            <img src="{{ asset('img/lokal1.jpg') }}" alt="Produk Default"
                                class="img-fluid rounded shadow-sm mb-2">
                        @endif
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-semibold">Gambar Belakang</h6>
                        @if ($produk->gambar_belakang)
                            <img src="{{ asset('storage/' . $produk->gambar_belakang) }}" alt="Gambar Belakang"
                                class="img-fluid rounded shadow-sm mb-2">
                        @else
                            <p class="text-muted fst-italic">Tidak ada gambar belakang.</p>
                        @endif
                    </div>
                </div>

                <hr>
                <h4 class="fw-bold">{{ $produk->nama }}</h4>
                <p class="text-muted mb-1">Stok: {{ $produk->stok }} item</p>
                <p class="mb-1">
                    Harga:
                    <span class="text-decoration-line-through text-muted">Rp
                        {{ number_format($produk->harga, 0, ',', '.') }}</span>
                </p>
                @if ($produk->harga_diskon && $produk->harga_diskon < $produk->harga)
                    <p class="h5 text-danger mb-1">Rp {{ number_format($produk->harga_diskon, 0, ',', '.') }}</p>
                @else
                    <p class="h5 text-dark mb-1">Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
                @endif

                <p class="mt-2">
                    <strong>Rating Rata-rata:</strong>
                    @php
                        $rating = $produk->ulasan->avg('rating');
                    @endphp
                    <span class="text-warning">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= round($rating))
                                <i class="fas fa-star"></i>
                            @else
                                <i class="far fa-star"></i>
                            @endif
                        @endfor
                    </span>
                    <small class="text-muted ms-1">({{ number_format($rating, 1) }} dari 5)</small>
                </p>

                <hr>
                <h6 class="fw-bold">Deskripsi Produk</h6>
                <p>{{ $produk->deskripsi }}</p>
            </div>
        </div>
    </div>
@endsection
