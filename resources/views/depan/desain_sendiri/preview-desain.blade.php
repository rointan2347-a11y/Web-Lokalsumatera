@extends('depan.layouts.main')

@section('title')
    Preview Desain
@endsection

@section('content')
    <style>
        .judul-halaman {
            text-align: center;
            font-size: 2rem;
            color: #111111;
            /* Pastikan teks berwarna putih */
            font-weight: bold;
            padding: 10px 0;
        }

        .arrow-btn {
            cursor: pointer;
            font-size: 2.5rem;
            user-select: none;
            transition: transform 0.2s;
        }

        .arrow-btn:hover {
            transform: scale(1.2);
        }

        #shirt-preview {
            max-height: 500px;
            transition: opacity 0.4s ease;
        }

        .design-list {
            max-height: 500px;
            overflow-y: auto;
            padding-right: 10px;
        }

        .design-list img {
            width: 80px;
            cursor: pointer;
            margin: 8px 0;
            border: 2px solid transparent;
            transition: transform 0.3s;
        }

        .design-list img:hover {
            transform: scale(1.05);
            border-color: #e63946;
        }

        .design-list img.selected {
            border-color: #e63946;
        }

        .card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
            transition: all 0.2s ease-in-out;
        }
    </style>

    <div class="container py-4">
        <div class="judul-halaman mb-4">Preview Desain Kaos</div>

        @if ($userDesigns->isNotEmpty())
            <div class="row mt-5">
                <!-- Sidebar Kiri -->
                <div class="col-md-3 bg-light p-3 rounded shadow-sm">
                    <h5 class="text-center mb-4">Desain Kamu</h5>
                    <div class="design-list d-grid"
                        style="grid-template-columns: repeat(auto-fill, minmax(80px, 1fr)); gap: 10px;">
                        @foreach ($userDesigns as $design)
                            <div class="card shadow-sm p-2 mb-3" style="border-radius: 10px;">
                                <img src="{{ asset('storage/' . $design->desain_depan) }}"
                                    data-front="{{ asset('storage/' . $design->desain_depan) }}"
                                    data-back="{{ asset('storage/' . $design->desain_belakang) }}"
                                    data-id="{{ $design->id }}" onclick="setDesign(this)" class="img-thumbnail">
                                <div class="mt-2">
                                    @if (!$design->is_locked)
                                        <form action="{{ route('desain.sendiri.destroy', $design->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Yakin ingin menghapus desain ini?')">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                    @else
                                        <button class="btn btn-sm btn-secondary" disabled
                                            title="Desain sedang digunakan dalam pesanan">
                                            <i class="bi bi-lock"></i> Tidak Bisa Dihapus
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Preview Kanan -->
                <div class="col-md-9 text-center">
                    @if (session('error'))
                        <div class="alert alert-danger mb-3" id="pesan-alert">{{ session('error') }}</div>
                    @endif

                    @if (session('info'))
                        <div class="alert alert-info alert-dismissible fade show mb-3" role="alert" id="pesan-alert">
                            {{ session('info') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert" id="pesan-alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="d-flex justify-content-center align-items-center">
                        <div class="me-4 arrow-btn" onclick="toggleView()">&#8634;</div>
                        <img id="shirt-preview" src="{{ asset('storage/' . $userDesigns->first()->desain_depan) }}"
                            alt="Kaos" class="img-fluid border shadow" style="max-height: 500px; border-radius: 10px;">
                        <div class="ms-4 arrow-btn" onclick="toggleView()">&#8635;</div>
                    </div>
                    <p class="mt-3 fw-bold" id="shirt-label">Tampilan Depan</p>

                    <div class="text-center mt-3">
                        <form action="{{ route('keranjang.tambah.item') }}" method="POST">
                            @csrf
                            <input type="hidden" name="jenis" value="kustom">
                            <input type="hidden" name="jumlah" value="1">
                            <input type="hidden" name="ukuran" value="{{ $userDesigns->first()->ukuran }}">
                            <input type="hidden" name="kaos_id" id="kaosIdInput" value="{{ $userDesigns->first()->id }}">
                            <button type="submit" class="btn btn-dark mt-3"><i class="bi bi-plus"></i> Tambah ke
                                Keranjang</button>
                        </form>
                    </div>
                </div>
            </div>

            <script>
                let isFront = true;
                let currentDesign = {
                    front: "{{ asset('storage/' . $userDesigns->first()->desain_depan) }}",
                    back: "{{ asset('storage/' . $userDesigns->first()->desain_belakang) }}"
                };

                function toggleView() {
                    const img = document.getElementById('shirt-preview');
                    const label = document.getElementById('shirt-label');
                    img.style.opacity = 0;
                    setTimeout(() => {
                        img.src = isFront ? currentDesign.back : currentDesign.front;
                        label.textContent = isFront ? "Tampilan Belakang" : "Tampilan Depan";
                        img.style.opacity = 1;
                        isFront = !isFront;
                    }, 300);
                }

                function setDesign(element) {
                    currentDesign.front = element.getAttribute('data-front');
                    currentDesign.back = element.getAttribute('data-back');
                    isFront = true;

                    // Update preview
                    const img = document.getElementById('shirt-preview');
                    const label = document.getElementById('shirt-label');
                    img.style.opacity = 0;
                    setTimeout(() => {
                        img.src = currentDesign.front;
                        label.textContent = "Tampilan Depan";
                        img.style.opacity = 1;
                    }, 300);

                    // Highlight selected
                    document.querySelectorAll('.design-list img').forEach(img => img.classList.remove('selected'));
                    element.classList.add('selected');

                    // Update hidden input untuk ID
                    document.getElementById('kaosIdInput').value = element.dataset.id;
                }
            </script>
        @else
            <div class="alert alert-info text-center mt-5">
                <h4>Belum ada desain yang kamu buat.</h4>
                <p>Ayo mulai buat desainmu sendiri sekarang juga!</p>
                <a href="{{ route('desain.sendiri') }}" class="btn btn-outline-danger mt-3">Buat Desain Sekarang</a>
            </div>
        @endif
    </div>
@endsection
