@extends('depan.layouts.main')

@section('title', 'Detail Riwayat Pesanan')

@section('content')
    <div class="container py-5">
        <div class="row">
            @include('depan.dashboard-menu.sidebar')

            <div class="col-md-9">
                <div class="card shadow-sm p-4">
                    <h4 class="mb-4">Detail Riwayat Pesanan</h4>

                    <table class="table table-bordered">
                        <tr>
                            <th>Produk</th>
                            <td>
                                @if ($pesanan->produk)
                                    <div>
                                        {{ $pesanan->produk->nama }}
                                        @if ($pesanan->produk->gambar)
                                            <div class="mt-2 d-flex gap-3 flex-wrap">
                                                {{-- Gambar Depan --}}
                                                <div>
                                                    <img src="{{ asset('storage/' . $pesanan->produk->gambar) }}"
                                                        alt="Gambar Produk Depan" class="img-thumbnail"
                                                        style="max-width: 150px; cursor: pointer;" data-bs-toggle="modal"
                                                        data-bs-target="#modalGambarProduk">
                                                    <div class="text-center mt-1 small">Depan</div>
                                                </div>

                                                {{-- Gambar Belakang (jika ada) --}}
                                                @if ($pesanan->produk->gambar_belakang)
                                                    <div>
                                                        <img src="{{ asset('storage/' . $pesanan->produk->gambar_belakang) }}"
                                                            alt="Gambar Produk Belakang" class="img-thumbnail"
                                                            style="max-width: 150px; cursor: pointer;"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modalGambarProdukBelakang">
                                                        <div class="text-center mt-1 small">Belakang</div>
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                @elseif ($pesanan->kaosKustom)
                                    <div>
                                        Kaos Kustom - {{ $pesanan->kaosKustom->judul ?? 'Tanpa Judul' }}
                                        <div class="d-flex gap-2 mt-2 flex-wrap">
                                            <img src="{{ asset('storage/' . $pesanan->kaosKustom->desain_depan) }}"
                                                alt="Desain Depan" class="img-thumbnail"
                                                style="max-width: 120px; cursor: pointer;" data-bs-toggle="modal"
                                                data-bs-target="#modalDesainDepan">

                                            <img src="{{ asset('storage/' . $pesanan->kaosKustom->desain_belakang) }}"
                                                alt="Desain Belakang" class="img-thumbnail"
                                                style="max-width: 120px; cursor: pointer;" data-bs-toggle="modal"
                                                data-bs-target="#modalDesainBelakang">
                                        </div>
                                    </div>
                                @else
                                    <em>-</em>
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th>Ukuran</th>
                            <td>{{ $pesanan->ukuran }}</td>
                        </tr>
                        <tr>
                            <th>Jumlah</th>
                            <td>{{ $pesanan->jumlah }}</td>
                        </tr>
                        <tr>
                            <th>Total Harga</th>
                            <td>Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Metode Pembayaran</th>
                            <td>{{ ucfirst($pesanan->metode_pembayaran) }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                <span class="badge bg-info text-dark">{{ ucfirst($pesanan->status) }}</span>
                            </td>
                        </tr>
                        @if ($pesanan->metode_pembayaran === 'transfer')
                            <tr>
                                <th>Bukti Transfer</th>
                                <td>
                                    @if ($pesanan->bukti_transfer)
                                        <img src="{{ asset('storage/' . $pesanan->bukti_transfer) }}" alt="Bukti Transfer"
                                            class="img-thumbnail" style="max-width: 150px; cursor: pointer;"
                                            data-bs-toggle="modal" data-bs-target="#modalBuktiTransfer">
                                    @else
                                        <span class="text-muted">Belum diunggah</span>
                                    @endif
                                </td>
                            </tr>
                        @endif
                        <tr>
                            <th>Tanggal Pesanan</th>
                            <td>{{ $pesanan->created_at->format('d M Y, H:i') }}</td>
                        </tr>
                    </table>

                    <a href="{{ route('pesanan.user.riwayat') }}" class="btn btn-secondary mt-3"><i
                            class="bi bi-arrow-left"></i> Kembali ke Daftar
                        Riwayat Pesanan</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Gambar Produk --}}
    @if ($pesanan->produk && $pesanan->produk->gambar)
        <div class="modal fade" id="modalGambarProduk" tabindex="-1" aria-labelledby="gambarProdukLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-dark">
                    <div class="modal-header border-0">
                        <h5 class="modal-title text-white" id="gambarProdukLabel">Gambar Produk</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center p-4">
                        <img src="{{ asset('storage/' . $pesanan->produk->gambar) }}" class="img-fluid rounded shadow"
                            style="max-height: 80vh;" alt="Gambar Produk">
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if ($pesanan->produk && $pesanan->produk->gambar_belakang)
        <div class="modal fade" id="modalGambarProdukBelakang" tabindex="-1" aria-labelledby="gambarProdukBelakangLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-dark">
                    <div class="modal-header border-0">
                        <h5 class="modal-title text-white" id="gambarProdukBelakangLabel">Gambar Produk Belakang</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center p-4">
                        <img src="{{ asset('storage/' . $pesanan->produk->gambar_belakang) }}"
                            class="img-fluid rounded shadow" style="max-height: 80vh;" alt="Gambar Produk Belakang">
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Modal Desain Depan --}}
    @if ($pesanan->kaosKustom)
        <div class="modal fade" id="modalDesainDepan" tabindex="-1" aria-labelledby="modalDesainDepanLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-dark">
                    <div class="modal-header border-0">
                        <h5 class="modal-title text-white" id="modalDesainDepanLabel">Desain Depan</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center p-4">
                        <img src="{{ asset('storage/' . $pesanan->kaosKustom->desain_depan) }}"
                            class="img-fluid rounded shadow" style="max-height: 80vh;" alt="Desain Depan">
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal Desain Belakang --}}
        <div class="modal fade" id="modalDesainBelakang" tabindex="-1" aria-labelledby="modalDesainBelakangLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-dark">
                    <div class="modal-header border-0">
                        <h5 class="modal-title text-white" id="modalDesainBelakangLabel">Desain Belakang</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center p-4">
                        <img src="{{ asset('storage/' . $pesanan->kaosKustom->desain_belakang) }}"
                            class="img-fluid rounded shadow" style="max-height: 80vh;" alt="Desain Belakang">
                    </div>
                </div>
            </div>
        </div>
    @endif


    <!-- Modal Bukti Transfer -->
    <div class="modal fade" id="modalBuktiTransfer" tabindex="-1" aria-labelledby="buktiTransferLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark">
                <div class="modal-header border-0">
                    <h5 class="modal-title text-white" id="buktiTransferLabel">Bukti Transfer
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body text-center p-4">
                    <img src="{{ asset('storage/' . $pesanan->bukti_transfer) }}" class="img-fluid rounded shadow"
                        style="max-height: 80vh;" alt="Bukti Transfer">
                </div>
            </div>
        </div>
    </div>




@endsection
