@extends('admin.layouts.main')
@section('title')
    Data Pesanan
@endsection
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">List Pesanan</h6>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="card-body">
            <div class="d-flex justify-content-end mb-3">
                <form method="GET" action="{{ route('admin.pesanan.index') }}">
                    <div class="form-group">
                        <select name="status" class="form-control" onchange="this.form.submit()">
                            <option value="">-- Semua Status --</option>
                            @foreach (['menunggu', 'diproses', 'dikirim', 'selesai', 'dibatalkan'] as $status)
                                <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pemesan</th>
                            <th>Produk / Kustom</th>
                            <th>Total Harga</th>
                            <th>Metode Pembayaran</th>
                            <th>Bukti Transfer</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pesanans as $pesanan)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $pesanan->user->nama }}</td>
                                <td>
                                    @if ($pesanan->produk)
                                        {{ $pesanan->produk->nama }}
                                    @elseif ($pesanan->kaos_kustom)
                                        Kaos Kustom - <a
                                            href="{{ asset('storage/' . $pesanan->kaos_kustom->desain_depan) }}"
                                            target="_blank">Lihat Desain</a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                                <td>{{ ucfirst($pesanan->metode_pembayaran) }}</td>
                                <td>
                                    @if ($pesanan->bukti_transfer)
                                        <button class="btn btn-primary" style="cursor: pointer" data-toggle="modal"
                                            data-target="#modalBuktiTransfer">Lihat Bukti</button>

                                        <!-- Modal Bukti Transfer -->
                                        <div class="modal fade" id="modalBuktiTransfer" tabindex="-1" role="dialog"
                                            aria-labelledby="buktiTransferLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-body text-center">
                                                        <img src="{{ asset('storage/' . $pesanan->bukti_transfer) }}"
                                                            class="img-fluid" alt="Bukti Transfer">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <em>-</em>
                                    @endif
                                </td>
                                <td>
                                    @switch($pesanan->status)
                                        @case('menunggu')
                                            <span class="badge badge-warning">Menunggu</span>
                                        @break

                                        @case('diproses')
                                            <span class="badge badge-primary">Diproses</span>
                                        @break

                                        @case('dikirim')
                                            <span class="badge badge-info">Dalam Pengantaran</span>
                                        @break

                                        @case('selesai')
                                            <span class="badge badge-success">Selesai</span>
                                        @break

                                        @case('dibatalkan')
                                            <span class="badge badge-danger">Dibatalkan</span>
                                        @break
                                    @endswitch
                                </td>

                                <td>
                                    <a href="{{ route('admin.pesanan.detail', $pesanan->id) }}"
                                        class="btn btn-info btn-sm mb-2">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                    @if (!in_array($pesanan->status, ['selesai', 'dibatalkan']))
                                        <form action="{{ route('admin.pesanan.updateStatus', $pesanan->id) }}"
                                            method="POST" style="display:inline-block">
                                            @csrf
                                            @method('PUT')
                                            <select name="status" class="form-control mb-2" onchange="this.form.submit()">
                                                <option value="menunggu"
                                                    {{ $pesanan->status === 'menunggu' ? 'selected' : '' }}>Menunggu
                                                </option>
                                                <option value="diproses"
                                                    {{ $pesanan->status === 'diproses' ? 'selected' : '' }}>Diproses
                                                </option>
                                                <option value="dikirim"
                                                    {{ $pesanan->status === 'dikirim' ? 'selected' : '' }}>
                                                    Dikirim</option>
                                            </select>
                                        </form>
                                    @endif

                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">Tidak ada pesanan untuk status ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endsection
    @section('scripts')
        <script>
            $(document).ready(function() {
                setTimeout(function() {
                    $("#success-alert").fadeOut('slow');
                }, 3000);
            });
        </script>
    @endsection
