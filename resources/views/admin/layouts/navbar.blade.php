<nav class="navbar navbar-expand navbar-light topbar mb-4 static-top" style="background: transparent; border-bottom: 1px solid rgba(0,0,0,0.03);">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3 text-secondary">
        <i class="fa fa-bars"></i>
    </button>

    <h5 class="mr-2 mt-2 d-none d-lg-inline text-secondary font-weight-bold" style="letter-spacing: 0.5px;">
        <span class="text-primary">Admin</span> Panel
    </h5>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">
        <div class="topbar-divider d-none d-sm-block scale-0"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                
                <div class="text-right mr-3 d-none d-lg-block">
                    <span class="text-secondary small font-weight-bold d-block" style="line-height: 1.2;">Halo, Admin</span>
                    <span class="text-xs text-muted font-weight-bold">{{ Auth::user()->email }}</span>
                </div>
                
                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center shadow-sm" style="width: 40px; height: 40px; font-weight: bold; font-family: 'Outfit', sans-serif;">
                    A
                </div>
            </a>

            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow-lg animated--grow-in border-0 rounded-lg p-2" aria-labelledby="userDropdown">
                <a class="dropdown-item rounded-md py-2" href="/admin/profile">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-primary opacity-50"></i>
                    Profile Saya
                </a>
                <div class="dropdown-divider my-2 opacity-50"></div>
                <!-- Logout -->
                <a class="dropdown-item rounded-md py-2 text-danger" href="#"
                    onclick="event.preventDefault(); if(confirm('Yakin ingin logout?')) { document.getElementById('logout-form').submit(); }">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2"></i>
                    Keluar Sesi
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </li>
    </ul>

</nav>
