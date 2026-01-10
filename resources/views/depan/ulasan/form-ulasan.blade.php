@extends('depan.layouts.main')

@section('title', 'Beri Ulasan')

@section('content')
    <div class="container py-5">
        <div class="row">
            @include('depan.dashboard-menu.sidebar')

            <div class="col-md-9">
                <div class="card shadow-sm p-4">
                    <h4 class="mb-4">Beri Ulasan untuk Produk</h4>

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert" id="pesan-alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="mb-4">
                        <strong>Produk:</strong> {{ $pesanan->produk->nama }} <br>
                        <strong>Tanggal Pesanan:</strong> {{ $pesanan->created_at->format('d M Y, H:i') }}
                    </div>

                    <form action="{{ route('ulasan.form.store', $pesanan->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-bold">Upload Gambar Produk (opsional)</label>
                            <div id="gambar-input-group">
                                <div class="input-group mb-2">
                                    <input type="file" name="gambar[]" class="form-control" accept="image/*"
                                        onchange="previewSingleImage(event, 0)">
                                    <button type="button" class="btn btn-danger btn-sm ms-2"
                                        onclick="hapusInputGambar(this, 0)">Hapus</button>
                                </div>
                            </div>
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="tambahInputGambar()">+
                                Tambah Gambar</button>
                            <small class="text-muted d-block mt-2">
                                Bisa unggah lebih dari satu gambar. Jika terjadi kesalahan pada form, silakan unggah ulang
                                semua gambar.
                            </small>
                            @error('gambar.*')
                                <div class="text-danger small mt-1">
                                    Ada kesalahan pada input gambar. Silakan pilih ulang gambar dan pastikan format file benar.
                                </div>
                            @enderror

                            <div class="mt-3 d-flex flex-wrap gap-3" id="preview-container"></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Rating</label>
                            <div id="star-rating" class="mb-2">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="bi {{ old('rating') >= $i ? 'bi-star-fill text-warning' : 'bi-star' }}"
                                        style="font-size: 1.5rem; cursor: pointer;" data-value="{{ $i }}"></i>
                                @endfor
                            </div>
                            <input type="hidden" name="rating" id="rating" value="{{ old('rating') }}">
                            @error('rating')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="komentar" class="form-label fw-bold">Komentar</label>
                            <textarea name="komentar" id="komentar" class="form-control" rows="4" placeholder="Tulis ulasan Anda...">{{ old('komentar') }}</textarea>
                            @error('komentar')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-dark"><i class="bi bi-star"></i> Kirim Ulasan</button>
                        <a href="{{ route('pesanan.user.riwayat') }}" class="btn btn-outline-secondary ms-2"><i
                                class="bi bi-arrow-left"></i> Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        let indexGambar = 1;

        function tambahInputGambar() {
            const group = document.getElementById('gambar-input-group');
            const wrapper = document.createElement('div');
            wrapper.classList.add('input-group', 'mb-2');
            wrapper.innerHTML = `
            <input type="file" name="gambar[]" class="form-control" accept="image/*" onchange="previewSingleImage(event, ${indexGambar})">
            <button type="button" class="btn btn-danger btn-sm ms-2" onclick="hapusInputGambar(this, ${indexGambar})">Hapus</button>
        `;
            group.appendChild(wrapper);
            indexGambar++;
        }

        function hapusInputGambar(button, index) {
            const inputGroup = button.closest('.input-group');
            inputGroup.remove();
            const preview = document.querySelector(`#preview-container img[data-index="${index}"]`);
            if (preview) preview.remove();
        }

        function previewSingleImage(event, index) {
            const file = event.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('img-thumbnail');
                img.style.maxWidth = '120px';
                img.style.marginRight = '10px';
                img.setAttribute('data-index', index);

                // Hapus preview lama jika ada
                document.querySelectorAll(`#preview-container img[data-index="${index}"]`).forEach(el => el.remove());
                document.getElementById('preview-container').appendChild(img);
            };
            reader.readAsDataURL(file);
        }

        // Rating Bintang
        document.addEventListener('DOMContentLoaded', function() {
            const stars = document.querySelectorAll('#star-rating .bi');
            const ratingInput = document.getElementById('rating');

            stars.forEach(star => {
                star.addEventListener('click', function() {
                    const rating = this.getAttribute('data-value');
                    ratingInput.value = rating;
                    updateStars(rating);
                });
            });

            function updateStars(rating) {
                stars.forEach(s => {
                    if (s.getAttribute('data-value') <= rating) {
                        s.classList.remove('bi-star');
                        s.classList.add('bi-star-fill', 'text-warning');
                    } else {
                        s.classList.remove('bi-star-fill', 'text-warning');
                        s.classList.add('bi-star');
                    }
                });
            }

            // Set bintang dari old() Laravel saat reload error
            const oldRating = "{{ old('rating') }}";
            if (oldRating) {
                ratingInput.value = oldRating;
                updateStars(oldRating);
            }
        });
    </script>

@endsection
