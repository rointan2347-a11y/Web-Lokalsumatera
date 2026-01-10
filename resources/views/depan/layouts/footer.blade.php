<footer class="bg-dark text-white py-5 mt-5 position-relative overflow-hidden">
    <!-- Decorative Circle -->
    <div class="position-absolute top-0 end-0 bg-orange opacity-10 rounded-circle" style="width: 300px; height: 300px; transform: translate(30%, -30%); filter: blur(50px);"></div>

    <div class="container position-relative z-2">
        <div class="row g-4">
            <!-- Brand Info -->
            <div class="col-lg-4 col-md-6">
                <h4 class="fw-bold mb-3" style="font-family: 'Outfit', sans-serif;">LOKAL <span class="text-orange">SUMATERA</span></h4>
                <p class="text-white-50 mb-4" style="line-height: 1.8;">
                    Memberdayakan gaya lokal dengan sentuhan modern. Kami menghadirkan kualitas terbaik dari jantung Sumatera untuk Indonesia.
                </p>
                <div class="d-flex gap-2">
                    <a href="https://instagram.com/lokalsumatera" class="btn btn-outline-light rounded-circle" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;"><i class="bi bi-instagram"></i></a>
                    <a href="https://wa.me/6282377885282" class="btn btn-outline-light rounded-circle" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;"><i class="bi bi-whatsapp"></i></a>
                    <a href="#" class="btn btn-outline-light rounded-circle" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;"><i class="bi bi-facebook"></i></a>
                </div>
            </div>

            <!-- Navigation -->
            <div class="col-lg-2 col-md-3 col-6">
                <h6 class="fw-bold mb-3 text-orange">Menu Utama</h6>
                <ul class="list-unstyled d-flex flex-column gap-2">
                    <li><a href="/" class="text-white-50 text-decoration-none hover-orange transition-all">Beranda</a></li>
                    <li><a href="/produk" class="text-white-50 text-decoration-none hover-orange transition-all">Katalog Produk</a></li>
                    <li><a href="/saran-ukuran" class="text-white-50 text-decoration-none hover-orange transition-all">AI Smart Fitting</a></li>
                    <li><a href="/desain_sendiri" class="text-white-50 text-decoration-none hover-orange transition-all">Custom Desain</a></li>
                </ul>
            </div>

            <div class="col-lg-2 col-md-3 col-6">
                <h6 class="fw-bold mb-3 text-orange">Bantuan</h6>
                <ul class="list-unstyled d-flex flex-column gap-2">
                    <li><a href="/faq" class="text-white-50 text-decoration-none hover-orange transition-all">FAQ</a></li>
                    <li><a href="#" class="text-white-50 text-decoration-none hover-orange transition-all">Cara Pemesanan</a></li>
                    <li><a href="#" class="text-white-50 text-decoration-none hover-orange transition-all">Kebijakan Retur</a></li>
                    <li><a href="#" class="text-white-50 text-decoration-none hover-orange transition-all">Konfirmasi Pembayaran</a></li>
                </ul>
            </div>

            <!-- Contact -->
            <div class="col-lg-4 col-md-12">
                <h6 class="fw-bold mb-3 text-orange">Hubungi Kami</h6>
                <ul class="list-unstyled text-white-50 d-flex flex-column gap-3">
                    <li class="d-flex gap-3">
                        <i class="bi bi-geo-alt fs-5 text-orange"></i>
                        <span>Jl. Jendral Sudirman No. 123, Palembang,<br>Sumatera Selatan 30129</span>
                    </li>
                    <li class="d-flex gap-3">
                        <i class="bi bi-envelope fs-5 text-orange"></i>
                        <span>hello@lokalsumatera.com</span>
                    </li>
                    <li class="d-flex gap-3">
                        <i class="bi bi-telephone fs-5 text-orange"></i>
                        <span>+62 823-7788-5282</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="border-top border-secondary mt-5 pt-4 text-center text-white-50 small">
            <p class="mb-0">&copy; {{ date('Y') }} Lokal Sumatera. Dibuat dengan dan kebanggaan lokal.</p>
        </div>
    </div>
    
    <style>
        .hover-orange:hover {
            color: #ff7e14 !important;
            padding-left: 5px;
        }
        .transition-all {
            transition: all 0.3s ease;
        }
    </style>
</footer>



<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    setTimeout(function () {
        let alert = document.getElementById('pesan-alert');
        if (alert) {
            alert.remove();
        }
    }, 4000);
</script>
<!-- jQuery (Required for AI Wizard) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@yield('scripts')

</body>

</html>