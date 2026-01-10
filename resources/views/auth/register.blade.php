@extends('depan.layouts.main')

@section('content')
<!-- Font Import -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

<style>
    :root {
        --primary: #ff7e14;
        --primary-hover: #e6690b;
        --secondary: #1e1e2d;
        --text-dark: #2c3e50;
        --text-muted: #8898aa;
        --bg-input: #f8f9fa;
        --radius-lg: 16px;
        --radius-md: 12px;
    }

    body {
        font-family: 'Inter', sans-serif;
        background-color: #fcfcfd;
    }

    .auth-wrapper {
        min-height: 85vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
        background: radial-gradient(circle at top right, rgba(255, 126, 20, 0.03) 0%, transparent 40%),
                    radial-gradient(circle at bottom left, rgba(30, 30, 45, 0.02) 0%, transparent 40%);
    }

    .auth-card {
        background: white;
        border-radius: var(--radius-lg);
        border: none;
        box-shadow: 0 20px 60px rgba(0,0,0,0.06);
        max-width: 550px; /* Slightly wider for registration */
        width: 100%;
        overflow: hidden;
        position: relative;
        transition: transform 0.3s ease;
    }

    .auth-card:hover {
        transform: translateY(-5px);
    }

    /* Decorative top line */
    .auth-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 6px;
        background: linear-gradient(90deg, var(--primary) 0%, #ffad60 100%);
    }

    .card-header-custom {
        padding: 40px 40px 10px 40px;
        text-align: center;
        background: white;
    }

    .brand-title {
        font-family: 'Outfit', sans-serif;
        font-weight: 700;
        font-size: 28px;
        color: var(--secondary);
        margin-bottom: 8px;
        letter-spacing: -0.5px;
    }

    .brand-subtitle {
        color: var(--text-muted);
        font-size: 15px;
    }

    .card-body-custom {
        padding: 30px 40px 50px 40px;
    }

    .form-group-custom {
        margin-bottom: 20px;
        position: relative;
    }

    .form-group-custom label {
        font-weight: 600;
        font-size: 13px;
        color: var(--secondary);
        margin-bottom: 8px;
        display: block;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .input-wrapper {
        position: relative;
    }

    .input-wrapper i {
        position: absolute;
        left: 18px;
        top: 50%;
        transform: translateY(-50%);
        color: #a0aec0;
        font-size: 18px;
        transition: 0.3s;
    }

    .form-control-custom {
        width: 100%;
        padding: 14px 18px 14px 50px;
        border: 2px solid #ebedf0;
        border-radius: var(--radius-md);
        background: var(--bg-input);
        font-size: 15px;
        color: var(--secondary);
        transition: all 0.3s ease;
        outline: none;
    }

    .form-control-custom:focus {
        border-color: var(--primary);
        background: white;
        box-shadow: 0 0 0 4px rgba(255, 126, 20, 0.1);
    }

    .form-control-custom:focus + i,
    .input-wrapper:focus-within i {
        color: var(--primary);
    }

    .btn-auth {
        width: 100%;
        padding: 16px;
        background: var(--primary);
        color: white;
        border: none;
        border-radius: 50px;
        font-weight: 600;
        font-family: 'Outfit', sans-serif;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.3s;
        box-shadow: 0 10px 20px rgba(255, 126, 20, 0.25);
        margin-top: 15px;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
    }

    .btn-auth:hover {
        background: var(--primary-hover);
        transform: translateY(-2px);
        box-shadow: 0 15px 30px rgba(255, 126, 20, 0.35);
    }

    .login-link {
        margin-top: 25px;
        text-align: center;
        font-size: 14px;
        color: var(--text-muted);
    }

    .login-link a {
        color: var(--primary);
        font-weight: 700;
        text-decoration: none;
        transition: 0.2s;
    }

    .login-link a:hover {
        text-decoration: underline;
        color: var(--primary-hover);
    }

    .alert-custom {
        border-radius: var(--radius-md);
        font-size: 14px;
        border: none;
        margin-bottom: 25px;
    }
    
    .alert-danger-custom {
        background-color: #fef2f2;
        color: #991b1b;
        border-left: 4px solid #ef4444;
    }
</style>

<div class="auth-wrapper">
    <div class="auth-card">
        <div class="card-header-custom">
            <h1 class="brand-title">Daftar <span style="color: var(--primary);">Lokal Sumatera</span></h1>
            <p class="brand-subtitle">Bergabunglah dan nikmati pengalaman belanja kaos kustom terbaik</p>
        </div>

        <div class="card-body-custom">
            
            @if ($errors->any())
                <div class="alert alert-custom alert-danger-custom p-3">
                    <ul class="mb-0 pl-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register.proses') }}">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group-custom">
                            <label for="nama">Nama Lengkap</label>
                            <div class="input-wrapper">
                                <input type="text" name="nama" id="nama" class="form-control-custom" placeholder="Nama Anda" value="{{ old('nama') }}" required autofocus>
                                <i class="far fa-user"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group-custom">
                            <label for="username">Username</label>
                            <div class="input-wrapper">
                                <input type="text" name="username" id="username" class="form-control-custom" placeholder="Username" value="{{ old('username') }}" required>
                                <i class="fas fa-at"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group-custom">
                    <label for="email">Alamat Email</label>
                    <div class="input-wrapper">
                        <input type="email" name="email" id="email" class="form-control-custom" placeholder="nama@email.com" value="{{ old('email') }}" required>
                        <i class="far fa-envelope"></i>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group-custom">
                            <label for="password">Kata Sandi</label>
                            <div class="input-wrapper">
                                <input type="password" name="password" id="password" class="form-control-custom" placeholder="••••••••" required>
                                <i class="fas fa-lock"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group-custom">
                            <label for="password_confirmation">Konfirmasi Sandi</label>
                            <div class="input-wrapper">
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control-custom" placeholder="••••••••" required>
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-auth">
                    Buat Akun Sekarang <i class="fas fa-arrow-right"></i>
                </button>
            </form>

            <div class="login-link">
                Sudah punya akun? <a href="/login">Masuk disini</a>
            </div>
        </div>
    </div>
</div>
@endsection
