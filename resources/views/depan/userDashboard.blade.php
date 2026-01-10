@extends('depan.layouts.main')

@section('title', 'Dashboard')

@section('content')
    <div class="container py-5">
        <div class="row">
            <!-- Sidebar Dashboard -->
            @include('depan.dashboard-menu.sidebar')

            <!-- Konten Utama -->
            <div class="col-md-9">
                
                <!-- Welcome Banner -->
                <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden" style="background: linear-gradient(135deg, #ff7e14 0%, #ff512f 100%);">
                    <div class="card-body p-4 text-white d-flex align-items-center justify-content-between">
                        <div>
                            <h4 class="fw-bold mb-1">Halo, {{ Auth::user()->nama }}! 👋</h4>
                            <p class="mb-0 opacity-75">Selamat datang kembali di dashboard Anda.</p>
                        </div>
                        <div class="d-none d-md-block opacity-50">
                            <i class="bi bi-person-bounding-box" style="font-size: 3rem;"></i>
                        </div>
                    </div>
                </div>

                <!-- Stats Grid -->
                <div class="row g-4 mb-4">
                    <!-- Produk -->
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm rounded-4 h-100 hover-scale transition-all">
                            <div class="card-body p-4 d-flex align-items-center gap-3">
                                <div class="icon-box bg-orange-soft text-orange rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; flex-shrink: 0;">
                                    <i class="bi bi-box-seam fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="text-muted small text-uppercase fw-bold mb-1">Produk</h6>
                                    <h3 class="mb-0 fw-bold">{{ $produk }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Desain Saya -->
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm rounded-4 h-100 hover-scale transition-all">
                            <div class="card-body p-4 d-flex align-items-center gap-3">
                                <div class="icon-box bg-purple-soft text-purple rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; flex-shrink: 0;">
                                    <i class="bi bi-palette fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="text-muted small text-uppercase fw-bold mb-1">Desain Saya</h6>
                                    <h3 class="mb-0 fw-bold">{{ $desainSaya }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Keranjang -->
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm rounded-4 h-100 hover-scale transition-all">
                            <div class="card-body p-4 d-flex align-items-center gap-3">
                                <div class="icon-box bg-green-soft text-success rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; flex-shrink: 0;">
                                    <i class="bi bi-cart3 fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="text-muted small text-uppercase fw-bold mb-1">Keranjang</h6>
                                    <h3 class="mb-0 fw-bold">{{ $keranjangItem }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions / Info -->
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                        <h5 class="fw-bold mb-0">Aktivitas Terbaru</h5>
                    </div>
                    <div class="card-body p-4 text-center text-muted">
                        <div class="py-5">
                            <i class="bi bi-inbox fs-1 mb-3 d-block text-gray-300"></i>
                            <p class="mb-0">Belum ada aktivitas terbaru hari ini.</p>
                            <a href="/produk" class="btn btn-outline-orange rounded-pill mt-3 fw-bold small">
                                Mulai Belanja
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <style>
        /* Dashboard Specific Colors */
        .bg-orange-soft { background-color: #fff3e0; }
        .text-orange { color: #ff7e14 !important; }
        .btn-outline-orange {
            color: #ff7e14;
            border-color: #ff7e14;
            transition: all 0.3s;
        }
        .btn-outline-orange:hover {
            background-color: #ff7e14;
            color: white;
        }

        .bg-purple-soft { background-color: #f3e5f5; }
        .text-purple { color: #9c27b0; }

        .bg-green-soft { background-color: #e8f5e9; }
        
        .transition-all { transition: all 0.3s ease; }
        .hover-scale:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.05) !important; cursor: pointer; }
        
        .text-gray-300 { color: #e0e0e0; }
    </style>
@endsection
