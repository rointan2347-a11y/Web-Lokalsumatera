@extends('depan.layouts.main')
@section('title')
    Beranda
@endsection

@section('css')
    <style>
        .produk-card .card-img-top {
            transition: transform 0.3s ease;
        }

        .produk-card:hover .card-img-top {
            transform: scale(1.05);
        }

        .stat-title {
            font-weight: bold;
            font-size: 1.5rem;
        }

        .stat-subtitle {
            font-weight: bold;
            font-size: 1.5rem;
            color: red;
        }

        /* Container carousel dengan latar belakang hitam */
        #produkCarouselContainer {
            padding: 20px 0;
            border-radius: 15px;
            overflow: hidden;
        }

        .carousel-wrapper {
            margin-top: 50px;
        }

        .produk-card {
            border-radius: 15px;
            overflow: hidden;
        }

        .carousel-title {
            text-align: center;
            font-size: 2rem;
            color: #fff;
            font-weight: bold;
            padding: 10px 0;
        }

        .carousel-card {
            background-color: #212529;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        /* ===========================
                   Mobile Custom Carousel
                   =========================== */
        @media (max-width: 767.98px) {

            /* Hide Bootstrap carousel default for mobile */
            #produkCarouselDesktop {
                display: none;
            }

            #produkCarouselMobile {
                display: block;
                position: relative;
                overflow: hidden;
            }

            #produkCarouselMobile .carousel-track {
                display: flex;
                transition: transform 0.5s ease;
                will-change: transform;
            }

            #produkCarouselMobile .carousel-item-mobile {
                min-width: 100%;
                flex-shrink: 0;
                padding: 0 10px;
            }

            /* Kartu produk mobile full width */
            #produkCarouselMobile .produk-card {
                margin: 0 auto;
                max-width: 320px;
            }

            /* Panah navigasi mobile */
            #produkCarouselMobile .carousel-control-prev,
            #produkCarouselMobile .carousel-control-next {
                position: absolute;
                top: 50%;
                transform: translateY(-50%);
                background-color: rgba(0, 0, 0, 0.5);
                border-radius: 50%;
                width: 40px;
                height: 40px;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                z-index: 10;
                color: #fff;
                font-size: 1.5rem;
                user-select: none;
            }

            #produkCarouselMobile .carousel-control-prev {
                left: 10px;
            }

            #produkCarouselMobile .carousel-control-next {
                right: 10px;
            }
        }

        /* Desktop: show bootstrap carousel */
        @media (min-width: 768px) {
            #produkCarouselMobile {
                display: none;
            }

            #produkCarouselDesktop {
                display: block;
            }
        }
    </style>
@endsection

