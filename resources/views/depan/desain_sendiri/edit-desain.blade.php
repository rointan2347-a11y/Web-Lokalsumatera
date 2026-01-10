@extends('depan.layouts.main')

@section('title', 'Desain Sendiri')

@section('content')
    <style>
        .kaos-container {
            display: flex;
            justify-content: center;
            gap: 50px;
            flex-wrap: wrap;
            padding: 60px 20px;
        }

        .panel-box {
            background-color: #1e1e1e;
            padding: 20px;
            color: white;
            border-radius: 10px;
        }

        .draggable {
            width: 80px;
            cursor: grab;
            margin-bottom: 10px;
        }

        .canvas-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .btn-custom {
            background-color: #e63946;
            border: none;
            color: white;
            padding: 10px 18px;
            border-radius: 8px;
            font-weight: bold;
        }

        .btn-custom:hover {
            background-color: #d62828;
        }

        @media (max-width: 768px) {
            .kaos-container {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>

    <section class="desain-sendiri">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-4">
                    <h2>Edit Desain Kaos Anda</h2>
                </div>
                <div class="col-md-6">
                    <form action="{{ route('desain.update', $desain->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Pilih Warna -->
                        <div class="form-group mb-3">
                            <label for="warna">Pilih Warna Kaos:</label>
                            <select name="warna" id="warna" class="form-control">
                                <option value="putih" {{ $desain->warna == 'putih' ? 'selected' : '' }}>Putih</option>
                                <option value="hitam" {{ $desain->warna == 'hitam' ? 'selected' : '' }}>Hitam</option>
                                <option value="biru" {{ $desain->warna == 'biru' ? 'selected' : '' }}>Biru</option>
                                <option value="merah" {{ $desain->warna == 'merah' ? 'selected' : '' }}>Merah</option>
                            </select>
                        </div>

                        <!-- Upload Desain -->
                        <div class="form-group mb-3">
                            <label for="gambar">Upload Gambar Desain:</label>
                            <input type="file" name="gambar" class="form-control">
                            @if ($desain->gambar)
                                <p class="mt-2">Gambar saat ini: <img src="{{ asset('storage/' . $desain->gambar) }}"
                                        width="100"></p>
                            @endif
                        </div>

                        <!-- Posisi dan Ukuran -->
                        <div class="form-group mb-3">
                            <label for="posisi_x">Posisi X:</label>
                            <input type="number" name="posisi_x" class="form-control" value="{{ $desain->posisi_x }}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="posisi_y">Posisi Y:</label>
                            <input type="number" name="posisi_y" class="form-control" value="{{ $desain->posisi_y }}">
                        </div>
                        <div class="form-group mb-4">
                            <label for="ukuran">Ukuran:</label>
                            <input type="number" name="ukuran" class="form-control" value="{{ $desain->ukuran }}">
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            <a href="{{ route('desain.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>

                <!-- Preview Kaos -->
                <div class="col-md-6">
                    <div class="position-relative" style="width: 100%; max-width: 300px; margin: auto;">
                        <img src="{{ asset('images/kaos/' . $desain->warna . '.png') }}" alt="Kaos" class="img-fluid">
                        @if ($desain->gambar)
                            <img src="{{ asset('storage/' . $desain->gambar) }}" alt="Desain"
                                style="position: absolute; top: {{ $desain->posisi_y }}px; left: {{ $desain->posisi_x }}px; width: {{ $desain->ukuran }}px;">
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.2.4/fabric.min.js"></script>
    <script>
        let canvasDepan, canvasBelakang;
        let draggedImage = null;
        let batasAreaDepan, batasAreaBelakang;

        document.addEventListener('DOMContentLoaded', function() {
            canvasDepan = new fabric.Canvas('canvas-depan');
            canvasBelakang = new fabric.Canvas('canvas-belakang');

            // Tambahkan batas area desain
            batasAreaDepan = createDesignBoundary(canvasDepan);
            batasAreaBelakang = createDesignBoundary(canvasBelakang);

            setBackgrounds();

            document.querySelectorAll('.draggable').forEach(function(el) {
                el.addEventListener('dragstart', function(e) {
                    draggedImage = this.src;
                });
            });

            setupDrop('depan', canvasDepan);
            setupDrop('belakang', canvasBelakang);

            document.querySelectorAll('input[name="warna_kaos"]').forEach(function(input) {
                input.addEventListener('change', function() {
                    setBackgrounds();
                });
            });

            // Batasi gerakan objek di dalam batas area
            enforceBoundary(canvasDepan, batasAreaDepan);
            enforceBoundary(canvasBelakang, batasAreaBelakang);
        });

        // function setBackgrounds() {
        //     const warna = document.querySelector('input[name="warna_kaos"]:checked').value;
        //     let bgDepan = warna === 'hitam' ? '{{ asset('img/hitam-depan.png') }}' : '{{ asset('img/putih-depan.png') }}';
        //     let bgBelakang = warna === 'hitam' ? '{{ asset('img/hitam-belakang.png') }}' :
        //         '{{ asset('img/putih-belakang.png') }}';

        //     fabric.Image.fromURL(bgDepan, function(img) {
        //         img.scaleToWidth(300);
        //         canvasDepan.setBackgroundImage(img, canvasDepan.renderAll.bind(canvasDepan));
        //     });

        //     fabric.Image.fromURL(bgBelakang, function(img) {
        //         img.scaleToWidth(300);
        //         canvasBelakang.setBackgroundImage(img, canvasBelakang.renderAll.bind(canvasBelakang));
        //     });
        // }

        function setBackgrounds() {
            const warna = document.querySelector('input[name="warna_kaos"]:checked').value;
            let bgDepan = warna === 'hitam' ? '{{ asset('img/hitam-depan.png') }}' : '{{ asset('img/putih-depan.png') }}';
            let bgBelakang = warna === 'hitam' ? '{{ asset('img/hitam-belakang.png') }}' :
                '{{ asset('img/putih-belakang.png') }}';

            fabric.Image.fromURL(bgDepan, function(img) {
                img.scaleToWidth(300);
                canvasDepan.setBackgroundImage(img, canvasDepan.renderAll.bind(canvasDepan), {
                    crossOrigin: null
                });
            });

            fabric.Image.fromURL(bgBelakang, function(img) {
                img.scaleToWidth(300);
                canvasBelakang.setBackgroundImage(img, canvasBelakang.renderAll.bind(canvasBelakang), {
                    crossOrigin: null
                });
            });
        }


        function createDesignBoundary(canvas) {
            const rect = new fabric.Rect({
                left: 75,
                top: 50,
                width: 150,
                height: 250,
                fill: 'rgba(0, 255, 0, 0.1)',
                stroke: 'green',
                strokeDashArray: [5, 5],
                selectable: false,
                evented: false
            });
            canvas.add(rect);
            return rect;
        }

        function enforceBoundary(canvas, boundaryRect) {
            canvas.on('object:moving', function(e) {
                let obj = e.target;
                const bounds = boundaryRect;

                const objLeft = obj.left;
                const objTop = obj.top;
                const objRight = obj.left + obj.width * obj.scaleX;
                const objBottom = obj.top + obj.height * obj.scaleY;

                // Batas minimum dan maksimum
                if (objLeft < bounds.left) obj.left = bounds.left;
                if (objTop < bounds.top) obj.top = bounds.top;
                if (objRight > bounds.left + bounds.width) obj.left = bounds.left + bounds.width - obj.width * obj
                    .scaleX;
                if (objBottom > bounds.top + bounds.height) obj.top = bounds.top + bounds.height - obj.height * obj
                    .scaleY;
            });
        }

        function setupDrop(canvasKey, fabricCanvas) {
            const wrapper = document.querySelector(`.canvas-wrapper[data-canvas="${canvasKey}"]`);
            wrapper.addEventListener('dragover', e => e.preventDefault());
            wrapper.addEventListener('drop', e => {
                e.preventDefault();
                if (draggedImage) {
                    const rect = wrapper.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;

                    fabric.Image.fromURL(draggedImage, function(img) {
                        img.scaleToWidth(100);
                        img.set({
                            left: 100,
                            top: 150
                        });
                        fabricCanvas.add(img);
                    }, {
                        crossOrigin: 'anonymous'
                    });

                    draggedImage = null;
                }
            });
        }

        function clearCanvas() {
            canvasDepan.clear();
            canvasBelakang.clear();

            batasAreaDepan = createDesignBoundary(canvasDepan);
            batasAreaBelakang = createDesignBoundary(canvasBelakang);
            setBackgrounds();
        }

        function addTextToCanvas() {
            const teks = document.getElementById('teks_kustom').value;
            if (teks.trim() === '') return;

            const text = new fabric.Text(teks, {
                left: 100,
                top: 180,
                fontSize: 18,
                fill: 'black'
            });

            canvasDepan.add(text);
            canvasDepan.renderAll();
        }

        function saveDesain() {
            document.getElementById('inputTeksCustom').value = document.getElementById('teks_kustom').value;
            document.getElementById('inputWarnaKaos').value = document.querySelector('input[name="warna_kaos"]:checked')
                .value;

            // Hapus batas sementara
            canvasDepan.remove(batasAreaDepan);
            canvasBelakang.remove(batasAreaBelakang);

            // Simpan gambar
            const desainDepan = canvasDepan.toDataURL({
                format: 'png',
                quality: 1,
                multiplier: 1,
                withoutBackground: false
            });

            const desainBelakang = canvasBelakang.toDataURL({
                format: 'png',
                quality: 1,
                multiplier: 1,
                withoutBackground: false
            });

            // Tambahkan kembali batas area
            canvasDepan.add(batasAreaDepan);
            canvasBelakang.add(batasAreaBelakang);

            // Set ke input hidden dan submit
            document.getElementById('desainDepanBase64').value = desainDepan;
            document.getElementById('desainBelakangBase64').value = desainBelakang;

            document.getElementById('formDesain').submit();
        }




        // function saveDesain() {
        //     document.getElementById('inputTeksCustom').value = document.getElementById('teks_kustom').value;
        //     document.getElementById('inputWarnaKaos').value = document.querySelector('input[name="warna_kaos"]:checked')
        //         .value;
        //     document.getElementById('desainDepanBase64').value = canvasDepan.toDataURL('image/png');
        //     document.getElementById('desainBelakangBase64').value = canvasBelakang.toDataURL('image/png');
        //     document.getElementById('formDesain').submit();
        // }
    </script>

@endsection
