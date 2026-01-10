@extends('admin.layouts.main')

@section('title', 'Detail Pengguna')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Detail Pengguna</h6>
            <a href="{{ route('admin.user.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="card-body">
            <h5>Informasi Pengguna</h5>
            <dl class="row">
                <dt class="col-sm-3">Nama</dt>
                <dd class="col-sm-9">{{ $user->nama }}</dd>

                <dt class="col-sm-3">Email</dt>
                <dd class="col-sm-9">{{ $user->email }}</dd>

                <dt class="col-sm-3">No. HP</dt>
                <dd class="col-sm-9">{{ $user->biodata->no_hp ?? '-' }}</dd>

                <dt class="col-sm-3">Alamat</dt>
                <dd class="col-sm-9">{{ $user->biodata->alamat_lengkap ?? '-' }}</dd>
            </dl>

            <hr>

            <h5>Riwayat Pesanan</h5>
            @if ($user->pesanan->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Produk / Kustom</th>
                                <th>Jumlah</th>
                                <th>Total Harga</th>
                                <th>Status</th>
                                <th>Bukti Transfer</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user->pesanan as $pesanan)
                                <tr>
                                    <td>{{ $pesanan->created_at->format('d-m-Y') }}</td>
                                    <td>
                                        @if ($pesanan->produk)
                                            {{ $pesanan->produk->nama }}
                                        @elseif ($pesanan->kaosKustom)
                                            Kaos Kustom
                                            <br>
                                            <a href="{{ asset('storage/' . $pesanan->kaosKustom->desain_depan) }}"
                                                target="_blank">
                                                <img src="{{ asset('storage/' . $pesanan->kaosKustom->desain_depan) }}"
                                                    width="80" class="img-thumbnail mt-1">
                                            </a>
                                            <a href="{{ asset('storage/' . $pesanan->kaosKustom->desain_belakang) }}"
                                                target="_blank">
                                                <img src="{{ asset('storage/' . $pesanan->kaosKustom->desain_belakang) }}"
                                                    width="80" class="img-thumbnail mt-1">
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ $pesanan->jumlah }}</td>
                                    <td>Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                                    <td>
                                        @switch($pesanan->status)
                                            @case('menunggu')
                                                <span class="badge badge-warning">Menunggu</span>
                                            @break

                                            @case('diproses')
                                                <span class="badge badge-primary">Diproses</span>
                                            @break

                                            @case('dikirim')
                                                <span class="badge badge-info">Dikirim</span>
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
                                        @if ($pesanan->bukti_transfer)
                                            <button class="btn btn-sm btn-outline-primary" data-toggle="modal"
                                                data-target="#modalBukti{{ $pesanan->id }}">
                                                Lihat
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="modalBukti{{ $pesanan->id }}" tabindex="-1"
                                                role="dialog" aria-labelledby="modalLabel{{ $pesanan->id }}"
                                                aria-hidden="true">
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
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted">Pengguna ini belum memiliki pesanan.</p>
            @endif
        </div>
    </div>
@endsection
