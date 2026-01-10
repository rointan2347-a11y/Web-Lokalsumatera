@extends('depan.layouts.main')

@section('title', 'Ulasan Saya')

@section('content')
    <div class="container py-5">
        <div class="row">
            @include('depan.dashboard-menu.sidebar')

            <div class="col-md-9">
                <div class="card shadow-sm p-4">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert" id="pesan-alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <h5 class="mb-4">Ulasan Saya</h5>

                    @if ($ulasanList->count())
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>Produk</th>
                                        <th>Rating</th>
                                        <th>Komentar</th>
                                        <th>Gambar</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ulasanList as $ulasan)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $ulasan->produk->nama ?? '-' }}</td>
                                            <td>
                                                <div class="text-warning">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($i <= $ulasan->rating)
                                                            <i class="bi bi-star-fill"></i>
                                                        @else
                                                            <i class="bi bi-star"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                            </td>
                                            <td>{{ $ulasan->komentar ?? '-' }}</td>
                                            <td>
                                                @if ($ulasan->gambar->count())
                                                    <div class="d-flex flex-wrap gap-2">
                                                        @foreach ($ulasan->gambar as $img)
                                                            <img src="{{ asset('storage/' . $img->gambar) }}"
                                                                class="img-thumbnail" style="max-width: 80px;"
                                                                alt="Gambar Ulasan">
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <em class="text-muted">-</em>
                                                @endif
                                            </td>
                                            <td>{{ $ulasan->created_at->format('d M Y, H:i') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            Anda belum memberikan ulasan produk apa pun.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
