@extends('depan.layouts.main')

@section('title', 'Detail Produk')

@section('css')
    <style>
        .produk-img-detail {
            width: 100%;
            height: auto;
            border-radius: 1rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            object-fit: cover;
        }

        .produk-card-detail {
            background: #fff;
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.05);
        }

        .ukuran-radio .form-check {
            margin-right: 1rem;
        }

        .produk-img-detail {
            width: 100%;
            height: auto;
            border-radius: 1rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            object-fit: cover;
        }

        .produk-card-detail {
            background: #fff;
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.05);
        }

        .ukuran-radio .form-check {
            margin-right: 1rem;
        }

        /* Perjelas tombol carousel */
        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: rgba(0, 0, 0, 0.6);
            /* Background gelap */
            background-size: 70% 70%;
            border-radius: 50%;
            padding: 1.5rem;
        }

        .carousel-control-prev,
        .carousel-control-next {
            width: auto;
            padding: 0 1rem;
        }

        /* Indikator carousel */
        .carousel-indicators [data-bs-target] {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: #333;
            opacity: 0.7;
        }

        .carousel-indicators .active {
            background-color: #000;
            opacity: 1;
        }
    </style>

@endsection

@section('content')
    <div class="container py-5">
        <div class="row align-items-center g-5">

            <!-- Gambar Produk: Carousel -->
            <div class="col-md-6">
                <div id="produkCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner rounded shadow">

                        <!-- Slide 1: Gambar Depan -->
                        <div class="carousel-item active">
                            @if ($produk->gambar)
                                <img src="{{ asset('storage/' . $produk->gambar) }}" class="d-block w-100 produk-img-detail"
                                    alt="{{ $produk->nama }} - Depan">
                            @else
                                <img src="{{ asset('img/lokal1.jpg') }}" class="d-block w-100 produk-img-detail"
                                    alt="{{ $produk->nama }}">
                            @endif
                        </div>

                        <!-- Slide 2: Gambar Belakang (jika ada) -->
                        @if ($produk->gambar_belakang)
                            <div class="carousel-item">
                                <img src="{{ asset('storage/' . $produk->gambar_belakang) }}"
                                    class="d-block w-100 produk-img-detail" alt="{{ $produk->nama }} - Belakang">
                            </div>
                        @endif
                    </div>

                    <!-- Navigasi Carousel (jika ada gambar belakang) -->
                    @if ($produk->gambar_belakang)
                        <button class="carousel-control-prev" type="button" data-bs-target="#produkCarousel"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Sebelumnya</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#produkCarousel"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Berikutnya</span>
                        </button>

                        <!-- Indicator -->
                        <div class="carousel-indicators mt-2">
                            <button type="button" data-bs-target="#produkCarousel" data-bs-slide-to="0" class="active"
                                aria-current="true" aria-label="Slide 1"></button>
                            <button type="button" data-bs-target="#produkCarousel" data-bs-slide-to="1"
                                aria-label="Slide 2"></button>
                        </div>
                    @endif
                </div>
            </div>



            <!-- Detail Produk -->
            <div class="col-md-6">
                <div class="produk-card-detail">

                    {{-- Alert --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert" id="pesan-alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert" id="pesan-alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Judul & Deskripsi -->
                    <h2 class="fw-bold">{{ $produk->nama }}</h2>
                    @if ($produk->ulasan->count())
                        <div class="mb-2">
                            <span class="fw-bold">Rating: </span>
                            <span class="text-warning">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= round($rataRataRating))
                                        <i class="bi bi-star-fill"></i>
                                    @else
                                        <i class="bi bi-star"></i>
                                    @endif
                                @endfor
                            </span>
                            <span class="text-muted">({{ number_format($rataRataRating, 1) }} dari 5)</span>
                        </div>
                    @endif
                    <p class="text-muted">{{ $produk->deskripsi }}</p>

                    <!-- Harga -->
                    @if ($produk->harga_diskon && $produk->harga_diskon < $produk->harga)
                        <p class="mb-1 text-muted text-decoration-line-through">
                            Rp {{ number_format($produk->harga, 0, ',', '.') }}
                        </p>
                        <p class="h4 text-danger fw-semibold">
                            Rp {{ number_format($produk->harga_diskon, 0, ',', '.') }}
                        </p>
                    @else
                        <p class="h4 text-dark fw-semibold">
                            Rp {{ number_format($produk->harga, 0, ',', '.') }}
                        </p>
                    @endif


                    @auth
    @if (Auth::user()->role == 'user')
        <form action="{{ route('keranjang.tambah.item', $produk->id) }}" method="POST" class="mt-4">
            @csrf

            <!-- Pilih Ukuran -->
            <input type="hidden" name="jenis" value="produk">
            <input type="hidden" name="produk_id" value="{{ $produk->id }}">
            <div class="mb-3">
                <label class="form-label fw-semibold">Pilih Ukuran:</label>
                <div class="ukuran-radio d-flex flex-wrap">
                    @foreach (['S', 'M', 'L', 'XL', 'XXL', 'XXXL'] as $ukuran)
                        <div class="form-check me-3">
                            <input class="form-check-input" type="radio" name="ukuran"
                                id="ukuran_{{ $ukuran }}" value="{{ $ukuran }}" required>
                            <label class="form-check-label"
                                for="ukuran_{{ $ukuran }}">{{ $ukuran }}</label>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Jumlah -->
            <div class="mb-3">
                <label for="jumlah" class="form-label fw-semibold">Jumlah:</label>
                <input type="number" name="jumlah" id="jumlah" class="form-control w-50" value="1"
                    min="1" max="{{ $produk->stok }}" required>
                <small class="text-muted mt-1 d-block">Stok tersedia: {{ $produk->stok }} item</small>
            </div>

            <!-- Tombol -->
            <div class="d-flex gap-2 mb-2">
                <a href="{{ route('produk.depan') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
                <button class="btn btn-dark">
                    <i class="bi bi-plus"></i> Tambah ke Keranjang
                </button>
            </div>

            <!-- Tombol Hubungi Admin -->
            <a href="https://wa.me/6282377885282?text=Halo%20Admin%2C%20saya%20ingin%20bertanya%20tentang%20produk%20{{ urlencode($produk->nama) }}"
               target="_blank"
               class="btn btn-success w-100">
                <i class="bi bi-whatsapp"></i> Hubungi Admin
            </a>
        </form>

                        @else
                            <p class="text-muted mt-3">Stok tersedia: {{ $produk->stok }} item</p>
                            <a href="{{ route('produk.depan') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                        @endif
                    @endauth
                </div>

                {{-- Daftar Ulasan --}}
                <div class="mt-5">
                    <h4 class="fw-bold mb-4">
                        Ulasan Pembeli
                        @if ($produk->ulasan->count())
                            ({{ $produk->ulasan->count() }})
                        @else
                            (0)
                        @endif
                    </h4>

                    @if ($produk->ulasan->count() > 0)
                        @foreach ($produk->ulasan as $ulasan)
                            <div class="border rounded p-3 mb-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <strong>{{ $ulasan->pesanan->user->nama }}</strong>
                                    <div class="text-warning">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $ulasan->rating)
                                                <i class="bi bi-star-fill"></i>
                                            @else
                                                <i class="bi bi-star"></i>
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                                @if ($ulasan->komentar)
                                    <p class="mt-2 mb-1">{{ $ulasan->komentar }}</p>
                                @endif

                                @if ($ulasan->gambar->count())
                                    <div class="d-flex flex-wrap gap-2 mt-2">
                                        @foreach ($ulasan->gambar as $img)
                                            <img src="{{ asset('storage/' . $img->gambar) }}" alt="Gambar Ulasan"
                                                class="img-thumbnail" style="max-width: 120px;">
                                        @endforeach
                                    </div>
                                @endif
                                <small
                                    class="text-muted d-block mt-2">{{ $ulasan->created_at->format('d M Y, H:i') }}</small>
                            </div>
                        @endforeach
                    @else
                        <div class="alert alert-info">
                            Belum ada ulasan untuk produk ini.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
