@extends('admin.layouts.main')

@section('title', 'Detail Pesanan')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Detail Pesanan</h6>
            <a href="{{ route('admin.pesanan.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">Nama Pemesan</dt>
                <dd class="col-sm-9">{{ $pesanan->user->nama }}</dd>
                <dt class="col-sm-3">Alamat Pemesan</dt>
                <dd class="col-sm-9">{{ $pesanan->user->biodata->alamat_lengkap }}</dd>

                <dt class="col-sm-3">Produk</dt>
                <dd class="col-sm-9">
                    @if ($pesanan->produk)
                        <strong>{{ $pesanan->produk->nama }}</strong>
                        <br>
                        @if ($pesanan->produk->gambar)
                            <img src="{{ asset('storage/' . $pesanan->produk->gambar) }}" alt="Gambar Produk" width="150"
                                class="img-thumbnail mt-2">
                        @endif
                    @elseif ($pesanan->kaosKustom)
                        <strong>Kaos Kustom</strong>
                        <br>
                        <div class="d-flex gap-3 mt-2">
                            <div>
                                <small>Desain Depan</small><br>
                                <img src="{{ asset('storage/' . $pesanan->kaosKustom->desain_depan) }}" alt="Desain Depan"
                                    width="150" class="img-thumbnail mr-2" data-toggle="modal" data-target="#modalDepan">
                            </div>
                            <div>
                                <small>Desain Belakang</small><br>
                                <img src="{{ asset('storage/' . $pesanan->kaosKustom->desain_belakang) }}"
                                    alt="Desain Belakang" width="150" class="img-thumbnail mr-2" data-toggle="modal"
                                    data-target="#modalBelakang">
                            </div>

                        </div>

                        <a href="{{ route('admin.preview.desain', $pesanan->id) }}" target="_blank"
                            class="btn btn-primary mt-2 mb-2"> <i class="fas fa-print"></i>
                            Cetak Desain
                        </a>

                        <!-- Modal Desain Depan -->
                        <div class="modal fade" id="modalDepan" tabindex="-1" role="dialog"
                            aria-labelledby="modalDepanLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-body text-center">
                                        <img src="{{ asset('storage/' . $pesanan->kaosKustom->desain_depan) }}"
                                            class="img-fluid" alt="Desain Depan">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Desain Belakang -->
                        <div class="modal fade" id="modalBelakang" tabindex="-1" role="dialog"
                            aria-labelledby="modalBelakangLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-body text-center">
                                        <img src="{{ asset('storage/' . $pesanan->kaosKustom->desain_belakang) }}"
                                            class="img-fluid" alt="Desain Belakang">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <em>Tidak ada informasi produk.</em>
                    @endif
                </dd>


                <dt class="col-sm-3">Ukuran</dt>
                <dd class="col-sm-9">{{ $pesanan->ukuran }}</dd>

                <dt class="col-sm-3">Jumlah</dt>
                <dd class="col-sm-9">{{ $pesanan->jumlah }}</dd>

                <dt class="col-sm-3">Total Harga</dt>
                <dd class="col-sm-9">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</dd>

                <dt class="col-sm-3">Metode Pembayaran</dt>
                <dd class="col-sm-9">{{ ucfirst($pesanan->metode_pembayaran) }}</dd>

                @if ($pesanan->metode_pembayaran === 'transfer' && $pesanan->rekening)
                    <dt class="col-sm-3">Bukti Transfer</dt>
                    <dd class="col-sm-9">
                        <a class="btn btn-primary" style="cursor: pointer" data-toggle="modal"
                            data-target="#modalBuktiTransfer">Lihat Bukti</a>

                        <!-- Modal Bukti Transfer -->
                        <div class="modal fade" id="modalBuktiTransfer" tabindex="-1" role="dialog"
                            aria-labelledby="buktiTransferLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-body text-center">
                                        <img src="{{ asset('storage/' . $pesanan->bukti_transfer) }}" class="img-fluid"
                                            alt="Bukti Transfer">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </dd>
                    <dt class="col-sm-3">Rekening Tujuan</dt>
                    <dd class="col-sm-9">
                        {{ $pesanan->rekening->nama_bank }}<br>
                        No. Rek: {{ $pesanan->rekening->no_rek }}<br>
                        A.n. {{ $pesanan->rekening->atas_nama }}

                    </dd>
                @endif


                <dt class="col-sm-3">Status</dt>
                <dd class="col-sm-9">
                    @if (!in_array($pesanan->status, ['selesai', 'dibatalkan']))
                        <form action="{{ route('admin.pesanan.updateStatus', $pesanan->id) }}" method="POST"
                            class="form-inline d-flex align-items-center gap-2">
                            @csrf
                            @method('PUT')
                            <select name="status" class="form-control mr-2">
                                @foreach (['menunggu', 'diproses', 'dikirim'] as $status)
                                    <option value="{{ $status }}"
                                        {{ $pesanan->status === $status ? 'selected' : '' }}>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-primary btn-sm">Update</button>
                        </form>
                    @else
                        @if ($pesanan->status == 'dibatalkan')
                            <span class="badge badge-danger">{{ ucfirst($pesanan->status) }}</span>
                            <br>
                            <small class="text-muted">Status tidak dapat diubah.</small>
                        @elseif ($pesanan->status == 'selesai')
                            <span class="badge badge-success">{{ ucfirst($pesanan->status) }}</span>
                            <br>
                            <small class="text-muted">Status tidak dapat diubah.</small>
                        @endif
                    @endif
                </dd>

            </dl>

            <hr>
            <h6 class="fw-bold mt-4 mb-3">Ulasan Pemesan</h6>

            @if ($pesanan->ulasan)
                <div class="border p-3 rounded">
                    <div class="mb-2 d-flex align-items-center">
                        <strong class="me-2 mr-2">Rating:</strong>
                        <div class="text-warning">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= (int) $pesanan->ulasan->rating)
                                    <i class="fas fa-star"></i>
                                @else
                                    <i class="far fa-star"></i>
                                @endif
                            @endfor
                        </div>
                        <span class="text-muted ms-2 ml-3">({{ $pesanan->ulasan->rating }} dari 5)</span>
                    </div>

                    @if ($pesanan->ulasan->komentar)
                        <p class="mt-2"><strong>Komentar:</strong><br> {{ $pesanan->ulasan->komentar }}</p>
                    @endif

                    @if ($pesanan->ulasan->gambar->count())
                        <div class="d-flex flex-wrap gap-2 mt-3">
                            @foreach ($pesanan->ulasan->gambar as $img)
                                <img src="{{ asset('storage/' . $img->gambar) }}" alt="Gambar Ulasan"
                                    class="img-thumbnail" style="max-width: 120px;">
                            @endforeach
                        </div>
                    @endif
                </div>
            @elseif (!$pesanan->produk)
            @else
                <div class="alert alert-info">
                    Pemesan belum memberikan ulasan untuk pesanan ini.
                </div>
            @endif


        </div>
    </div>
@endsection
