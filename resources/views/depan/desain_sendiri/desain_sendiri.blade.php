@extends('depan.layouts.main')

@section('title', 'Desain Sendiri')

@section('content')
    <style>
        /* Modern App Layout */
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap');

        body {
            background-color: #f8f9fa;
            font-family: 'Outfit', sans-serif;
        }

        .workspace-container {
            display: grid;
            grid-template-columns: 300px minmax(500px, 1fr) 320px;
            gap: 24px;
            padding: 20px 0;
            max-width: 1400px;
            margin: 0 auto;
        }

        @media (max-width: 1200px) {
            .workspace-container {
                grid-template-columns: 280px 1fr;
                grid-template-rows: auto auto;
            }
            .config-panel {
                grid-column: 2;
                grid-row: 2;
            }
        }

        @media (max-width: 992px) {
            .workspace-container {
                grid-template-columns: 1fr;
                display: flex;
                flex-direction: column;
            }
        }

        /* Card Styles */
        .app-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            padding: 24px;
            height: 100%;
            border: 1px solid rgba(0,0,0,0.05);
        }

        .panel-title {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            font-size: 1.1rem;
            margin-bottom: 20px;
            color: #1a1a1a;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Upload Area */
        .upload-zone {
            border: 2px dashed #e0e0e0;
            border-radius: 12px;
            padding: 30px 20px;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
            background: #fafafa;
        }

        .upload-zone:hover {
            border-color: #ff7e14;
            background: #fff8f2;
        }

        /* Asset Grid */
        .assets-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            max-height: 400px;
            overflow-y: auto;
            padding: 4px;
        }

        .asset-item {
            aspect-ratio: 1;
            background: #f8f9fa;
            border-radius: 8px;
            border: 2px solid transparent;
            cursor: grab;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .asset-item:hover {
            border-color: #ff7e14;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .asset-item img {
            max-width: 80%;
            max-height: 80%;
            object-fit: contain;
        }

        .delete-asset {
            position: absolute;
            top: 2px;
            right: 2px;
            width: 20px;
            height: 20px;
            background: rgba(255, 0, 0, 0.8);
            color: white;
            border-radius: 50%;
            font-size: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            opacity: 0;
            transition: opacity 0.2s;
        }

        .asset-item:hover .delete-asset {
            opacity: 1;
        }

        /* Canvas Area */
        .canvas-stage {
            background: #f1f3f5;
            border-radius: 20px;
            padding: 40px;
            display: flex;
            flex-direction: column; /* Stack vertikal */
            align-items: center;
            gap: 30px;
            min-height: 600px;
        }

        .canvas-wrapper {
            background: transparent;
            position: relative;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1); /* Shadow lebih dalam */
            border-radius: 4px; /* Sedikit rounded opsional */
        }
        
        .canvas-label {
             font-family: 'Outfit', sans-serif;
             font-weight: 700;
             margin-top: 10px;
             color: #6c757d;
        }

        /* Controls */
        .control-bar {
            background: white;
            padding: 15px;
            border-radius: 50px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            display: flex;
            gap: 10px;
            width: fit-content;
            margin: 0 auto 20px;
        }
        
        /* Swatches - Color */
        .color-options {
            display: flex;
            gap: 15px;
        }
        
        .color-radio {
            display: none;
        }
        
        .color-label {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            border: 2px solid #dee2e6;
            position: relative;
            transition: transform 0.2s;
        }
        
        .color-label:hover {
            transform: scale(1.1);
        }
        
        .color-radio:checked + .color-label {
            border-color: #ff7e14;
            box-shadow: 0 0 0 2px #fff, 0 0 0 4px #ff7e14;
        }
        
        .bg-black-swatch { background-color: #1a1a1a; }
        .bg-white-swatch { background-color: #ffffff; }

        /* Size Pills */
        .size-options {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        
        .size-radio {
            display: none;
        }
        
        .size-label {
            padding: 10px 20px;
            border: 1px solid #dee2e6;
            border-radius: 12px;
            cursor: pointer;
            font-weight: 600;
            color: #495057;
            transition: all 0.2s;
            background: white;
        }
        
        .size-radio:checked + .size-label {
            background-color: #ff7e14;
            color: white;
            border-color: #ff7e14;
            box-shadow: 0 4px 10px rgba(255, 126, 20, 0.3);
        }
        
        .delete-floating {
             position: absolute;
             top: 10px;
             right: 10px;
             width: 30px;
             height: 30px;
             background: #ff4757;
             color: white;
             border-radius: 50%;
             display: flex;
             align-items: center;
             justify-content: center;
             cursor: pointer;
             box-shadow: 0 4px 10px rgba(0,0,0,0.2);
             z-index: 1000;
        }
        
        /* Custom Scrollbar */
        .custom-scroll::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scroll::-webkit-scrollbar-thumb {
            background-color: #dee2e6;
            border-radius: 4px;
        }

        /* Orange Theme */
        .text-orange { color: #ff7e14; }
        .btn-orange {
            background-color: #ff7e14;
            border-color: #ff7e14;
            color: white;
        }
        .btn-orange:hover {
            background-color: #e66a00;
            border-color: #e66a00;
            color: white;
        }
        .letter-spacing-1 { letter-spacing: 1px; }
    </style>

    <div class="container-fluid px-lg-5">
        <!-- Header -->
        <div class="d-flex align-items-center justify-content-between py-4 border-bottom mb-4">
            <div>
                 <h2 class="fw-bold mb-1" style="font-family: 'Outfit';">Studio Desain</h2>
                 <p class="text-muted mb-0 small"><i class="bi bi-info-circle me-1"></i> Gunakan Desktop untuk pengalaman mendesain terbaik.</p>
            </div>
            <div>
                 <a href="/faq" class="btn btn-outline-dark rounded-pill btn-sm px-3">Bantuan</a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success rounded-4 border-0 shadow-sm d-flex align-items-center mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger rounded-4 border-0 shadow-sm mb-4">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="workspace-container">
            <!-- 1. Left Panel: Assets -->
            <div class="side-panel">
                <div class="app-card d-flex flex-column gap-4">
                    
                    <!-- Upload Section -->
                    <div>
                        <div class="panel-title"><i class="bi bi-cloud-upload text-orange"></i> Upload</div>
                        <form method="POST" action="{{ route('desain.user.upload') }}" enctype="multipart/form-data">
                            @csrf
                            <label class="upload-zone w-100 d-block">
                                <i class="bi bi-image fs-1 text-muted mb-2 d-block"></i>
                                <span class="fw-bold text-dark d-block">Klik untuk Upload</span>
                                <span class="small text-muted d-block">PNG, JPG (Max 2MB)</span>
                                <input type="file" name="gambar" class="d-none" required onchange="this.form.submit()">
                            </label>
                        </form>
                        <small class="text-muted mt-2 d-block fst-italic text-center" style="font-size: 11px;">*Gunakan gambar tanpa background agar hasil sablon rapi!</small>
                    </div>

                    <!-- User Assets -->
                    <div class="flex-grow-1 d-flex flex-column">
                        <div class="panel-title mb-2"><i class="bi bi-folder text-orange"></i> Desain Kamu</div>
                        <div class="assets-grid custom-scroll flex-grow-1">
                             @forelse ($desainUser as $item)
                                <div class="asset-item" draggable="true">
                                    <form action="{{ route('desain.user.delete', $item->id) }}" method="POST"
                                        onsubmit="return confirm('Hapus aset ini?')" style="position: absolute; top: 0; right: 0; z-index: 1;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete-asset border-0">×</button>
                                    </form>
                                    <img src="{{ asset('storage/' . $item->gambar) }}" data-id="{{ $item->id }}"
                                        class="draggable" alt="{{ $item->nama ?? 'Desain' }}">
                                </div>
                            @empty
                                <div class="col-12 py-5 text-center text-muted small">
                                    Belum ada desain.
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- System Assets -->
                    <div class="flex-grow-1 d-flex flex-column pt-3 border-top">
                        <div class="panel-title mb-2"><i class="bi bi-grid text-orange"></i> Stiker Keren</div>
                        <div class="assets-grid custom-scroll" style="max-height: 200px;">
                             @forelse ($desainAdmin as $item)
                                <div class="asset-item" draggable="true">
                                    <img src="{{ asset('storage/' . $item->gambar) }}" data-id="{{ $item->id }}"
                                        class="draggable" alt="{{ $item->nama ?? 'Stiker' }}">
                                </div>
                            @empty
                                <div class="col-12 text-center text-muted small">Loading...</div>
                            @endforelse
                        </div>
                    </div>

                </div>
            </div>

            <!-- 2. Center Stage: Canvas -->
            <div class="main-stage">
                <!-- Toolbar -->
                <div class="control-bar mx-auto py-2 px-3 align-items-center">
                    <div class="d-flex gap-2">
                         <input type="text" id="teks_kustom" placeholder="Ketik teks... (max 10)" maxlength="10" class="form-control form-control-sm rounded-pill border-0 bg-light" style="width: 150px;">
                         <select id="posisi_teks" class="form-select form-select-sm rounded-pill border-0 bg-light" style="width: auto;">
                            <option value="depan">Depan</option>
                            <option value="belakang">Belakang</option>
                        </select>
                        <button class="btn btn-dark btn-sm rounded-circle shadow-sm" style="width: 32px; height: 32px;" onclick="addTextToCanvas()" title="Tambah Teks"><i class="bi bi-fonts"></i></button>
                    </div>
                    <div class="vr mx-2"></div>
                    <button class="btn btn-outline-danger btn-sm rounded-circle" style="width: 32px; height: 32px;" onclick="clearCanvas()" title="Reset Canvas"><i class="bi bi-arrow-counterclockwise"></i></button>
                </div>

                <div class="canvas-stage position-relative text-center">
                    <!-- Global Delete Button (Floating) -->
                    <div id="delete-button" class="delete-floating" style="display: none;" title="Hapus Objek Terpilih"><i class="bi bi-trash"></i></div>

                    <!-- Front Canvas -->
                    <div class="mb-5">
                        <div class="canvas-wrapper d-inline-block position-relative" data-canvas="depan">
                            <canvas id="canvas-depan" width="300" height="400"></canvas>
                        </div>
                        <div class="canvas-label">TAMPAK DEPAN</div>
                    </div>

                    <!-- Back Canvas -->
                    <div>
                        <div class="canvas-wrapper d-inline-block position-relative" data-canvas="belakang">
                            <canvas id="canvas-belakang" width="300" height="400"></canvas>
                        </div>
                        <div class="canvas-label">TAMPAK BELAKANG</div>
                    </div>
                </div>
            </div>

            <!-- 3. Right Panel: Config -->
            <div class="config-panel">
                <div class="app-card d-flex flex-column gap-4">
                    
                    <!-- Color Selector -->
                    <div>
                        <div class="panel-title">Warna Dasar</div>
                        <div class="color-options justify-content-center">
                            <div class="form-check p-0">
                                <input class="color-radio" type="radio" name="warna_kaos" id="warnaHitam" value="hitam" checked>
                                <label class="color-label bg-black-swatch" for="warnaHitam" title="Hitam"></label>
                            </div>
                            <div class="form-check p-0">
                                <input class="color-radio" type="radio" name="warna_kaos" id="warnaPutih" value="putih">
                                <label class="color-label bg-white-swatch" for="warnaPutih" title="Putih"></label>
                            </div>
                        </div>
                        <p class="text-center small text-muted mt-2 mb-0" id="colorNameDisplay">Hitam Premium</p>
                    </div>

                    <hr class="my-0 opacity-10">

                    <!-- Size Selector -->
                    <div>
                        <div class="panel-title">Ukuran</div>
                        <div class="size-options justify-content-center">
                            @foreach(['S', 'M', 'L', 'XL', 'XXL'] as $size)
                                <div class="form-check p-0">
                                    <input class="size-radio" type="radio" name="ukuran_kaos" id="ukuran{{$size}}" value="{{$size}}" {{ $size == 'L' ? 'checked' : '' }}>
                                    <label class="size-label" for="ukuran{{$size}}">{{$size}}</label>
                                </div>
                            @endforeach
                        </div>
                         <div class="text-center mt-3">
                             <a href="/saran-ukuran" target="_blank" class="text-orange small text-decoration-none fw-bold"><i class="bi bi-ruler-combined"></i> Cek rekomendasi ukuran kamu</a>
                         </div>
                    </div>

                    <hr class="my-0 opacity-10">
                    
                    <!-- Quantity -->
                     <div>
                        <div class="panel-title">Jumlah Order</div>
                        <div class="d-flex justify-content-center">
                            <input type="number" id="jumlah_kaos" name="jumlah_kaos" value="1" min="1" class="form-control text-center fw-bold fs-5 rounded-pill border-2" style="width: 100px;">
                        </div>
                    </div>

                    <div class="mt-auto pt-4">
                        <div class="bg-light rounded-4 p-3 mb-3 text-center">
                            <span class="text-muted small text-uppercase fw-bold letter-spacing-1">Total Estimasi</span>
                            <h3 class="fw-bold text-dark mt-1 mb-0" id="hargaTotal">Rp 0</h3>
                        </div>
                        <button class="btn btn-orange w-100 rounded-pill py-3 fw-bold shadow-lg" onclick="saveDesain()">
                            <i class="bi bi-cart-check me-2"></i> Simpan & Pesan
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Hidden Form -->
    <form id="formDesain" method="POST" action="{{ route('kaos.kustom.store') }}">
        @csrf
        <input type="hidden" name="desain_depan" id="desainDepanBase64">
        <input type="hidden" name="desain_belakang" id="desainBelakangBase64">
        <input type="hidden" name="teks_custom" id="inputTeksCustom">
        <input type="hidden" name="ukuran_kaos" id="inputUkuranKaos">
        <input type="hidden" name="jumlah_kaos" id="inputJumlahKaos">
        <input type="hidden" name="warna_kaos" id="inputWarnaKaos">
        <input type="hidden" name="total_harga" id="inputHarga">
    </form>

@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.2.4/fabric.min.js"></script>
    <script>
        // === REVISED FABRIC.JS LOGIC FOR SMOOTH UX ===
        // Global variables
        let canvasDepan, canvasBelakang;
        let draggedImage = null;
        let borderDepan, borderBelakang;

        // Custom Settings for Professional Feel
        fabric.Object.prototype.set({
            borderColor: '#ff7e14',       // Orange Sumatera
            cornerColor: '#ffffff',       // White handles
            cornerStrokeColor: '#ff7e14', // Orange border for handles
            cornerSize: 14,               // Larger handles for easier grabbing
            transparentCorners: false,
            padding: 8,                   // Padding selection
            borderScaleFactor: 2,         // Thicker selection line
            cornerStyle: 'circle'         // Modern circle handles
        });

        document.addEventListener('DOMContentLoaded', function () {
            // Initialize Canvases
            canvasDepan = new fabric.Canvas('canvas-depan', { preserveObjectStacking: true });
            canvasBelakang = new fabric.Canvas('canvas-belakang', { preserveObjectStacking: true });

            // Create Visual Boundaries (Print Areas)
            borderDepan = createBoundary(canvasDepan);
            borderBelakang = createBoundary(canvasBelakang);

            // Load Shirt Backgrounds
            setBackgrounds();

            // Setup Event Listeners
            setupDragDrop();
            setupCanvasListeners(canvasDepan, borderDepan);
            setupCanvasListeners(canvasBelakang, borderBelakang);
            
            // Initial Pricing
            updateHarga();
            updateColorLabel();

            // Global Color Change Listener
            document.querySelectorAll('input[name="warna_kaos"]').forEach(input => {
                input.addEventListener('change', () => {
                    setBackgrounds();
                    updateTextColorBasedOnKaos();
                    updateHarga();
                    updateColorLabel();
                });
            });
            
            // Delete Button Logic
            setupDeleteButton();
        });

        // 1. Boundary Creation (Visual Guide Only)
        function createBoundary(canvas) {
            // Area cetak A3+ proporsional di canvas 300x400
            const rect = new fabric.Rect({
                left: 60,
                top: 50,
                width: 180,
                height: 280,
                fill: 'transparent',
                stroke: 'rgba(255, 126, 20, 0.5)', // Orange tipis
                strokeWidth: 2,
                strokeDashArray: [5, 5],
                selectable: false,
                evented: false,
                id: 'print-area'
            });
            canvas.add(rect);
            canvas.printArea = rect;
            return rect;
        }

        // 2. Smooth Constraints (The "Flexible" Part)
        function setupCanvasListeners(canvas, boundary) {
            // Keep object inside boundary smoothly
            canvas.on('object:moving', function (e) {
                var obj = e.target;

                // Jika objek adalah teks atau gambar
                if(obj.type === 'image' || obj.type === 'textbox') {
                     // Logika Smooth: Batasi titik pusat objek agar tidak keluar terlalu jauh
                     const topBound = boundary.top;
                     const bottomBound = boundary.top + boundary.height;
                     const leftBound = boundary.left;
                     const rightBound = boundary.left + boundary.width;

                     const objCenter = obj.getCenterPoint();
                     
                     // Allow slight overhang but keep center inside
                     if (objCenter.x < leftBound) obj.left = leftBound - (obj.width * obj.scaleX / 2);
                     if (objCenter.x > rightBound) obj.left = rightBound - (obj.width * obj.scaleX / 2);
                     if (objCenter.y < topBound) obj.top = topBound - (obj.height * obj.scaleY / 2);
                     if (objCenter.y > bottomBound) obj.top = bottomBound - (obj.height * obj.scaleY / 2);
                }
            });

            // Update Price on Modification
            canvas.on('object:modified', updateHarga);
            canvas.on('object:added', updateHarga);
            canvas.on('object:removed', updateHarga);

            // Show/Hide Delete Button
            canvas.on('selection:created', showDeleteBtn);
            canvas.on('selection:updated', showDeleteBtn);
            canvas.on('selection:cleared', hideDeleteBtn);
        }
        
        // 3. Background Management
        function setBackgrounds() {
            const warna = document.querySelector('input[name="warna_kaos"]:checked').value;
            // Preload images to avoid flickering if possible, but standard load is fine
            const frontUrl = warna === 'hitam' ? '{{ asset('img/hitam-depan.png') }}' : '{{ asset('img/putih-depan.png') }}';
            const backUrl = warna === 'hitam' ? '{{ asset('img/hitam-belakang.png') }}' : '{{ asset('img/putih-belakang.png') }}';

            fabric.Image.fromURL(frontUrl, function(img) {
                img.set({scaleX: 300/img.width, scaleY: 400/img.height, originX: 'left', originY: 'top'});
                canvasDepan.setBackgroundImage(img, canvasDepan.renderAll.bind(canvasDepan));
            });

            fabric.Image.fromURL(backUrl, function(img) {
                img.set({scaleX: 300/img.width, scaleY: 400/img.height, originX: 'left', originY: 'top'});
                canvasBelakang.setBackgroundImage(img, canvasBelakang.renderAll.bind(canvasBelakang));
            });
        }

        // 4. Drag & Drop Logic
        function setupDragDrop() {
            // Drag Start
            document.querySelectorAll('.asset-item').forEach(item => {
                item.addEventListener('dragstart', (e) => {
                    const img = item.querySelector('img');
                    if(img) {
                        e.dataTransfer.setData('src', img.src);
                        draggedImage = img.src; // Fallback
                    }
                });
            });

            // Drop Handlers
            ['depan', 'belakang'].forEach(side => {
                const wrapper = document.querySelector(`.canvas-wrapper[data-canvas="${side}"]`);
                const targetCanvas = side === 'depan' ? canvasDepan : canvasBelakang;
                const boundary = side === 'depan' ? borderDepan : borderBelakang;

                wrapper.addEventListener('dragover', e => e.preventDefault());
                wrapper.addEventListener('drop', e => {
                    e.preventDefault();
                    const src = e.dataTransfer.getData('src') || draggedImage;
                    
                    if (src) {
                        fabric.Image.fromURL(src, function(img) {
                            // Smart scaling: Fit to 50% of print width
                            const targetWidth = boundary.width * 0.6;
                            const scale = targetWidth / img.width;
                            
                            img.set({
                                scaleX: scale,
                                scaleY: scale,
                                left: boundary.left + (boundary.width - img.width * scale) / 2,
                                top: boundary.top + (boundary.height - img.height * scale) / 2
                            });
                            
                            targetCanvas.add(img);
                            targetCanvas.setActiveObject(img);
                            updateHarga();
                        }, { crossOrigin: 'anonymous' });
                    }
                });
            });
        }

        // 5. Text Adding Function
        function addTextToCanvas() {
            const textVal = document.getElementById("teks_kustom").value.trim();
            const posisi = document.getElementById("posisi_teks").value;
            
            if(!textVal) return;
            if(textVal.length > 10) { alert('Maksimal 10 Karakter untuk menjaga estetika!'); return; }

            const targetCanvas = posisi === 'depan' ? canvasDepan : canvasBelakang;
            const boundary = posisi === 'depan' ? borderDepan : borderBelakang;
            const textColor = document.querySelector('input[name="warna_kaos"]:checked').value === 'hitam' ? '#ffffff' : '#333333';

            const textObj = new fabric.Textbox(textVal, {
                fontSize: 24,
                fontFamily: 'Outfit', // Match web font
                fill: textColor,
                left: boundary.left + 20,
                top: boundary.top + 20,
                width: boundary.width - 40,
                textAlign: 'center',
                splitByGrapheme: true
            });

            targetCanvas.add(textObj);
            targetCanvas.setActiveObject(textObj);
            updateHarga();
            document.getElementById("teks_kustom").value = ''; // Reset input
        }

        // 6. Delete Logic
        function setupDeleteButton() {
            const btn = document.getElementById('delete-button');
            if (btn && btn.parentElement !== document.body) {
                document.body.appendChild(btn);
                btn.style.position = 'fixed';
                btn.style.zIndex = 9999;
            }
            
            btn.onclick = function() {
                const activeDepan = canvasDepan.getActiveObject();
                const activeBelakang = canvasBelakang.getActiveObject();
                
                if(activeDepan) canvasDepan.remove(activeDepan);
                if(activeBelakang) canvasBelakang.remove(activeBelakang);
                
                hideDeleteBtn();
                updateHarga();
            };
        }

        function showDeleteBtn(e) {
            const btn = document.getElementById('delete-button');
            const obj = e.target;
            // Calculate absolute position
            const canvasRect = obj.canvas.lowerCanvasEl.getBoundingClientRect();
            // Position above the object, centered
            const top = canvasRect.top + obj.top - 40; 
            const left = canvasRect.left + obj.left + (obj.getScaledWidth() / 2) - 15;

            btn.style.top = `${top}px`;
            btn.style.left = `${left}px`;
            btn.style.display = 'flex';
        }

        function hideDeleteBtn() {
            document.getElementById('delete-button').style.display = 'none';
        }

        function clearCanvas() {
            if(!confirm('Reset semua desain area kerja?')) return;
            // Clear objects but keep boundary
            canvasDepan.getObjects().forEach(o => { if(o.id !== 'print-area') canvasDepan.remove(o) });
            canvasBelakang.getObjects().forEach(o => { if(o.id !== 'print-area') canvasBelakang.remove(o) });
            updateHarga();
        }

        // 7. Pricing Logic
        function updateHarga() {
            const jumlah = Math.max(1, parseInt(document.getElementById('jumlah_kaos').value) || 1);
            const size = document.querySelector('input[name="ukuran_kaos"]:checked').value;
            
            let basePrice = 80000;
            if(['XXL', 'XXXL'].includes(size)) basePrice += 10000;

            const countObjects = (c) => c.getObjects().filter(o => o.id !== 'print-area').length;
            const totalAssets = countObjects(canvasDepan) + countObjects(canvasBelakang);
            
            // Simple pricing: 15k per added element
            const designCost = totalAssets * 15000;
            
            const totalPerItem = basePrice + designCost;
            const grandTotal = totalPerItem * jumlah;

            document.getElementById('hargaTotal').innerText = 'Rp ' + grandTotal.toLocaleString('id-ID');
            document.getElementById('inputHarga').value = grandTotal;
        }
        
        // 8. Color Label Logic
        function updateColorLabel() {
            const warna = document.querySelector('input[name="warna_kaos"]:checked')?.value;
            const label = document.getElementById('colorNameDisplay');
            if(label) label.textContent = (warna === 'hitam') ? 'Hitam Premium' : 'Putih Classy';
        }

        function updateTextColorBasedOnKaos() {
             // Opsional: ubah warna teks yg sudah ada di kanvas jika ganti warna kaos
             // Tapi lebih aman biarkan user yang atur warnanya.
             // Kita hanya ubah default untuk teks baru.
        }

        // 9. Save Function
        function saveDesain() {
            // Hide boundaries before export
            borderDepan.visible = false;
            borderBelakang.visible = false;
            canvasDepan.discardActiveObject().renderAll();
            canvasBelakang.discardActiveObject().renderAll();

            if (canvasDepan.getObjects().length <= 1 && canvasBelakang.getObjects().length <= 1) {
                alert('Area desain masih kosong! Tambahkan elemen dulu.');
                borderDepan.visible = true;
                borderBelakang.visible = true;
                return;
            }

            // Populate Hidden Inputs
            document.getElementById('desainDepanBase64').value = canvasDepan.toDataURL({ format: 'png', multiplier: 2 });
            document.getElementById('desainBelakangBase64').value = canvasBelakang.toDataURL({ format: 'png', multiplier: 2 });
            document.getElementById('inputTeksCustom').value = '-'; // Legacy filler
            document.getElementById('inputUkuranKaos').value = document.querySelector('input[name="ukuran_kaos"]:checked').value;
            document.getElementById('inputWarnaKaos').value = document.querySelector('input[name="warna_kaos"]:checked').value;
            document.getElementById('inputJumlahKaos').value = document.getElementById('jumlah_kaos').value;
            
            // Submit
            document.getElementById('formDesain').submit();
        }

    </script>

@endsection