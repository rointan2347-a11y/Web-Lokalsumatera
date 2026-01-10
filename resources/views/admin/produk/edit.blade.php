@extends('admin.layouts.main')
@section('title')
    Edit Produk
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8">

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Edit Produk</h6>
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

                    <form action="/admin/produk/{{ $produk->id }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="nama">Nama Produk</label>
                            <input type="text" name="nama" id="nama" class="form-control"
                                value="{{ old('nama', $produk->nama) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="stok">Stok Produk</label>
                            <input type="number" name="stok" id="stok"
                                class="form-control @error('stok') is-invalid @enderror" placeholder="Masukkan stok produk"
                                value="{{ old('stok', $produk->stok) }}">
                        </div>

                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" class="form-control" required>{{ old('deskripsi', $produk->deskripsi) }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="harga">Harga</label>
                            <input type="number" name="harga" id="harga" class="form-control"
                                value="{{ old('harga', $produk->harga) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="harga_diskon">Harga Diskon</label>
                            <input type="number" name="harga_diskon" id="harga_diskon" class="form-control"
                                value="{{ old('harga_diskon', $produk->harga_diskon) }}">
                        </div>

                        <hr>
                        <h6 class="font-weight-bold text-primary mb-3">Metadata Produk (Warna & Ketebalan)</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="warna">Warna Kaos</label>
                                    <select name="warna" id="warna" class="form-control">
                                        <option value="">-- Pilih Warna --</option>
                                        <option value="Hitam" {{ old('warna', $produk->warna) == 'Hitam' ? 'selected' : '' }}>Hitam</option>
                                        <option value="Putih" {{ old('warna', $produk->warna) == 'Putih' ? 'selected' : '' }}>Putih</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ketebalan">Ketebalan Bahan</label>
                                    <select name="ketebalan" id="ketebalan" class="form-control">
                                        <option value="">-- Pilih Ketebalan --</option>
                                        <option value="16s" {{ old('ketebalan', $produk->ketebalan) == '16s' ? 'selected' : '' }}>16s (Tipis)</option>
                                        <option value="24s" {{ old('ketebalan', $produk->ketebalan) == '24s' ? 'selected' : '' }}>24s (Sedang Tebal)</option>
                                        <option value="30s" {{ old('ketebalan', $produk->ketebalan) == '30s' ? 'selected' : '' }}>30s (Standar Distro)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="gambar">Gambar Produk</label><br>
                            @if ($produk->gambar)
                                <img src="{{ asset('storage/' . $produk->gambar) }}" alt="Gambar Produk" width="100"
                                    class="mb-2">
                            @endif
                            <input type="file" name="gambar" id="gambar" class="form-control-file">
                        </div>

                        {{-- Tombol toggle gambar belakang --}}
                        <div class="form-group">
                            <button type="button" class="btn btn-outline-secondary btn-sm"
                                onclick="toggleGambarBelakang()">
                                <i class="fas fa-image"></i> Tambah / Ubah Gambar Belakang
                            </button>
                        </div>

                        {{-- Preview dan upload gambar belakang --}}
                        <div class="form-group" id="gambarBelakangField" style="display: none;">
                            @if ($produk->gambar_belakang)
                                <img src="{{ asset('storage/' . $produk->gambar_belakang) }}" alt="Gambar Belakang"
                                    width="100" class="mb-2 d-block">
                            @endif
                            <label for="gambar_belakang">Gambar Produk Belakang (Opsional)</label>
                            <input type="file" name="gambar_belakang" id="gambar_belakang" class="form-control-file">
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Pembaruan
                        </button>
                        <a href="/admin/produk" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('scripts')
    <script>
        function toggleGambarBelakang() {
            const field = document.getElementById('gambarBelakangField');
            field.style.display = field.style.display === 'none' ? 'block' : 'none';
        }
    </script>
@endsection
