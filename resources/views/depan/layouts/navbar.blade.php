<!-- Announcement Bar -->
<div class="bg-dark text-white py-2 small fw-bold text-center">
    <a href="https://docs.google.com/forms/d/e/1FAIpQLSdwmUl7Dw4iGr8b8E_EezlvqqalM6Xy5P6Q2IIE3O-LVQLxKQ/viewform" target="_blank" class="text-white text-decoration-none">
        <i class="bi bi-megaphone-fill text-orange me-2"></i> Bantu isi kuisioner kami dan dapatkan promo menarik! <span class="text-decoration-underline ms-1">Klik di sini</span>
    </a>
</div>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top shadow-sm py-3" style="transition: all 0.3s;">
    <div class="container">
        <a class="navbar-brand fw-bold fs-4" href="/" style="letter-spacing: -0.5px;">
            LOKAL <span class="text-orange">SUMATERA</span>
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0 fw-semibold">
                <li class="nav-item px-2"><a class="nav-link {{ Request::is('/') ? 'active text-orange' : '' }}" href="/">Beranda</a></li>
                <li class="nav-item px-2"><a class="nav-link {{ Request::is('produk*') ? 'active text-orange' : '' }}" href="/produk">Katalog</a></li>
                
                @auth
                    @if (Auth::user()->role == 'user')
                        <li class="nav-item px-2"><a class="nav-link {{ Request::is('saran-ukuran*') ? 'active text-orange' : '' }}" href="/saran-ukuran">AI Fitting <span class="badge bg-orange rounded-pill ms-1" style="font-size:0.6rem;">NEW</span></a></li>
                        <li class="nav-item px-2"><a class="nav-link {{ Request::is('desain_sendiri*') ? 'active text-orange' : '' }}" href="/desain_sendiri">Custom Desain</a></li>
                    @endif
                @endauth

                @guest
                    <li class="nav-item px-2"><a class="nav-link {{ Request::is('saran-ukuran*') ? 'active text-orange' : '' }}" href="/saran-ukuran">AI Fitting <span class="badge bg-orange rounded-pill ms-1" style="font-size:0.6rem;">NEW</span></a></li>
                    <li class="nav-item px-2"><a class="nav-link {{ Request::is('desain_sendiri*') ? 'active text-orange' : '' }}" href="/desain_sendiri">Custom Desain</a></li>
                @endguest
            </ul>

            <ul class="navbar-nav align-items-center gap-3">
                <!-- Search -->
                <li class="nav-item d-none d-lg-block">
                    <a class="nav-link text-dark" href="/produk"><i class="bi bi-search fs-5"></i></a>
                </li>

                <!-- Cart -->
                <li class="nav-item position-relative">
                    @php
                        $keranjang = \App\Models\Keranjang::where('user_id', auth()->id())->first();
                        $total_keranjang = $keranjang ? $keranjang->items()->sum('jumlah') : 0;
                    @endphp
                    <a class="nav-link text-dark position-relative" href="/keranjang">
                        <i class="bi bi-bag fs-5"></i>
                        @if ($total_keranjang)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-orange border border-light">
                                {{ $total_keranjang }}
                            </span>
                        @endif
                    </a>
                </li>

                <!-- User Auth -->
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle btn btn-light rounded-pill px-3 py-1 border d-flex align-items-center gap-2" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            @if(Auth::user()->biodata && Auth::user()->biodata->foto)
                                <img src="{{ asset('storage/' . Auth::user()->biodata->foto) }}" alt="Foto" class="rounded-circle border" style="width: 25px; height: 25px; object-fit: cover;">
                            @else
                                <div class="bg-orange text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 25px; height: 25px; font-size: 0.8rem;">
                                    {{ substr(Auth::user()->nama, 0, 1) }}
                                </div>
                            @endif
                            <span class="small">{{ Auth::user()->nama }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 p-2" aria-labelledby="navbarDropdown">
                            @if (Auth::user()->role === 'admin')
                                <li><a class="dropdown-item rounded-3 mb-1" href="/admin/dashboard"><i class="bi bi-speedometer2 me-2 text-warning"></i>Dashboard</a></li>
                            @else
                                <li><a class="dropdown-item rounded-3 mb-1" href="/dashboardSaya"><i class="bi bi-grid me-2 text-primary"></i>Dashboard Saya</a></li>
                            @endif
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="/logout" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item rounded-3 text-danger"><i class="bi bi-box-arrow-right me-2"></i>Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endauth

                @guest
                    <li class="nav-item">
                        <a href="/login" class="btn btn-dark rounded-pill px-4 fw-bold small">Masuk</a>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

<!-- CSS -->
<style>
    .running-text-container {
        width: 100%;
        overflow: hidden;
        /* background-color: #f8d7da;  merah muda lembut */
        padding: 8px 0;
    }

    .running-text-link {
        text-decoration: none;
        color: black;
        font-weight: bold;
    }

    .running-text-link:hover {
        text-decoration: underline;
    }

    .running-text {
        display: inline-block;
        white-space: nowrap;
        animation: scroll-left 15s linear infinite;
        padding-left: 100%;
    }

    @keyframes scroll-left {
        0% {
            transform: translateX(0);
        }

        100% {
            transform: translateX(-100%);
        }
    }
</style>