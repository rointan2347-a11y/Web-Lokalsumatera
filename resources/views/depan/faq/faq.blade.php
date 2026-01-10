@extends('depan.layouts.main')

@section('title', 'FAQ')

@section('content')
    <style>
        .judul-halaman {
            text-align: center;
            font-size: 2rem;
            color: #0a0909;
            font-weight: bold;
            padding: 10px 0;
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

        .accordion-button {
            font-weight: bold;
        }

        .faq-media {
            margin: 15px 0;
            text-align: center;
        }

        .faq-media img {
            max-width: 100%;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .faq-media iframe {
            width: 100%;
            max-width: 720px;
            height: 405px;
            border: none;
            border-radius: 8px;
        }
    </style>

    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="judul-halaman mb-4">Frequently Asked Questions (FAQ)</div>
            <div class="col-md-10">
                <div class="accordion" id="faqAccordion">

                    {{-- BERANDA --}}
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faqHome">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseHome" aria-expanded="true" aria-controls="collapseHome">
                                Apa yang bisa saya temukan di halaman Beranda?
                            </button>
                        </h2>
                        <div id="collapseHome" class="accordion-collapse collapse" aria-labelledby="faqHome"
                            data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Di halaman Beranda, Anda dapat melihat berbagai informasi terbaru seperti promo, rekomendasi
                                produk, dan akses cepat ke semua fitur utama aplikasi.
                            </div>
                        </div>
                    </div>

                    {{-- PRODUK --}}
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faqProduk1">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseProduk1" aria-expanded="false" aria-controls="collapseProduk1">
                                Apakah saya bisa memesan lebih dari satu baju dengan desain yang sama?
                            </button>
                        </h2>
                        <div id="collapseProduk1" class="accordion-collapse collapse" aria-labelledby="faqProduk1"
                            data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Tentu! Setelah menyimpan desain, Anda bisa menambahkannya ke keranjang dan menentukan jumlah
                                baju yang ingin dipesan dengan desain tersebut.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faqProduk2">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseProduk2" aria-expanded="false" aria-controls="collapseProduk2">
                                Berapa lama proses produksi dan pengiriman?
                            </button>
                        </h2>
                        <div id="collapseProduk2" class="accordion-collapse collapse" aria-labelledby="faqProduk2"
                            data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Proses produksi memakan waktu sekitar <strong>2–4 hari kerja</strong>. Pengiriman tergantung
                                lokasi Anda dan kurir yang dipilih, biasanya sekitar <strong>2–5 hari kerja</strong>.
                            </div>
                        </div>
                    </div>

                    {{-- SARAN UKURAN --}}
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faqUkuran">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseUkuran" aria-expanded="false" aria-controls="collapseUkuran">
                                Bagaimana cara menggunakan fitur Saran Ukuran?
                            </button>
                        </h2>
                        <div id="collapseUkuran" class="accordion-collapse collapse" aria-labelledby="faqUkuran"
                            data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Anda cukup memasukkan tinggi badan dan berat badan Anda, sistem kami akan merekomendasikan
                                ukuran baju yang paling sesuai untuk Anda.
                            </div>
                        </div>
                    </div>

                    {{-- DESAIN SENDIRI --}}
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faqDesain1">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseDesain1" aria-expanded="false" aria-controls="collapseDesain1">
                                Bagaimana cara membuat desain baju sendiri?
                            </button>
                        </h2>
                        <div id="collapseDesain1" class="accordion-collapse collapse" aria-labelledby="faqDesain1"
                            data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                <div class="faq-media">
                                    <img src="{{ asset('img/desain_sendiri.png') }}" alt="Panduan desain baju"
                                        class="img-fluid">
                                </div>
                                Anda bisa menggunakan fitur <strong>Desain Sendiri</strong> di menu utama. Unggah gambar,
                                pilih warna kaos, dan atur posisi desain sesuai keinginan, lalu simpan atau langsung pesan.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faqDesain2">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseDesain2" aria-expanded="false" aria-controls="collapseDesain2">
                                Format gambar apa yang didukung untuk desain?
                            </button>
                        </h2>
                        <div id="collapseDesain2" class="accordion-collapse collapse" aria-labelledby="faqDesain2"
                            data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Kami mendukung format <strong>PNG/JPG</strong>. Pastikan gambar memiliki resolusi tinggi
                                untuk
                                hasil cetak yang optimal dan tidak memiliki latar/background agar lebih rapi.
                            </div>
                        </div>
                    </div>

                    {{-- PREVIEW --}}
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faqPreview">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapsePreview" aria-expanded="false" aria-controls="collapsePreview">
                                Apa fungsi menu Preview?
                            </button>
                        </h2>
                        <div id="collapsePreview" class="accordion-collapse collapse" aria-labelledby="faqPreview"
                            data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Fitur Preview memungkinkan Anda melihat tampilan akhir desain kaos sebelum memutuskan untuk
                                memesan. Ini membantu memastikan desain sesuai keinginan.
                            </div>
                        </div>
                    </div>

                    {{-- KERANJANG --}}
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faqKeranjang">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseKeranjang" aria-expanded="false" aria-controls="collapseKeranjang">
                                Bagaimana cara melihat dan mengelola produk di keranjang?
                            </button>
                        </h2>
                        <div id="collapseKeranjang" class="accordion-collapse collapse" aria-labelledby="faqKeranjang"
                            data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Anda dapat membuka menu <strong>Keranjang</strong> dari navigasi bawah untuk melihat daftar
                                produk yang ingin dipesan, mengubah jumlah, atau menghapus item.
                            </div>
                        </div>
                    </div>

                    {{-- PENCARIAN --}}
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faqSearch">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseSearch" aria-expanded="false" aria-controls="collapseSearch">
                                Bagaimana cara mencari produk atau desain tertentu?
                            </button>
                        </h2>
                        <div id="collapseSearch" class="accordion-collapse collapse" aria-labelledby="faqSearch"
                            data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Gunakan ikon pencarian di bagian atas aplikasi untuk mengetik nama produk, jenis desain,
                                atau kategori tertentu yang Anda inginkan.
                            </div>
                        </div>
                    </div>

                    {{-- AKUN --}}
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faqAkun">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseAkun" aria-expanded="false" aria-controls="collapseAkun">
                                Bagaimana cara mengatur atau melihat informasi akun saya?
                            </button>
                        </h2>
                        <div id="collapseAkun" class="accordion-collapse collapse" aria-labelledby="faqAkun"
                            data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Buka menu <strong>Akun</strong> untuk melihat profil, alamat, riwayat pesanan, dan melakukan
                                perubahan data pribadi Anda.
                            </div>
                        </div>
                    </div>

                    {{-- TETAP: KESULITAN SAAT MENDESAIN --}}
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faqHelp">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseHelp" aria-expanded="false" aria-controls="collapseHelp">
                                Bagaimana jika saya mengalami kesulitan saat mendesain?
                            </button>
                        </h2>
                        <div id="collapseHelp" class="accordion-collapse collapse" aria-labelledby="faqHelp"
                            data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Jangan khawatir! Anda bisa menghubungi tim kami melalui menu <strong>Kontak Kami</strong>
                                atau <strong>Tonton video di bawah</strong>.

                                <div class="faq-media mt-3">
                                    <iframe width="560" height="315"
                                        src="https://www.youtube.com/embed/nv-7OI3trb4?si=3ql3OrzEGNZOsWgq"
                                        title="YouTube video player" frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                                </div>
                                <p class="text-muted text-center mt-2">Tonton video panduan desain untuk membantu Anda</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection