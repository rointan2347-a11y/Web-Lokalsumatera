@extends('depan.layouts.main')

@section('title', 'AI Smart Fitting - Lokal Sumatera')

@section('content')
    <style>
        body {
            background-color: #fff9f5; /* Very light orange tint */
            font-family: 'Outfit', 'Inter', sans-serif; /* Try using a more modern font if available, fallback to Inter */
            overflow-x: hidden;
        }

        /* Ambient Background Effect */
        .ambient-glow {
            position: absolute;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(255, 126, 20, 0.15) 0%, rgba(255, 255, 255, 0) 70%);
            top: -200px;
            left: 50%;
            transform: translateX(-50%);
            z-index: -1;
            pointer-events: none;
        }

        .ai-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            border-radius: 32px;
            box-shadow: 0 40px 80px rgba(217, 78, 5, 0.1); /* Orange shadow */
            border: 1px solid rgba(255, 255, 255, 0.8);
            position: relative;
            overflow: hidden;
        }

        .wizard-step {
            display: none;
            opacity: 0;
            transform: translateY(30px) scale(0.95);
            transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .wizard-step.active {
            display: block;
            opacity: 1;
            transform: translateY(0) scale(1);
        }

        .form-floating > label {
            padding-left: 1.5rem;
        }

        .form-control-lg {
            border-radius: 20px;
            padding: 1rem 1.5rem;
            border: 2px solid transparent;
            background: #fff;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
            font-weight: 600;
            color: #495057;
            height: 3.5rem;
            transition: all 0.3s ease;
        }

        .form-control-lg:focus {
            border-color: #ff7e14; /* Sumatera Orange */
            box-shadow: 0 0 0 5px rgba(255, 126, 20, 0.15);
            background: #fff;
        }

        .form-floating > .form-control-lg:focus ~ label {
            color: #ff7e14;
        }

        /* Custom Radio Cards */
        .option-card {
            border: 2px solid transparent;
            border-radius: 24px;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
            background: #fff;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
            position: relative;
            overflow: hidden;
        }

        .option-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(255, 126, 20, 0.1);
        }

        .option-card.selected {
            border-color: #ff7e14;
            background-color: #fff4e6; /* Light Orange */
            box-shadow: 0 15px 30px rgba(255, 126, 20, 0.2);
        }

        .option-card.selected i {
            color: #ff7e14;
            transform: scale(1.2);
        }

        /* Buttons */
        .btn-modern {
            border-radius: 50px;
            padding: 1rem 2.5rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .btn-primary-modern {
            background: linear-gradient(135deg, #ff7e14 0%, #d94e05 100%);
            border: none;
            color: white;
            box-shadow: 0 10px 25px rgba(217, 78, 5, 0.3);
        }

        .btn-primary-modern:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(217, 78, 5, 0.4);
            color: white;
        }

        .btn-primary-modern::after {
            content: '';
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: linear-gradient(135deg, #ff9f4d 0%, #ff7e14 100%);
            z-index: -1;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .btn-primary-modern:hover::after {
            opacity: 1;
        }

        .btn-light-modern {
            background: white;
            border: 2px solid #f1f3f5;
            color: #868e96;
        }

        .btn-light-modern:hover {
            background: #f8f9fa;
            color: #343a40;
            border-color: #dee2e6;
        }

        /* Progress Bar */
        .progress-container {
            height: 6px;
            background: #ffe8cc;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 50px;
            position: relative;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #ff7e14, #ffbf80);
            width: 25%;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(255, 126, 20, 0.5);
            transition: width 0.8s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        /* Result Section */
        .result-box {
            background: linear-gradient(160deg, #212529 0%, #000000 100%);
            color: white;
            border-radius: 32px;
            padding: 50px 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
            box-shadow: 0 20px 50px rgba(0,0,0,0.2);
        }

        /* Confetti or Abstract Shapes for Result */
        .result-deco {
            position: absolute;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(255, 126, 20, 0.4) 0%, transparent 60%);
            filter: blur(40px);
            top: -50px;
            right: -50px;
        }

        .size-highlight {
            font-size: 6rem;
            font-weight: 900;
            background: linear-gradient(180deg, #fff 20%, #ff7e14 100%);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin: 10px 0;
            line-height: 1;
            /* Text Shadow for pop */
            filter: drop-shadow(0 0 20px rgba(255, 126, 20, 0.3));
        }

        .badge-confidence {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255,255,255,0.2);
            color: #ffbf80;
            font-weight: 600;
            letter-spacing: 1px;
        }

    </style>

    <!-- Ambient Background -->
    <div class="ambient-glow"></div>

    <div class="container py-5" style="min-height: 85vh; display: flex; align-items: center;">
        <div class="row justify-content-center w-100">
            <div class="col-lg-8">

                <div class="card ai-card border-0 p-3">
                    <div class="card-body p-4 p-md-5">

                        <!-- Header Minimalist -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h5 class="fw-bold m-0 text-dark"><i class="bi bi-robot me-2 text-warning"></i>Smart Fitting AI</h5>
                            </div>
                            <div class="text-muted small">Powered by Lokal Sumatera</div>
                        </div>

                        <!-- Modern Progress -->
                        <div class="progress-container">
                            <div class="progress-fill" id="progressBar"></div>
                        </div>

                        <form id="aiForm">
                            @csrf

                            <!-- STEP 1 -->
                            <div class="wizard-step active" id="step1">
                                <div class="text-center mb-5">
                                    <h2 class="fw-bold mb-2">Halo, Kenalan Dulu Yuk! 👋</h2>
                                    <p class="text-muted">Biar AI kami gak salah tebak, isi tinggi & berat badanmu dulu ya</p>
                                </div>

                                <div class="row g-4 justify-content-center">
                                    <div class="col-md-5">
                                        <div class="form-floating">
                                            <input type="number" class="form-control form-control-lg" id="tinggi" name="tinggi" placeholder="170" required>
                                            <label>Tinggi Kamu (cm)</label>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-floating">
                                            <input type="number" class="form-control form-control-lg" id="berat" name="berat" placeholder="65" required>
                                            <label>Berat Kamu (kg)</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center mt-5">
                                    <button type="button" class="btn btn-primary-modern btn-modern" onclick="nextStep(2)">
                                        Lanjut Dong <i class="bi bi-arrow-right ms-2"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- STEP 2 -->
                            <div class="wizard-step" id="step2">
                                <div class="text-center mb-5">
                                    <h2 class="fw-bold mb-2">Ada Detail Tambahan? 🤔</h2>
                                    <p class="text-muted">Kalau kamu tau info ini, hasil prediksinya bakal super akurat lho!</p>
                                </div>

                                <div class="row g-4 justify-content-center">
                                    <div class="col-md-5">
                                        <div class="form-floating">
                                            <input type="number" class="form-control form-control-lg" id="lingkar_dada" name="lingkar_dada" placeholder="100">
                                            <label>Lingkar Dada (cm) - Opsional</label>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-floating">
                                            <input type="number" class="form-control form-control-lg" id="panjang_baju" name="panjang_baju" placeholder="70">
                                            <label>Panjang Baju (cm) - Opsional</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-center gap-3 mt-5">
                                    <button type="button" class="btn btn-light-modern btn-modern px-4" onclick="nextStep(1)">Back</button>
                                    <button type="button" class="btn btn-primary-modern btn-modern" onclick="nextStep(3)">
                                        Lanjut Lagi <i class="bi bi-arrow-right ms-2"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- STEP 3 -->
                            <div class="wizard-step" id="step3">
                                <div class="text-center mb-5">
                                    <h2 class="fw-bold mb-2">Selera Kamu Gimana? 🎨</h2>
                                    <p class="text-muted">Biar kami carikan stok yang <i>ready</i> buat kamu.</p>
                                </div>

                                <div class="row justify-content-center mb-4">
                                    <div class="col-md-10">
                                        <label class="fw-bold mb-3 small text-uppercase text-muted ls-1">Mau Warna Apa?</label>
                                        <div class="row g-3">
                                            <div class="col-6">
                                                <div class="p-4 option-card text-center h-100" onclick="selectOption('warna', 'Hitam', this)">
                                                    <div class="mx-auto mb-3 shadow-lg" style="width: 50px; height: 50px; background: #1a1a1a; border-radius: 12px; transform: rotate(-10deg);"></div>
                                                    <h5 class="fw-bold mb-0">Hitam Mamba</h5>
                                                    <small class="text-muted">Keren & Netral</small>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="p-4 option-card text-center h-100" onclick="selectOption('warna', 'Putih', this)">
                                                    <div class="mx-auto mb-3 shadow-sm border" style="width: 50px; height: 50px; background: #fff; border-radius: 12px; transform: rotate(10deg);"></div>
                                                    <h5 class="fw-bold mb-0">Putih Suci</h5>
                                                    <small class="text-muted">Bersih & Simpel</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="warna" id="inputWarna" required>
                                </div>

                                <div class="row justify-content-center">
                                    <div class="col-md-10">
                                        <label class="fw-bold mb-3 small text-uppercase text-muted ls-1">Ketebalan Kain?</label>
                                        <div class="row g-3">
                                            <div class="col-4">
                                                <div class="p-3 option-card text-center h-100" onclick="selectOption('ketebalan', '30s', this)">
                                                    <h3 class="fw-bold text-dark mb-1">30s</h3>
                                                    <small class="text-muted d-block">Adem</small>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="p-3 option-card text-center h-100" onclick="selectOption('ketebalan', '24s', this)">
                                                    <h3 class="fw-bold text-dark mb-1">24s</h3>
                                                    <small class="text-muted d-block">Pas</small>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="p-3 option-card text-center h-100" onclick="selectOption('ketebalan', '16s', this)">
                                                    <h3 class="fw-bold text-dark mb-1">16s</h3>
                                                    <small class="text-muted d-block">Tebal</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="ketebalan" id="inputKetebalan" required>
                                </div>

                                <div class="d-flex justify-content-center gap-3 mt-5">
                                    <button type="button" class="btn btn-light-modern btn-modern px-4" onclick="nextStep(2)">Back</button>
                                    <button type="button" class="btn btn-primary-modern btn-modern" onclick="submitAI()">
                                        <i class="bi bi-stars me-2"></i> Cek Cocoklogi AI
                                    </button>
                                </div>
                            </div>
                        </form>

                        <!-- LOADING -->
                        <div id="resultArea" style="display: none; padding: 60px 0;">
                            <div class="text-center">
                                <div class="spinner-grow text-warning mb-4" style="width: 3rem; height: 3rem;" role="status"></div>
                                <h4 class="fw-bold">Bentar ya, AI lagi mikir... 🧠</h4>
                                <p class="text-muted">Menghitung BMI & mencari stok gudang...</p>
                            </div>
                        </div>

                        <!-- RESULT -->
                        <div id="finalResult" style="display: none;">
                            <div class="result-box mb-5">
                                <div class="result-deco"></div>
                                <p class="text-white-50 text-uppercase fw-bold mb-0">Taraaa! Ukuran Pas Kamu Adalah</p>
                                <div class="size-highlight" id="resUkuran">XL</div>
                                <div class="badge badge-confidence rounded-pill px-4 py-2 mb-4">
                                    <i class="bi bi-check-circle-fill me-2"></i>Akurasi 99.9%
                                </div>
                                <p class="text-light opacity-75" id="resSaran">...</p>

                                <button class="btn btn-outline-light rounded-pill px-4 mt-4" onclick="location.reload()">
                                    <i class="bi bi-arrow-counterclockwise me-2"></i>Coba Lagi
                                </button>
                            </div>

                            <div class="d-flex align-items-center justify-content-between mb-4 px-2">
                                <h4 class="fw-bold mb-0 text-dark">Rekomendasi Outfit <span class="text-warning">🔥</span></h4>
                                <a href="{{ url('/produk') }}" class="text-decoration-none fw-bold text-warning small">Lihat Semua <i class="bi bi-arrow-right"></i></a>
                            </div>

                            <div class="row g-4" id="productGrid">
                                <!-- Cards -->
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Smooth Scroll to Top on Step Change
        function scrollToTop() {
            $('html, body').animate({ scrollTop: $(".ai-card").offset().top - 50 }, 500);
        }

        function nextStep(step) {
            if (step === 2) {
                if (!$('#tinggi').val() || !$('#berat').val()) {
                    // Modern Shake Effect for Error
                    $('#step1').addClass('shake');
                    setTimeout(() => $('#step1').removeClass('shake'), 500);
                    alert('Eits, Tinggi & Berat wajib diisi dulu ya! 😅');
                    return;
                }
            }

            $('.wizard-step').removeClass('active');
            setTimeout(() => {
                $('#step' + step).addClass('active');
            }, 300);

            // Update Progress
            let percent = '25%';
            if (step === 2) percent = '50%';
            if (step === 3) percent = '75%';
            $('.progress-fill').css('width', percent);

            scrollToTop();
        }

        function selectOption(type, value, element) {
            const container = $(element).closest('.row');
            if (type === 'warna') {
                $('#inputWarna').val(value);
                container.find('[onclick^="selectOption(\'warna\'"]').removeClass('selected');
            } else {
                $('#inputKetebalan').val(value);
                container.find('[onclick^="selectOption(\'ketebalan\'"]').removeClass('selected');
            }
            $(element).addClass('selected');
        }

        function submitAI() {
            if (!$('#inputWarna').val() || !$('#inputKetebalan').val()) {
                alert('Pilih dulu Warna & Ketebalannya dong 🙏');
                return;
            }

            $('#aiForm').fadeOut(300, function() {
                $('#resultArea').fadeIn();
                $('.progress-fill').css('width', '100%');
                scrollToTop();
            });

            const formData = {
                tinggi: $('#tinggi').val(),
                berat: $('#berat').val(),
                lingkar_dada: $('#lingkar_dada').val(),
                panjang_baju: $('#panjang_baju').val(),
                warna: $('#inputWarna').val(),
                ketebalan: $('#inputKetebalan').val(),
                _token: '{{ csrf_token() }}'
            };

            $.ajax({
                url: '{{ route("saran.ukuran.cek") }}',
                method: 'POST',
                data: formData,
                success: function(response) {
                    setTimeout(() => {
                        $('#resultArea').hide();
                        $('#finalResult').fadeIn();

                        $('#resUkuran').text(response.ukuran);
                        // Tampilkan Pesan AI (Cool Words) di sini, bukan analisis teknis
                        $('#resSaran').html('<i class="bi bi-chat-quote-fill text-warning me-2"></i>' + response.pesan_tambahan);

                        let html = '';
                        if (response.produk.length > 0) {
                            response.produk.forEach(p => {
                                let harga = new Intl.NumberFormat('id-ID', {
                                    style: 'currency',
                                    currency: 'IDR'
                                }).format(p.harga);
                                let imgUrl = `{{ asset('storage') }}/${p.gambar}`;
                                let detailUrl = `{{ url('/produk') }}/${p.id}`;

                                html += `
                                <div class="col-md-6 mb-4">
                                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden" style="transition: transform 0.3s;">
                                        <div class="position-relative h-100">
                                            <img src="${imgUrl}" class="card-img-top" style="height: 250px; object-fit: cover;" alt="${p.nama}">
                                            <div class="card-body text-center p-4">
                                                <h6 class="fw-bold text-dark mb-2 text-truncate">${p.nama}</h6>
                                                <p class="h5 text-warning fw-bold mb-3">${harga}</p>
                                                <a href="${detailUrl}" class="btn btn-primary-modern w-100 rounded-pill btn-sm">Bungkus Gan! 🛍️</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                `;
                            });
                        } else {
                            html = `<div class="col-12 text-center p-5"><div class="alert alert-warning rounded-4 border-0 fs-5">${response.pesan_tambahan}</div></div>`;
                        }
                        $('#productGrid').html(html);
                        scrollToTop();

                    }, 2500);
                },
                error: function() {
                    alert('Waduh, ada error nih. Refresh dulu ya!');
                    location.reload();
                }
            });
        }
    </script>
@endsection
