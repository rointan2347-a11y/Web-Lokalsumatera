@extends('admin.layouts.main')

@section('title')
    Dashboard
@endsection

@section('content')
    <div class="row mb-5 align-items-center">
        <div class="col-md-6">
            <h1 class="h2 mb-0 text-secondary font-weight-bold" style="font-family: 'Outfit', sans-serif;">Dashboard <span class="text-primary">Overview</span></h1>
            <p class="text-muted mb-0">Monitor performa penjualan butik Anda secara real-time.</p>
        </div>
        <div class="col-md-6 text-md-right mt-3 mt-md-0">
             <a href="#" class="btn btn-sm btn-primary shadow-sm px-4 py-2">
                <i class="fas fa-download fa-sm text-white-50 mr-2"></i> Unduh Laporan
            </a>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="row mb-4">
        <!-- Total Produk -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100 py-3 position-relative overflow-hidden" style="border-bottom: 4px solid #ff7e14;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1" style="letter-spacing: 1px;">Produk Ready</div>
                            <div class="h2 mb-0 font-weight-bold text-secondary">{{ $totalProduk }}</div>
                        </div>
                        <div class="col-auto">
                            <div class="icon-circle bg-primary-light text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: rgba(255,126,20,0.1);">
                                <i class="fas fa-box fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="position-absolute" style="right: -20px; bottom: -20px; opacity: 0.05; transform: rotate(-15deg);">
                    <i class="fas fa-box fa-8x text-primary"></i>
                </div>
            </div>
        </div>

        <!-- Total Pesanan -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100 py-3 position-relative overflow-hidden" style="border-bottom: 4px solid #00c853;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1" style="letter-spacing: 1px;">Total Pesanan</div>
                            <div class="h2 mb-0 font-weight-bold text-secondary">{{ $totalPesanan }}</div>
                        </div>
                        <div class="col-auto">
                            <div class="icon-circle text-success rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: rgba(0, 200, 83, 0.1);">
                                <i class="fas fa-shopping-bag fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="position-absolute" style="right: -20px; bottom: -20px; opacity: 0.05; transform: rotate(-15deg);">
                    <i class="fas fa-shopping-bag fa-8x text-success"></i>
                </div>
            </div>
        </div>

        <!-- Total Pengguna -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100 py-3 position-relative overflow-hidden" style="border-bottom: 4px solid #00b0ff;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1" style="letter-spacing: 1px;">Pengguna Aktif</div>
                            <div class="h2 mb-0 font-weight-bold text-secondary">{{ $totalUser }}</div>
                        </div>
                        <div class="col-auto">
                            <div class="icon-circle text-info rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: rgba(0, 176, 255, 0.1);">
                                <i class="fas fa-users fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="position-absolute" style="right: -20px; bottom: -20px; opacity: 0.05; transform: rotate(-15deg);">
                    <i class="fas fa-users fa-8x text-info"></i>
                </div>
            </div>
        </div>

        <!-- Kaos Kustom -->
         <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100 py-3 position-relative overflow-hidden" style="border-bottom: 4px solid #ffd600;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1" style="letter-spacing: 1px;">Desain Kustom</div>
                            <div class="h2 mb-0 font-weight-bold text-secondary">{{ $totalKustom }}</div>
                        </div>
                        <div class="col-auto">
                            <div class="icon-circle text-warning rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: rgba(255, 214, 0, 0.1);">
                                <i class="fas fa-palette fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="position-absolute" style="right: -20px; bottom: -20px; opacity: 0.05; transform: rotate(-15deg);">
                    <i class="fas fa-palette fa-8x text-warning"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts & Tables Row -->
    <div class="row">
        <!-- Main Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-white border-bottom-0 pt-4">
                    <h6 class="m-0 font-weight-bold text-secondary"><i class="fas fa-chart-area mr-2 text-primary"></i>Tren Penjualan</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle text-secondary" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-filter fa-sm text-primary"></i> Filter
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="#">Minggu Ini</a>
                            <a class="dropdown-item" href="#">Bulan Ini</a>
                            <div class="dropdown-divider"></div>
                             <a class="dropdown-item" href="#">Reset Filter</a>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                     <form method="GET" action="{{ route('admin.dashboard') }}" class="mb-4 bg-light p-3 rounded-lg overflow-hidden">
                        <div class="row align-items-end">
                            <div class="col-md-4">
                                <label class="small text-muted font-weight-bold text-uppercase">Dari Tanggal</label>
                                <input type="date" name="tanggal_awal" class="form-control border-0 shadow-none bg-white"
                                    value="{{ request('tanggal_awal') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="small text-muted font-weight-bold text-uppercase">Sampai Tanggal</label>
                                <input type="date" name="tanggal_akhir" class="form-control border-0 shadow-none bg-white"
                                    value="{{ request('tanggal_akhir') }}">
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary btn-block shadow-none">Terapkan</button>
                            </div>
                        </div>
                    </form>
                    <div class="chart-area">
                        <canvas id="pesananChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pie Chart / Status -->
        <div class="col-xl-4 col-lg-5">
             <div class="card shadow mb-4">
                <div class="card-header py-3 bg-white border-bottom-0 pt-4">
                     <h6 class="m-0 font-weight-bold text-secondary"><i class="fas fa-trophy mr-2 text-warning"></i>Produk Terlaris</h6>
                </div>
                <div class="card-body p-0">
                     @if($produkTerlaris->isEmpty())
                        <div class="text-center py-5">
                            <img src="{{ asset('img/undraw_empty.svg') }}" style="width: 100px; opacity: 0.5;">
                            <p class="text-muted mt-3 small">Belum ada data penjualan.</p>
                        </div>
                    @else
                        <div class="list-group list-group-flush">
                            @foreach($produkTerlaris as $index => $item)
                            <div class="list-group-item d-flex align-items-center justify-content-between px-4 py-3 border-bottom-light">
                                <div class="d-flex align-items-center">
                                    <span class="badge badge-primary badge-pill mr-3">{{ $index + 1 }}</span>
                                    <div>
                                        <div class="font-weight-bold text-dark">{{ \Illuminate\Support\Str::limit($item->produk->nama ?? 'Produk Dihapus', 20) }}</div>
                                        <div class="small text-muted">{{ $item->total_terjual }} terjual</div>
                                    </div>
                                </div>
                                <i class="fas fa-chevron-right text-gray-300"></i>
                            </div>
                            @endforeach
                        </div>
                    @endif
                     <div class="p-3 text-center bg-light">
                        <a href="/admin/produk" class="small font-weight-bold text-primary">Lihat Semua Produk &rarr;</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Statistik Grid -->
    <div class="row">
        <div class="col-12">
            <h5 class="mb-3 text-secondary" style="font-weight: 700;">Statistik Pesanan</h5>
        </div>
        
        <!-- Loop Status Produk Jadi -->
         @foreach ($statusPesanProduk as $statusProduk => $jumlahProduk)
            <div class="col-xl-2 col-md-4 mb-3">
                <div class="card text-center h-100 py-3 hover-lift" style="background: white; border: 1px solid rgba(0,0,0,0.02);">
                    <div class="card-body p-2">
                        <div class="mb-2">
                            @if($statusProduk == 'menunggu') <i class="fas fa-clock text-warning fa-2x"></i>
                            @elseif($statusProduk == 'diproses') <i class="fas fa-cog fa-spin text-info fa-2x"></i>
                            @elseif($statusProduk == 'dikirim') <i class="fas fa-truck text-primary fa-2x"></i>
                            @elseif($statusProduk == 'selesai') <i class="fas fa-check-circle text-success fa-2x"></i>
                            @else <i class="fas fa-times-circle text-danger fa-2x"></i>
                            @endif
                        </div>
                        <div class="small text-uppercase text-muted font-weight-bold">{{ ucfirst($statusProduk) }}</div>
                        <div class="h4 font-weight-bold text-dark mt-1">{{ $jumlahProduk }}</div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const dataProdukJadi = {!! json_encode($grafikProdukJadi) !!} ?? [];
            const dataKaosKustom = {!! json_encode($grafikKaosKustom) !!} ?? [];

            let allDates = [
                ...new Set([
                    ...dataProdukJadi.map(item => item.tanggal),
                    ...dataKaosKustom.map(item => item.tanggal)
                ])
            ].sort();

            function mapDataByDate(data, dates) {
                const map = Object.fromEntries(data.map(item => [item.tanggal, item.total]));
                return dates.map(date => map[date] ?? 0);
            }

            const dataJadi = mapDataByDate(dataProdukJadi, allDates);
            const dataKustom = mapDataByDate(dataKaosKustom, allDates);

            const ctx = document.getElementById('pesananChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: allDates,
                    datasets: [
                        {
                            label: 'Produk Jadi',
                            data: dataJadi,
                            borderColor: 'rgba(54, 162, 235, 1)',
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            fill: true,
                            tension: 0.3
                        },
                        {
                            label: 'Kaos Kustom',
                            data: dataKustom,
                            borderColor: 'rgba(255, 206, 86, 1)',
                            backgroundColor: 'rgba(255, 206, 86, 0.2)',
                            fill: true,
                            tension: 0.3
                        }
                    ]
                },
                options: {
                    responsive: true,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    stacked: false,
                    plugins: {
                        title: {
                            display: false
                        },
                        tooltip: {
                            enabled: true,
                            mode: 'nearest'
                        },
                        legend: {
                            display: true,
                            position: 'top'
                        }
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Tanggal'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Jumlah Pesanan Selesai'
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection