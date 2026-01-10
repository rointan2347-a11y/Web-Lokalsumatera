@extends('admin.layouts.main')
@section('title')
    Tambah Produk
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8">

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Tambah Produk</h6>
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

                    <!-- AI WIZARD CARD -->
                    <div class="card bg-gradient-light border-left-warning shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="font-weight-bold text-warning mb-3"><i class="fas fa-magic mr-2"></i>AI Product Wizard</h5>
                            <p class="small text-muted mb-2">Bingung bikin kata-kata? Ketik konsep produknya, biar AI yang tulis deskripsi & kasih harga!</p>
                            
                            <div class="input-group">
                                <input type="text" id="aiKonsep" class="form-control" placeholder="Contoh: Kaos Hitam Palembang tema Ampera, bahan adem...">
                                <div class="input-group-append">
                                    <button class="btn btn-warning text-white" type="button" onclick="generateMagic()">
                                        <i class="fas fa-bolt mr-1"></i> Generate Magic
                                    </button>
                                </div>
                            </div>
                            <small class="text-danger mt-1 d-none" id="aiError">*Masukkan konsep dulu dong bos!</small>
                            <div id="aiLoading" class="mt-2 d-none">
                                <div class="spinner-border spinner-border-sm text-warning" role="status"></div> 
                                <span class="small text-muted ml-2">AI lagi mikir keras... (Sabarrr)</span>
                            </div>
                        </div>
                    </div>
                    <!-- END AI WIZARD -->

                    <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="nama">Nama Produk</label>
                            <input type="text" name="nama" id="nama"
                                class="form-control @error('nama') is-invalid @enderror" placeholder="Masukkan nama produk"
                                value="{{ old('nama') }}">
                            @error('nama')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="stok">Stok Produk</label>
                            <input type="number" name="stok" id="stok"
                                class="form-control @error('stok') is-invalid @enderror" placeholder="Masukkan stok produk"
                                value="{{ old('stok') }}">
                            @error('stok')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror"
                                placeholder="Masukkan deskripsi produk">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="harga">Harga</label>
                            <input type="number" name="harga" id="harga"
                                class="form-control @error('harga') is-invalid @enderror"
                                placeholder="Masukkan harga produk" value="{{ old('harga') }}">
                            @error('harga')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="harga_diskon">Harga Diskon (Opsional)</label>
                            <input type="number" name="harga_diskon" id="harga_diskon"
                                class="form-control @error('harga_diskon') is-invalid @enderror"
                                placeholder="Masukkan harga diskon" value="{{ old('harga_diskon') }}">
                            @error('harga_diskon')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <hr>
                        <h6 class="font-weight-bold text-primary mb-3">Metadata Produk (Warna & Ketebalan)</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="warna">Warna Kaos</label>
                                    <select name="warna" id="warna" class="form-control @error('warna') is-invalid @enderror">
                                        <option value="">-- Pilih Warna --</option>
                                        <option value="Hitam" {{ old('warna') == 'Hitam' ? 'selected' : '' }}>Hitam</option>
                                        <option value="Putih" {{ old('warna') == 'Putih' ? 'selected' : '' }}>Putih</option>
                                    </select>
                                    @error('warna')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ketebalan">Ketebalan Bahan</label>
                                    <select name="ketebalan" id="ketebalan" class="form-control @error('ketebalan') is-invalid @enderror">
                                        <option value="">-- Pilih Ketebalan --</option>
                                        <option value="16s" {{ old('ketebalan') == '16s' ? 'selected' : '' }}>16s (Tipis)</option>
                                        <option value="24s" {{ old('ketebalan') == '24s' ? 'selected' : '' }}>24s (Sedang Tebal)</option>
                                        <option value="30s" {{ old('ketebalan') == '30s' ? 'selected' : '' }}>30s (Standar Distro)</option>
                                    </select>
                                    @error('ketebalan')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="gambar">Gambar Produk Depan <span class="text-danger">*</span></label>
                            <input type="file" name="gambar" id="gambar"
                                class="form-control-file @error('gambar') is-invalid @enderror" required>
                            @error('gambar')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Tombol untuk menampilkan input gambar belakang --}}
                        <div class="form-group">
                            <button type="button" class="btn btn-outline-warning btn-sm" onclick="toggleGambarBelakang()">
                                <i class="fas fa-plus"></i> Tambah Gambar Belakang
                            </button>
                        </div>

                        {{-- Input gambar belakang (disembunyikan dulu) --}}
                        <div class="form-group" id="gambarBelakangField" style="display: none;">
                            <label for="gambar_belakang">Gambar Produk Belakang (Opsional)</label>
                            <input type="file" name="gambar_belakang" id="gambar_belakang"
                                class="form-control-file @error('gambar_belakang') is-invalid @enderror">
                            @error('gambar_belakang')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                        <a href="{{ route('produk.index') }}" class="btn btn-secondary">
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

        function generateMagic() {
            const konsep = document.getElementById('aiKonsep').value;
            const warna = document.getElementById('warna').value;

            if(!konsep) {
                document.getElementById('aiError').classList.remove('d-none');
                return;
            }
            document.getElementById('aiError').classList.add('d-none');
            
            // Show Loading
            document.getElementById('aiLoading').classList.remove('d-none');
            
            // Disable Inputs
            document.getElementById('nama').setAttribute('disabled', true);
            document.getElementById('deskripsi').setAttribute('disabled', true);
            document.getElementById('harga').setAttribute('disabled', true);

            fetch('{{ route("admin.produk.generateAi") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    keyword: konsep,
                    warna: warna
                })
            })
            .then(res => res.json())
            .then(data => {
                document.getElementById('aiLoading').classList.add('d-none');
                
                // Enable Inputs
                document.getElementById('nama').removeAttribute('disabled');
                document.getElementById('deskripsi').removeAttribute('disabled');
                document.getElementById('harga').removeAttribute('disabled');

                if(data.status === 'success') {
                    // Typewriter Effect (Optional, direct fill for speed)
                    document.getElementById('nama').value = data.data.nama;
                    document.getElementById('deskripsi').value = data.data.deskripsi;
                    document.getElementById('harga').value = data.data.harga;
                    
                    // Flash success effect
                    document.getElementById('nama').classList.add('is-valid');
                    setTimeout(() => document.getElementById('nama').classList.remove('is-valid'), 2000);
                } else {
                    alert('Gagal: ' + data.message);
                }
            })
            .catch(err => {
                document.getElementById('aiLoading').classList.add('d-none');
                document.getElementById('nama').removeAttribute('disabled');
                document.getElementById('deskripsi').removeAttribute('disabled');
                document.getElementById('harga').removeAttribute('disabled');
                alert('Terkendala koneksi AI');
            });
        }
    </script>
@endsection
