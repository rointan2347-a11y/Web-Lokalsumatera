@extends('admin.layouts.main')

@section('title')
    Tambah Rekening
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Tambah Rekening</h6>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('rekening.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="atas_nama">Atas Nama</label>
                            <input type="text" class="form-control @error('atas_nama') is-invalid @enderror"
                                id="atas_nama" name="atas_nama" value="{{ old('atas_nama') }}"
                                placeholder="Masukkan nama pemilik rekening" required>
                            @error('atas_nama')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="nama_bank">Nama Bank</label>
                            <input type="text" class="form-control @error('nama_bank') is-invalid @enderror"
                                id="nama_bank" name="nama_bank" value="{{ old('nama_bank') }}" placeholder="Contoh:BNI"
                                required>
                            @error('nama_bank')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="no_rek">No. Rekening</label>
                            <input type="number" class="form-control @error('no_rek') is-invalid @enderror" id="no_rek"
                                name="no_rek" value="{{ old('no_rek') }}" placeholder="Masukkan nomor rekening" required>
                            @error('no_rek')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                        <a href="{{ route('rekening.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
