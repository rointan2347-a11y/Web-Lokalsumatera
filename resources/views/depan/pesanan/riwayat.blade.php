@extends('depan.layouts.main')

@section('title', 'Riwayat Pesanan')

@section('content')
    <div class="container py-5">
        <div class="row">
            <!-- Sidebar -->
            @include('depan.dashboard-menu.sidebar')

            <!-- Konten Riwayat Pesanan -->
            <div class="col-md-9">
                <div class="card shadow-sm p-4">

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert" id="pesan-alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <h5 class="mb-4">Riwayat Pesanan</h5>

                    @if ($pesanans->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>Produk</th>
                                        <th>Total Harga</th>
                                        <th>Metode Pembayaran</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pesanans as $pesanan)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                @if ($pesanan->produk)
                                                    {{ $pesanan->produk->nama }}
                                                @elseif ($pesanan->kaosKustom)
                                                    Kaos Kustom - {{ $pesanan->kaosKustom->judul ?? 'Tanpa Judul' }}
                                                @else
                                                    -
                                                @endif
                                            </td>

                                            <td>Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                                            <td>{{ ucfirst($pesanan->metode_pembayaran) }}</td>
                                            <td>
                                                <a href="{{ route('riwayat.pesanan.detail', $pesanan->id) }}"
                                                    class="btn btn-sm btn-outline-primary mb-1">
                                                    <i class="bi bi-eye"></i> Lihat Detail
                                                </a>

                                                @if ($pesanan->status === 'selesai' && $pesanan->produk && !$pesanan->ulasan)
                                                    <a href="{{ route('ulasan.form', $pesanan->id) }}"
                                                        class="btn btn-sm btn-outline-success mb-1"> <i
                                                            class="bi bi-star"></i>
                                                        Beri Ulasan
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            Anda belum memiliki riwayat pesanan yang selesai.
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection
