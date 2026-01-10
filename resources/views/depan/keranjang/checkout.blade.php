@extends('depan.layouts.main')

@section('title', $item->kaosKustom ? 'Checkout Kaos Kustom' : 'Checkout Produk')

@section('content')
    <div class="container py-5">
        <h2 class="fw-bold mb-4">
            {{ $item->kaosKustom ? 'Checkout Kaos Kustom' : 'Checkout Produk' }}
        </h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger" id="pesan-alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @php
            $isKustom = $item->kaos_kustom_id !== null;
            $produk = $isKustom ? $item->kaosKustom : $item->produk;
            $namaProduk = $isKustom ? $produk->judul ?? 'Kaos Kustom' : $produk->nama;
            $harga = $isKustom ? $produk->harga ?? 0 : $produk->harga_diskon ?? $produk->harga;
            $jumlah = $item->jumlah;
            $subtotal = $harga * $jumlah;
            $maxStok = $isKustom ? 99 : $produk->stok;
        @endphp

        <form action="{{ route('checkout.proses', $item->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <!-- Gambar Produk/Desain -->
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <h5 class="fw-bold mb-3">Pratinjau</h5>
                            @if ($isKustom)
                                <img src="{{ asset('storage/' . $produk->desain_depan) }}" alt="Desain Depan"
                                    class="img-fluid mb-3 rounded shadow">
                                <img src="{{ asset('storage/' . $produk->desain_belakang) }}" alt="Desain Belakang"
                                    class="img-fluid rounded shadow">
                            @else
                                @if ($produk->gambar && !$produk->gambar_belakang)
                                    <img src="{{ asset('storage/' . $produk->gambar) }}" alt="Gambar Produk Depan"
                                        class="img-fluid mb-3 rounded shadow">
                                @endif
                                @if ($produk->gambar && $produk->gambar_belakang)
                                    <img src="{{ asset('storage/' . $produk->gambar) }}" alt="Gambar Produk Depan"
                                        class="img-fluid mb-3 rounded shadow">
                                    <img src="{{ asset('storage/' . $produk->gambar_belakang) }}"
                                        alt="Gambar Produk Belakang" class="img-fluid rounded shadow">
                                @endif
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Form Detail -->
                <div class="col-md-8">
                    <div class="card shadow-sm p-4">
                        <h5 class="fw-bold mb-3">Detail Pemesanan</h5>

                        <div class="mb-3">
                            <label class="form-label">Nama Produk</label>
                            <input type="text" class="form-control" value="{{ $namaProduk }}" disabled>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="jumlah" class="form-label">Jumlah</label>
                                <input type="number" name="jumlah" id="jumlah" class="form-control"
                                    value="{{ $jumlah }}" min="1" max="{{ $maxStok }}"
                                    oninput="updateSubtotal()">
                                @error('jumlah')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Ukuran</label>
                                <select name="ukuran" class="form-select" required>
                                    @foreach (['S', 'M', 'L', 'XL', 'XXL', 'XXXL'] as $ukuran)
                                        <option value="{{ $ukuran }}"
                                            {{ $item->ukuran === $ukuran ? 'selected' : '' }}>{{ $ukuran }}</option>
                                    @endforeach
                                </select>
                                @error('ukuran')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Harga Satuan</label>
                            <input type="text" class="form-control" value="Rp {{ number_format($harga, 0, ',', '.') }}"
                                disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Subtotal</label>
                            <input type="text" class="form-control fw-bold" id="subtotal"
                                value="Rp {{ number_format($subtotal, 0, ',', '.') }}" disabled>
                        </div>

                        @if ($biodata)
                            <div class="alert alert-warning">
                                <strong>Pastikan nomor telepon dan alamat lengkap kamu sudah benar!</strong><br>
                                <ul class="mb-0 mt-2">
                                    <li><strong>Nomor HP:</strong> {{ $biodata->telepon }}</li>
                                    <li><strong>Alamat:</strong> {{ $biodata->alamat_lengkap }}</li>
                                </ul>
                                <a href="{{ route('profile.show') }}" class="btn btn-sm btn-outline-primary mt-2">Perbarui
                                    Data</a>
                            </div>
                        @else
                            <div class="alert alert-danger">
                                <strong>Kamu belum mengisi biodata lengkap!</strong> Harap lengkapi terlebih dahulu untuk
                                melanjutkan checkout.
                                <br>
                                <a href="{{ route('profil.show') }}" class="btn btn-sm btn-outline-danger mt-2">Lengkapi
                                    Sekarang</a>
                            </div>
                        @endif
                        
                        <!-- Tombol Hubungi Admin -->
        <a href="https://wa.me/6282377885282?text=Halo%20Admin%2C%20saya%20ingin%20bertanya%20tentang%20pesanan%20produk%20{{ urlencode($namaProduk) }}%20dengan%20jumlah%20{{ $jumlah }}%20dan%20ukuran%20{{ $item->ukuran }}"
           target="_blank"
           class="btn btn-success w-100 mt-3">
            <i class="bi bi-whatsapp"></i> Hubungi Admin
        </a>

                        <hr class="my-4">

                        <h5 class="fw-bold mb-3">Metode Pembayaran</h5>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="metode_pembayaran" id="transfer"
                                value="transfer" checked>
                            <label class="form-check-label" for="transfer">Transfer Bank (Upload Bukti Transfer)</label>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="metode_pembayaran" id="cod"
                                value="cod">
                            <label class="form-check-label" for="cod">COD (Cash on Delivery)</label>
                        </div>

                        <div id="info-rekening" class="mb-3">
                            <label class="form-label fw-bold">Pilih Rekening Tujuan</label>
                            @foreach ($rekeningList as $rekening)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="rekening_id"
                                        id="rek{{ $rekening->id }}" value="{{ $rekening->id }}" required>
                                    <label class="form-check-label" for="rek{{ $rekening->id }}">
                                        {{ $rekening->nama_bank }} - {{ $rekening->no_rek }} (a.n.
                                        {{ $rekening->atas_nama }})
                                    </label>
                                </div>
                            @endforeach
                            @error('rekening_id')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div id="bukti-transfer" class="mb-3">
                            <label for="bukti_transfer" class="form-label">Upload Bukti Transfer</label>
                            <input type="file" class="form-control" name="bukti_transfer" id="bukti_transfer">
                        </div>
                        <div class="d-flex">
                            <a href="{{ route('keranjang.index') }}" class="btn btn-outline-secondary me-2"><i
                                    class="bi bi-arrow-left"></i> Kembali ke
                                Keranjang</a>
                            <button type="submit" class="btn btn-outline-dark"><i class="bi bi-cart-check"></i> Proses
                                Checkout</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

@section('scripts')
    <script>
        const metodePembayaran = document.querySelectorAll('input[name="metode_pembayaran"]');
        const buktiTransfer = document.getElementById('bukti-transfer');
        const infoRekening = document.getElementById('info-rekening');

        function toggleTransferElements(value) {
            const isTransfer = value === 'transfer';
            buktiTransfer.style.display = isTransfer ? 'block' : 'none';
            infoRekening.style.display = isTransfer ? 'block' : 'none';

            // Aktifkan / nonaktifkan atribut required untuk radio rekening_id
            document.querySelectorAll('input[name="rekening_id"]').forEach(input => {
                input.required = isTransfer;
            });

            // Jika metode bukan transfer, kosongkan input file bukti transfer
            if (!isTransfer) {
                document.getElementById('bukti_transfer').value = "";
            }
        }

        metodePembayaran.forEach((radio) => {
            radio.addEventListener('change', function() {
                toggleTransferElements(this.value);
            });
        });

        // Jalankan saat pertama kali load halaman
        toggleTransferElements(document.querySelector('input[name="metode_pembayaran"]:checked').value);

        function updateSubtotal() {
            const jumlah = parseInt(document.getElementById('jumlah').value) || 0;
            const harga = {{ $harga }};
            const subtotal = jumlah * harga;

            const formatter = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            });

            document.getElementById('subtotal').value = formatter.format(subtotal);
        }
    </script>

@endsection
@endsection