@section('content')
    <!-- Hero Section -->
    <section class="position-relative overflow-hidden py-5 bg-white" style="min-height: 85vh; display: flex; align-items: center;">
        <div class="container position-relative z-2">
            <div class="row align-items-center">
                <!-- Text Content -->
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <div class="pe-lg-5">
                        <span class="badge bg-orange bg-opacity-10 text-orange rounded-pill px-3 py-2 fw-bold mb-4">
                            <i class="bi bi-star-fill me-2"></i> #1 Local Brand Sumatera
                        </span>
                        <h1 class="display-3 fw-black mb-4" style="font-weight: 800; letter-spacing: -2px; line-height: 1.1;">
                            {{ $beranda->judul }}
                        </h1>
                        <p class="lead text-secondary mb-5" style="line-height: 1.8;">
                            Local Brand asal Sumatera Selatan yang menghadirkan gaya modern dan kualitas premium untuk penampilan terbaik Anda.
                        </p>
                        
                        <div class="d-flex gap-3 flex-wrap">
                            <a href="/produk" class="btn btn-dark btn-lg rounded-pill px-5 py-3 fw-bold shadow-lg" style="transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'">
                                Belanja Sekarang
                            </a>
                            <a href="/saran-ukuran" class="btn btn-outline-dark btn-lg rounded-pill px-5 py-3 fw-bold">
                                Coba AI Fitting
                            </a>
                        </div>

                        <!-- Stats Row -->
                        <div class="row mt-5 pt-4 border-top">
                            <div class="col-4">
                                <h3 class="fw-bold mb-0 text-orange">{{ $user }}+</h3>
                                <small class="text-uppercase text-muted fw-bold" style="font-size: 0.75rem; letter-spacing: 1px;">Pelanggan</small>
                            </div>
                            <div class="col-4">
                                <h3 class="fw-bold mb-0 text-orange">{{ $produkBaruCount }}+</h3>
                                <small class="text-uppercase text-muted fw-bold" style="font-size: 0.75rem; letter-spacing: 1px;">Koleksi Baru</small>
                            </div>
                            <div class="col-4">
                                @php
                                    $totalUlasan = $produk->sum(function ($item) {
                                        return $item->pesanan->sum(function ($pesanan) {
                                            return $pesanan->ulasan ? $pesanan->ulasan->count() : 0;
                                        });
                                    });
                                @endphp
                                <h3 class="fw-bold mb-0 text-orange">{{ $totalUlasan }}+</h3>
                                <small class="text-uppercase text-muted fw-bold" style="font-size: 0.75rem; letter-spacing: 1px;">Review Positif</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Image Content -->
                <div class="col-lg-6 text-center position-relative">
                    <div class="position-absolute top-50 start-50 translate-middle bg-orange rounded-circle opacity-10" style="width: 500px; height: 500px; filter: blur(80px); z-index: -1;"></div>
                    <img src="{{ asset('img/beranda.jpeg') }}" alt="Model Lokal Sumatera" class="img-fluid rounded-5 shadow-lg position-relative z-2" style="transform: rotate(2deg); max-height: 600px; object-fit: cover;">
                    
                    <!-- Floating Badge -->
                    <div class="card border-0 shadow-lg position-absolute bottom-0 start-0 mb-5 ms-md-5 p-3 rounded-4 bg-white z-3" style="max-width: 200px; transform: rotate(-3deg);">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-orange text-white rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                <i class="bi bi-shield-check-fill"></i>
                            </div>
                            <div class="text-start">
                                <h6 class="fw-bold mb-0 small">Kualitas Premium</h6>
                                <small class="text-muted" style="font-size: 0.7rem;">Garansi 100%</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Carousel Section -->
    <section class="py-5 bg-light position-relative">
        <div class="container py-5">
            <div class="text-center mb-5">
                <span class="text-orange fw-bold text-uppercase small letter-spacing-2">Katalog Pilihan</span>
                <h2 class="display-5 fw-bold mt-2">Koleksi Terbaru</h2>
            </div>
            
            @php
                use Illuminate\Support\Str;
                $produkTerbaru = \App\Models\Produk::withCount('ulasan')
                    ->withAvg('ulasan', 'rating')
                    ->latest()
                    ->take(6)
                    ->get();
            @endphp

            {{-- Desktop Carousel --}}
            <div id="produkCarouselDesktop" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
                <div class="carousel-inner">
                    @foreach ($produkTerbaru->chunk(3) as $chunkIndex => $produkChunk)
                        <div class="carousel-item {{ $chunkIndex == 0 ? 'active' : '' }}">
                            <div class="row g-4 justify-content-center">
                                @foreach ($produkChunk as $item)
                                    <div class="col-lg-4 col-md-6">
                                        <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden produk-card bg-white align-items-stretch">
                                            <div class="position-relative overflow-hidden">
                                                <a href="{{ route('produk.depan.show', $item->id) }}">
                                                    <img src="{{ $item->gambar ? asset('storage/' . $item->gambar) : asset('img/lokal1.jpg') }}"
                                                        class="card-img-top" alt="{{ $item->nama }}"
                                                        style="object-fit: cover; height: 320px; transition: transform 0.5s;">
                                                </a>
                                                
                                                <!-- Discount Badge -->
                                                @if ($item->harga_diskon && $item->harga_diskon < $item->harga)
                                                    <div class="position-absolute top-0 start-0 m-3">
                                                        <span class="badge bg-danger rounded-pill px-3 py-2 fw-bold shadow-sm">
                                                            Save {{ number_format((($item->harga - $item->harga_diskon) / $item->harga) * 100) }}%
                                                        </span>
                                                    </div>
                                                @endif

                                                <!-- Hover Action -->
                                                <div class="card-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center bg-dark bg-opacity-25 opacity-0 transition-all">
                                                    <a href="{{ route('produk.depan.show', $item->id) }}" class="btn btn-light rounded-circle shadow-lg m-2" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                                        <i class="bi bi-arrow-right fs-5"></i>
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="card-body p-4 text-center d-flex flex-column">
                                                <div class="mb-2">
                                                    @if ($item->ulasan_count > 0)
                                                        <div class="text-warning small">
                                                            @for($i = 0; $i < round($item->ulasan_avg_rating); $i++)
                                                                <i class="bi bi-star-fill"></i>
                                                            @endfor
                                                            <span class="text-muted ms-1">({{ $item->ulasan_count }})</span>
                                                        </div>
                                                    @else
                                                        <small class="text-muted fst-italic">Belum ada ulasan</small>
                                                    @endif
                                                </div>
                                                
                                                <h5 class="fw-bold text-dark mb-1">
                                                    <a href="{{ route('produk.depan.show', $item->id) }}" class="text-decoration-none text-dark stretched-link">
                                                        {{ $item->nama }}
                                                    </a>
                                                </h5>
                                                <p class="text-muted small mb-3 text-truncate">{{ $item->deskripsi }}</p>
                                                
                                                <div class="mt-auto">
                                                    @if ($item->harga_diskon && $item->harga_diskon < $item->harga)
                                                        <div class="d-flex align-items-center justify-content-center gap-2">
                                                            <span class="text-decoration-line-through text-muted small">
                                                                Rp{{ number_format($item->harga, 0, ',', '.') }}
                                                            </span>
                                                            <span class="text-danger fw-bold fs-5">
                                                                Rp{{ number_format($item->harga_diskon, 0, ',', '.') }}
                                                            </span>
                                                        </div>
                                                    @else
                                                        <span class="fw-bold text-dark fs-5">
                                                            Rp{{ number_format($item->harga, 0, ',', '.') }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Custom Navigation -->
                <div class="d-flex justify-content-center gap-3 mt-5">
                    <button class="btn btn-outline-dark rounded-circle p-3" type="button" data-bs-target="#produkCarouselDesktop" data-bs-slide="prev" style="width: 50px; height: 50px;">
                        <i class="bi bi-arrow-left"></i>
                    </button>
                    <button class="btn btn-outline-dark rounded-circle p-3" type="button" data-bs-target="#produkCarouselDesktop" data-bs-slide="next" style="width: 50px; height: 50px;">
                        <i class="bi bi-arrow-right"></i>
                    </button>
                </div>
            </div>

            {{-- Mobile Carousel --}}
            <div id="produkCarouselMobile" class="mt-4 pb-5 d-md-none">
                <div class="carousel-track d-flex" style="overflow-x: auto; gap: 1rem; padding: 1rem; scroll-snap-type: x mandatory;">
                    @foreach ($produkTerbaru as $item)
                        <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden flex-shrink-0" style="width: 280px; scroll-snap-align: center;">
                            <div class="position-relative">
                                <img src="{{ $item->gambar ? asset('storage/' . $item->gambar) : asset('img/lokal1.jpg') }}" class="card-img-top" style="height: 250px; object-fit: cover;" alt="{{ $item->nama }}">
                            </div>
                            <div class="card-body text-center">
                                <h6 class="fw-bold">{{ $item->nama }}</h6>
                                <p class="text-orange fw-bold">Rp{{ number_format($item->harga_diskon ?? $item->harga, 0, ',', '.') }}</p>
                                <a href="{{ route('produk.depan.show', $item->id) }}" class="btn btn-dark w-100 rounded-pill btn-sm">Lihat Detail</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </section>
@endsection

@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const mobileCarousel = document.getElementById('produkCarouselMobile');
            const track = mobileCarousel.querySelector('.carousel-track');
            const items = track.children;
            const totalItems = items.length;
            let index = 0;

            const prevBtn = document.getElementById('mobilePrev');
            const nextBtn = document.getElementById('mobileNext');

            // Show mobile carousel only on mobile view, desktop carousel on desktop
            function checkScreenSize() {
                if (window.innerWidth < 768) {
                    mobileCarousel.style.display = 'block';
                    document.getElementById('produkCarouselDesktop').style.display = 'none';
                } else {
                    mobileCarousel.style.display = 'none';
                    document.getElementById('produkCarouselDesktop').style.display = 'block';
                }
            }
            checkScreenSize();
            window.addEventListener('resize', checkScreenSize);

            // Move to slide by index with looping
            function goToSlide(idx) {
                if (idx < 0) {
                    index = totalItems - 1;
                } else if (idx >= totalItems) {
                    index = 0;
                } else {
                    index = idx;
                }
                const offset = -index * 100;
                track.style.transform = `translateX(${offset}%)`;
            }

            // Buttons events
            prevBtn.addEventListener('click', function () {
                goToSlide(index - 1);
            });

            nextBtn.addEventListener('click', function () {
                goToSlide(index + 1);
            });

            // Auto play mobile carousel every 4 seconds
            let autoPlayInterval = setInterval(() => {
                goToSlide(index + 1);
            }, 4000);

            // Pause on hover
            mobileCarousel.addEventListener('mouseenter', () => clearInterval(autoPlayInterval));
            mobileCarousel.addEventListener('mouseleave', () => {
                autoPlayInterval = setInterval(() => {
                    goToSlide(index + 1);
                }, 4000);
            });
        });
    </script>
@endsection