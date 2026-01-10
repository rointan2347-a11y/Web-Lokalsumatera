<div class="col-md-3 mb-4">
    <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="list-group list-group-flush">
                <!-- Dashboard -->
                <a href="/dashboardSaya"
                    class="list-group-item list-group-item-action border-0 px-4 py-3 d-flex align-items-center {{ Request::is('dashboardSaya*') ? 'active-menu' : '' }}">
                    <i class="bi bi-speedometer2 me-3 fs-5"></i> 
                    <span class="fw-semibold">Dashboard</span>
                </a>

                <!-- Pesanan -->
                <a href="/pesananSaya"
                    class="list-group-item list-group-item-action border-0 px-4 py-3 d-flex align-items-center {{ Request::is('pesananSaya*') ? 'active-menu' : '' }}">
                    <i class="bi bi-bag-check me-3 fs-5"></i>
                    <span class="fw-semibold">Pesanan</span>
                </a>

                <!-- Riwayat -->
                <a href="/riwayat-pesananSaya"
                    class="list-group-item list-group-item-action border-0 px-4 py-3 d-flex align-items-center {{ Request::is('riwayat-pesananSaya*') ? 'active-menu' : '' }}">
                    <i class="bi bi-clock-history me-3 fs-5"></i>
                    <span class="fw-semibold">Riwayat Pesanan</span>
                </a>

                <!-- Ulasan -->
                <a href="/ulasanSaya"
                    class="list-group-item list-group-item-action border-0 px-4 py-3 d-flex align-items-center {{ Request::is('ulasanSaya*') ? 'active-menu' : '' }}">
                    <i class="bi bi-star me-3 fs-5"></i>
                    <span class="fw-semibold">Ulasan Saya</span>
                </a>

                <!-- Profile -->
                <a href="/user-profile"
                    class="list-group-item list-group-item-action border-0 px-4 py-3 d-flex align-items-center {{ Request::is('user-profile*') ? 'active-menu' : '' }}">
                    <i class="bi bi-person-circle me-3 fs-5"></i>
                    <span class="fw-semibold">Profil Saya</span>
                </a>

                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}" id="logoutForm" class="m-0">
                    @csrf
                    <a href="javascript:void(0)" onclick="document.getElementById('logoutForm').submit();"
                        class="list-group-item list-group-item-action border-0 px-4 py-3 d-flex align-items-center text-danger">
                        <i class="bi bi-box-arrow-right me-3 fs-5"></i>
                        <span class="fw-semibold">Keluar</span>
                    </a>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    /* Sidebar Custom Styles */
    .list-group-item-action {
        color: #555;
        transition: all 0.2s ease-in-out;
    }

    .list-group-item-action:hover {
        background-color: #fff8f0; /* Orange pudar banget */
        color: #ff7e14; /* Orange Utama */
        padding-left: 1.8rem !important; /* Efek geser dikit */
    }

    .active-menu {
        background-color: #fff3e0 !important; /* Orange Soft background */
        color: #ff7e14 !important; /* Orange text */
        border-right: 4px solid #ff7e14 !important; /* Indikator aktif di kanan */
    }
</style>
