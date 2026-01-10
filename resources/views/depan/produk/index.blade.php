@extends('depan.layouts.main')
@section('title')
    Produk
@endsection
@section('content')
    @section('css')
        <style>
            .produk-card {
                border-radius: 1rem;
                overflow: hidden;
                transition: all 0.3s ease-in-out;
                transform: translateY(0);
            }

            .produk-card:hover {
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
                transform: translateY(-5px);
            }

            .produk-img {
                aspect-ratio: 4 / 3;
                width: 100%;
                object-fit: cover;
                border-top-left-radius: 1rem;
                border-top-right-radius: 1rem;
            }

            .produk-card:hover .produk-img {
                transform: scale(1.05);
            }

            .produk-card-body {
                transition: background-color 0.3s ease;
            }

            .produk-card .badge {
                font-size: 0.75rem;
            }

            .fade-in {
                animation: fadeInUp 0.6s ease forwards;
                opacity: 0;
            }

            @keyframes fadeInUp {
                0% {
                    opacity: 0;
                    transform: translateY(20px);
                }

                100% {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        </style>
    @endsection
    <div class="container py-5">

        <div class="row justify-content-center">
            <div class="col-md-8">
                <form action="{{ route('produk.depan') }}" method="GET" class="mb-4">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Cari produk..."
                            value="{{ request('search') }}">
                        <button class="btn btn-dark" type="submit">
                            <i class="bi bi-search"></i> Cari
                        </button>
                    </div>
                </form>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert" id="pesan-alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
        </div>


        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold">Produk <span class="text-muted fs-6">• {{ $produk->count() }} items</span></h4>
            {{-- <button class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-funnel"></i> Filters
            </button> --}}
        </div>

        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4">
            @php
                use Illuminate\Support\Str;
            @endphp

            @foreach ($produk as $item)
                <div class="col">
                    <div class="card h-100 border-0 produk-card fade-in">

                        <div class="position-relative">
                            {{-- <img src="{{ asset('img/lokal1.jpg') }}" class="card-img-top" alt="Produk"> --}}
                            @if ($item->gambar)
                                <a href="{{ route('produk.depan.show', $item->id) }}">
                                    <img src="{{ asset('storage/' . $item->gambar) }}" class="card-img-top produk-img"
                                        alt="{{ $item->nama }}">
                                </a>
                            @else
                                <a href="{{ route('produk.depan.show', $item->id) }}">
                                    <img src="{{ asset('img/lokal1.jpg') }}" class="card-img-top produk-img"
                                        alt="{{ $item->nama }}">
                                </a>
                            @endif


                            <!-- Rating Badge -->
                            @if ($item->ulasan_count > 0)
                                <span class="badge bg-warning text-dark position-absolute bottom-0 start-0 m-2 rounded-pill">
                                    <i class="bi bi-star-fill"></i> {{ number_format($item->ulasan_avg_rating, 1) }}
                                </span>
                            @else
                                <span class="badge bg-secondary text-white position-absolute bottom-0 start-0 m-2 rounded-pill">
                                    <i class="bi bi-star"></i> Belum ada ulasan
                                </span>
                            @endif

                            <!-- Diskon Badge -->
                            @if ($item->harga_diskon && $item->harga_diskon < $item->harga)
                                <span
                                    class="badge bg-danger text-white position-absolute top-0 start-0 m-2 rounded-pill">Diskon</span>
                            @endif
                            <!-- Wishlist -->
                            {{-- <button class="btn btn-light position-absolute bottom-0 end-0 m-2 p-1 rounded-circle">
                                <i class="bi bi-heart"></i>
                            </button> --}}
                        </div>
                        <div class="card-body text-center">
                            <h6 class="fw-semibold mb-0">{{ $item->nama }}</h6>
                            <p class="text-muted small mb-1">{{ Str::words($item->deskripsi, 15, '...') }}</p>
                            <p class="mb-2">
                                @if ($item->harga_diskon && $item->harga_diskon < $item->harga)
                                    <span
                                        class="text-decoration-line-through text-muted small">Rp{{ number_format($item->harga, 0, ',', '.') }}</span>
                                    <span
                                        class="text-danger fw-bold ms-2">Rp{{ number_format($item->harga_diskon, 0, ',', '.') }}</span>
                                @else
                                    <span class="fw-bold text-dark">Rp{{ number_format($item->harga, 0, ',', '.') }}</span>
                                @endif
                                <small class="text-muted d-block mt-1">Stok tersedia: {{ $item->stok }} item</small>

                            </p>
                            {{-- <form action="{{ route('keranjang.tambah', $item->id) }}" method="POST" class="d-inline">
                                @csrf
                                <div class="mb-3 mt-3">
                                    <input type="hidden" name="jumlah" id="jumlah" class="form-control w-50" value="1" min="1"
                                        max="{{ $item->stok }}" required>
                                </div>
                                <button class="btn btn-dark"><i class="bi bi-plus"></i> Tambah ke Keranjang</button>
                            </form> --}}

                            <a href="{{ route('produk.depan.show', $item->id) }}" class="btn btn-dark">Lihat Detail <i
                                    class="bi bi-arrow-right"></i></a>

                        </div>
                    </div>
                </div>
            @endforeach
            <div class="mt-4 d-flex justify-content-center">
                {{ $produk->links() }}
            </div>
        </div>
    </div>
@endsection