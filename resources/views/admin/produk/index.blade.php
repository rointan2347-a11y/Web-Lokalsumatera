@extends('admin.layouts.main')
@section('title')
    Data Produk
@endsection
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">List Produk</h6>

            <a href="/admin/produk/create" class="btn btn-primary btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Tambah Produk</span>
            </a>

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
            <div class="table-responsive">
                <table class="table table-hover table-borderless" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Gambar</th>
                            <th>Nama Produk</th>
                            <th>Stok</th>
                            <th>Deskripsi</th>
                            <th>Harga</th>
                            <th>Harga Diskon</th>
                            <th>Rating</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($produk as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if ($item->gambar)
                                        <img src="{{ asset('storage/' . $item->gambar) }}" alt="Gambar Produk"
                                            width="100" class="img-thumbnail">
                                    @else
                                        <img src="{{ asset('img/lokal1.jpg') }}" width="100" alt="Produk"
                                            class="img-thumbnail">
                                    @endif
                                </td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->stok }}</td>
                                <td>{{ \Illuminate\Support\Str::words(strip_tags($item->deskripsi), 15, '...') }}</td>
                                <td>{{ $item->harga }}</td>
                                <td>{{ $item->harga_diskon }}</td>
                                <td>
                                    @if ($item->ulasan->count())
                                        @php
                                            $avgRating = round($item->ulasan->avg('rating'), 1);
                                        @endphp
                                        <span class="text-warning">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i
                                                    class="fas {{ $i <= $avgRating ? 'fa-star' : 'fa-star text-muted' }}"></i>
                                            @endfor
                                        </span>
                                        <br>
                                        <small>{{ $avgRating }} dari 5 ({{ $item->ulasan->count() }} ulasan)</small>
                                    @else
                                        <em class="text-muted">Belum ada ulasan</em>
                                    @endif
                                </td>

                                <td>

                                    <a href="{{ route('produk.show', $item->id) }}"
                                        class="btn btn-info btn-icon-split mb-2">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-eye"></i>
                                        </span>
                                        <span class="text">Lihat Detail</span>
                                    </a>

                                    <a href="{{ route('produk.edit', $item->id) }}"
                                        class="btn btn-primary btn-icon-split mb-2">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-edit"></i>
                                        </span>
                                        <span class="text">Edit</span>
                                    </a>

                                    <form action="{{ route('produk.destroy', $item->id) }}" method="POST"
                                        style="display: inline-block;"
                                        onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-icon-split mb-2">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-trash"></i>
                                            </span>
                                            <span class="text">Hapus</span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            // Tunggu 3 detik (3000ms), lalu sembunyikan alert dengan animasi fadeOut
            setTimeout(function() {
                $("#success-alert").fadeOut('slow');
            }, 3000);
        });
    </script>
@endsection
