@extends('depan.layouts.main')

@section('content')
    <div class="container py-5">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="mb-4">Lengkapi Biodata Anda</h4>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('warning'))
                        <div class="alert alert-warning">
                            {{ session('warning') }}
                        </div>
                    @endif

                    <form action="{{ route('biodata.simpan') }}" method="POST">
                        @csrf

                        <!-- Nama dari tabel user -->
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" name="nama" value="{{ old('nama', auth()->user()->nama) }}"
                                class="form-control" placeholder="masukkan nama lengkap anda..." required>
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                                class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-select" required>
                                <option value="" disabled selected>Pilih jenis kelamin</option>
                                <option value="Laki - laki" {{ old('jenis_kelamin') == 'Laki - laki' ? 'selected' : '' }}>
                                    Laki - laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>
                                    Perempuan</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="telepon" class="form-label">Telepon</label>
                            <input type="text" name="telepon" value="{{ old('telepon') }}"
                                placeholder="masukkan nomor hp/wa aktif" class="form-control" required>
                            <div class="form-text text-danger mt-1">
                                *silahkan untuk memasukkan nomor hp/wa yang aktif ya!. Dan pastikan nomornya sudah benar!.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="alamat_lengkap" class="form-label">Alamat Lengkap</label>
                            <textarea name="alamat_lengkap" class="form-control" rows="3" placeholder="masukkan alamat lengkap anda...."
                                required>{{ old('alamat_lengkap') }}</textarea>
                            <div class="form-text text-danger mt-1">
                                *Alamat ini akan digunakan sebagai alamat rumah untuk pengantaran nantinya, pastikan ditulis
                                dengan lengkap dan benar!.
                            </div>
                        </div>


                        <button type="submit" class="btn btn-danger w-100">Simpan Biodata</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
