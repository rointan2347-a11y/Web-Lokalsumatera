@extends('depan.layouts.main')

@section('title', 'Pesanan Saya')

@section('content')
    <div class="container py-5">
        <div class="row">
            <!-- Sidebar -->
            @include('depan.dashboard-menu.sidebar')

            <!-- Konten Pesanan -->
            <div class="col-md-9">
                <div class="card shadow-sm p-4">

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert" id="pesan-alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if (session('info'))
                        <div class="alert alert-info alert-dismissible fade show" role="alert" id="pesan-alert">
                            {{ session('info') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <h5 class="mb-4">Pesanan Saya</h5>
                    <div class="d-flex justify-content-start mb-3">
                        <form method="GET" action="{{ route('pesanan.user.index') }}">
                            <div class="input-group">
                                <select name="status" class="form-select" onchange="this.form.submit()">
                                    <option value="">-- Filter Status --</option>
                                    @foreach (['menunggu', 'diproses', 'dikirim', 'dibatalkan'] as $status)
                                        <option value="{{ $status }}"
                                            {{ request('status') === $status ? 'selected' : '' }}>
                                            {{ ucfirst($status) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                    </div>

                    @if (count($pesanans) > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>Produk</th>
                                        <th>Total Harga</th>
                                        <th>Metode Pembayaran</th>
                                        <th>Status</th>
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
                                            <td>{{ ucfirst($pesanan->status) }}</td>
                                            <td>
                                                <a href="{{ route('pesanan.user.show', $pesanan->id) }}"
                                                    class="btn btn-sm btn-outline-primary mb-1"><i class="bi bi-eye"></i>
                                                    Lihat Detail
                                                </a>

                                                @if ($pesanan->status === 'menunggu' && !$pesanan->bukti_transfer)
                                                    <form action="{{ route('pesanan.user.batal', $pesanan->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <button class="btn btn-sm btn-outline-warning mb-1 text-dark"
                                                            onclick="return confirm('Yakin ingin membatalkan pesanan ini?')"><i
                                                                class="bi bi-x-octagon"></i> Batalkan</button>
                                                    </form>
                                                @endif

                                                @if ($pesanan->status === 'dikirim')
                                                    <form action="{{ route('pesanan.user.terima', $pesanan->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <button class="btn btn-sm btn-outline-success mb-1"
                                                            onclick="return confirm('Konfirmasi bahwa barang sudah diterima?')"><i
                                                                class="bi bi-check-circle"></i>
                                                            Pesanan Diterima
                                                        </button>
                                                    </form>
                                                @endif

                                                @if ($pesanan->status === 'dibatalkan')
                                                    <form action="{{ route('pesanan.user.hapus', $pesanan->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-sm btn-outline-danger mb-1"
                                                            onclick="return confirm('Hapus pesanan ini secara permanen?')"><i
                                                                class="bi bi-trash"></i> Hapus</button>
                                                    </form>
                                                @endif
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            @if (request('status'))
                                Tidak ada pesanan dengan status <strong>{{ ucfirst(request('status')) }}</strong>.
                            @else
                                Anda belum memiliki pesanan.
                            @endif
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection
