<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center py-4" href="/admin/dashboard">
        <div class="sidebar-brand-icon">
            <i class="fas fa-tshirt fa-2x text-primary shadow-sm" style="color: #ff7e14 !important; filter: drop-shadow(0 0 10px rgba(255,126,20,0.5));"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Lokal <span style="color: #ff7e14;">Sumatera</span></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0 mb-3 opacity-25">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ Request::is('admin/dashboard*') ? 'active' : '' }} mb-2">
        <a class="nav-link" href="/admin/dashboard">
            <i class="fas fa-fw fa-fire"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <div class="sidebar-heading mt-3 mb-2 opacity-50">MANAJEMEN UTAMA</div>

    <li class="nav-item {{ Request::is('admin/produk*') ? 'active' : '' }} mb-1">
        <a class="nav-link" href="/admin/produk">
            <i class="fas fa-fw fa-box-open"></i>
            <span>Produk & Stok</span>
        </a>
    </li>
    
    <li class="nav-item {{ Request::is('admin/desain*') ? 'active' : '' }} mb-1">
        <a class="nav-link" href="/admin/desain">
            <i class="fas fa-fw fa-palette"></i>
            <span>Desain Kustom</span>
        </a>
    </li>

    <li class="nav-item {{ Request::is('admin/pesanan*') ? 'active' : '' }} mb-2">
        <a class="nav-link" href="/admin/pesanan">
            <i class="fas fa-fw fa-shopping-bag"></i>
            <span>Pesanan Masuk</span>
        </a>
    </li>

    <div class="sidebar-heading mt-3 mb-2 opacity-50">SISTEM & USER</div>

    <li class="nav-item {{ Request::is('admin/user*') ? 'active' : '' }} mb-1">
        <a class="nav-link" href="/admin/user">
            <i class="fas fa-fw fa-users"></i>
            <span>Data Pengguna</span>
        </a>
    </li>

    <li class="nav-item {{ Request::is('admin/rekening*') ? 'active' : '' }} mb-1">
        <a class="nav-link" href="/admin/rekening">
            <i class="fas fa-fw fa-credit-card"></i>
            <span>Rekening Bank</span>
        </a>
    </li>

    <li class="nav-item {{ Request::is('admin/profile*') ? 'active' : '' }} mb-1">
        <a class="nav-link" href="/admin/profile">
            <i class="fas fa-fw fa-user-circle"></i>
            <span>Profil Admin</span>
        </a>
    </li>
    
    <div class="sidebar-heading mt-3 mb-2 opacity-50">WEBSITE DEPAN</div>

    <li class="nav-item {{ Request::is('admin/berandaWeb*') ? 'active' : '' }} mb-1">
        <a class="nav-link" href="/admin/berandaWeb">
            <i class="fas fa-fw fa-laptop-code"></i>
            <span>Konten Beranda</span>
        </a>
    </li>
    
    <li class="nav-item mt-2">
        <a class="nav-link" href="/" target="_blank">
            <i class="fas fa-fw fa-external-link-alt"></i>
            <span>Lihat Website</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block mt-4 opacity-25">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0 bg-white opacity-25" id="sidebarToggle"></button>
    </div>

</ul>
