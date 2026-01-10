@extends('depan.layouts.main')

@section('title', 'Profil Saya')

@section('content')
    <div class="container py-5">
        <div class="row">
            <!-- Sidebar -->
            @include('depan.dashboard-menu.sidebar')

            <!-- Konten Profil -->
            <div class="col-md-9">

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert" id="pesan-alert">
                        <i class="bi bi-check-circle-fill me-2 text-success"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                <!-- Errors -->
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0" role="alert">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Profile Card View -->
                <div id="viewProfileCard" class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                    <div class="card-header border-0 p-0" style="height: 120px; background: linear-gradient(135deg, #ff7e14 0%, #ff512f 100%);">
                        <!-- Header Gradient -->
                    </div>
                    <div class="card-body p-4 position-relative">
                        <!-- Profile Photo -->
                        <div class="position-absolute top-0 start-0 translate-middle-y ms-4">
                            <div class="rounded-circle border border-4 border-white shadow bg-white d-flex align-items-center justify-content-center overflow-hidden" 
                                 style="width: 120px; height: 120px;">
                                @if($user->biodata && $user->biodata->foto)
                                    <img src="{{ asset('storage/' . $user->biodata->foto) }}" alt="Foto Profil" class="w-100 h-100 object-fit-cover">
                                @else
                                    <span class="fs-1 fw-bold text-orange">{{ substr($user->nama, 0, 1) }}</span>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Action Button -->
                        <div class="d-flex justify-content-end mb-4">
                             <button id="btnEditProfile" class="btn btn-outline-orange rounded-pill px-4">
                                <i class="bi bi-pencil-square me-2"></i> Edit Profil
                            </button>
                        </div>

                        <div class="mt-4 pt-2">
                             <h3 class="fw-bold mb-1">{{ $user->nama }}</h3>
                             <p class="text-muted mb-4"><i class="bi bi-envelope me-2"></i> {{ $user->email }}</p>

                             <h5 class="fw-bold fs-6 text-uppercase text-muted border-bottom pb-2 mb-3">Informasi Pribadi</h5>
                             
                             <div class="row g-3">
                                 <div class="col-md-6">
                                     <label class="small text-muted mb-1">Telepon</label>
                                     <p class="fw-semibold">{{ $user->biodata->telepon ?? '-' }}</p>
                                 </div>
                                 <div class="col-md-6">
                                     <label class="small text-muted mb-1">Username</label>
                                     <p class="fw-semibold">{{ $user->username }}</p>
                                 </div>
                                 <div class="col-12">
                                     <label class="small text-muted mb-1">Alamat Lengkap</label>
                                     <p class="fw-semibold">{{ $user->biodata->alamat_lengkap ?? '-' }}</p>
                                 </div>
                             </div>
                        </div>
                    </div>
                </div>

                <!-- Edit Profile Form (Hidden Default) -->
                <div id="editProfileCard" class="card border-0 shadow-sm rounded-4 d-none">
                    <div class="card-header bg-white border-0 py-4 px-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class="fw-bold mb-0">Edit Profil</h5>
                            <button type="button" id="btnCancelEdit" class="btn-close" aria-label="Close"></button>
                        </div>
                    </div>
                    
                    <div class="card-body p-4 pt-0">
                         <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Photo Upload Section -->
                            <div class="d-flex align-items-center gap-4 mb-4 p-3 bg-light rounded-3">
                                <div class="position-relative">
                                    <div class="rounded-circle bg-white border d-flex align-items-center justify-content-center overflow-hidden" 
                                         style="width: 80px; height: 80px;">
                                        <img id="previewFoto" 
                                             src="{{ ($user->biodata && $user->biodata->foto) ? asset('storage/' . $user->biodata->foto) : '' }}" 
                                             class="w-100 h-100 object-fit-cover {{ ($user->biodata && $user->biodata->foto) ? '' : 'd-none' }}">
                                        <span id="initialFoto" class="fs-2 fw-bold text-orange {{ ($user->biodata && $user->biodata->foto) ? 'd-none' : '' }}">
                                            {{ substr($user->nama, 0, 1) }}
                                        </span>
                                    </div>
                                    <label for="fotoInput" class="position-absolute bottom-0 end-0 bg-white shadow-sm border rounded-circle p-1 cursor-pointer" 
                                           style="cursor: pointer; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-camera-fill text-orange"></i>
                                    </label>
                                    <input type="file" name="foto" id="fotoInput" class="d-none" accept="image/*" onchange="previewImage(this)">
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1">Foto Profil</h6>
                                    <p class="small text-muted mb-0">Format: JPG, PNG. Maks 2MB.</p>
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Nama Lengkap</label>
                                    <input type="text" name="nama" value="{{ old('nama', $user->nama) }}" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Email</label>
                                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Nomor Telepon</label>
                                    <input type="text" name="telepon" value="{{ old('telepon', $user->biodata->telepon ?? '') }}" class="form-control">
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Alamat Lengkap</label>
                                    <textarea name="alamat_lengkap" class="form-control" rows="3">{{ old('alamat_lengkap', $user->biodata->alamat_lengkap ?? '') }}</textarea>
                                    <div class="form-text text-muted small">Alamat ini akan digunakan untuk pengiriman pesanan.</div>
                                </div>
                            </div>
                            
                            <hr class="my-4">
                            
                            <h6 class="fw-bold mb-3">Keamanan (Info Login)</h6>
                            <div class="alert alert-info border-0 d-flex gap-3 align-items-center small">
                                <i class="bi bi-shield-lock-fill fs-4"></i>
                                <div>
                                    Untuk mengubah username atau password, silakan gunakan form terpisah di bawah ini (opsional).
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <button type="button" id="btnCancelEdit2" class="btn btn-light rounded-pill px-4">Batal</button>
                                <button type="submit" class="btn btn-orange rounded-pill px-4 text-white">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Update Login Info Section (Only visible in Edit Mode? Or separate?) -->
                <!-- Let's keep it separate or collapsible to avoid clutter. 
                     For simplicity and UX, let's keep it in a separate card below the edit form 
                     BUT only show it when "Edit" is active? Or show it always?
                     
                     Better: Show it only when in "Effectively Editing" Mode or distinct section.
                     Currently, I'll put it in a separate simple card below everything, 
                     but only show it when Edit Mode is ACTIVE to keep the 'View' mode clean.
                -->
                <div id="securityCard" class="card border-0 shadow-sm rounded-4 mt-4 d-none">
                     <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                        <h5 class="fw-bold mb-0">Ubah Password & Username</h5>
                    </div>
                    <div class="card-body p-4">
                         <form method="POST" action="{{ route('profile.updateLogin') }}">
                            @csrf
                            @method('PUT')
                            <div class="row g-3">
                                 <div class="col-md-6">
                                    <label class="form-label fw-semibold">Username Baru</label>
                                    <input type="text" name="username" value="{{ old('username', $user->username) }}" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <!-- Spacer for grid -->
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Password Baru</label>
                                    <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak berubah">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Konfirmasi Password</label>
                                    <input type="password" name="password_confirmation" class="form-control">
                                </div>
                            </div>
                            <div class="mt-3 text-end">
                                <button type="submit" class="btn btn-warning rounded-pill px-4 text-white">Update Login</button>
                            </div>
                         </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <style>
        .object-fit-cover { object-fit: cover; }
        .bg-orange-soft { background-color: #fff3e0; }
        .text-orange { color: #ff7e14 !important; }
        .btn-outline-orange {
            color: #ff7e14;
            border-color: #ff7e14;
            transition: all 0.3s;
        }
        .btn-outline-orange:hover {
            background-color: #ff7e14;
            color: white;
        }
        .btn-orange {
            background-color: #ff7e14;
            border: none;
            transition: all 0.3s;
        }
        .btn-orange:hover {
             background-color: #e0690c;
             transform: translateY(-2px);
        }
    </style>

@section('scripts')
    <script>
        const viewCard = document.getElementById('viewProfileCard');
        const editCard = document.getElementById('editProfileCard');
        const securityCard = document.getElementById('securityCard');
        
        const btnEdit = document.getElementById('btnEditProfile');
        const btnCancel = document.getElementById('btnCancelEdit');
        const btnCancel2 = document.getElementById('btnCancelEdit2');

        function toggleEdit(isEditing) {
            if(isEditing) {
                viewCard.classList.add('d-none');
                editCard.classList.remove('d-none');
                securityCard.classList.remove('d-none');
            } else {
                viewCard.classList.remove('d-none');
                editCard.classList.add('d-none');
                securityCard.classList.add('d-none');
            }
        }

        btnEdit.addEventListener('click', () => toggleEdit(true));
        btnCancel.addEventListener('click', () => toggleEdit(false));
        btnCancel2.addEventListener('click', () => toggleEdit(false));

        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('previewFoto').src = e.target.result;
                    document.getElementById('previewFoto').classList.remove('d-none');
                    document.getElementById('initialFoto').classList.add('d-none');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
@endsection
