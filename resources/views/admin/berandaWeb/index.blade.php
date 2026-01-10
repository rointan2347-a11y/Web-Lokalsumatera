@extends('admin.layouts.main')

@section('title')
    Beranda Web
@endsection

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Konfigurasi Beranda Web</h6>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show m-3" role="alert" id="success-alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 50px;">No.</th>
                            <th>Judul</th>
                            <th>Deskripsi</th>
                            <th style="width: 120px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($berandaWeb)
                            <tr>
                                <td>1</td>
                                <td>{{ $berandaWeb->judul ?? '-' }}</td>
                                <td>{{ \Illuminate\Support\Str::limit($berandaWeb->deskripsi, 100, '...') }}</td>
                                <td>
                                    <a href="{{ route('admin.berandaWeb.edit', $berandaWeb->id) }}"
                                        class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                </td>
                            </tr>
                        @else
                            <tr>
                                <td colspan="4" class="text-center text-muted">Belum ada data konfigurasi beranda.</td>
                            </tr>
                        @endif
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
