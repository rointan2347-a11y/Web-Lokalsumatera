<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Dashboard Admin Premium">
    <meta name="author" content="Lokal Sumatera">

    <title>@yield('title') - Admin Lokal Sumatera</title>

    <!-- Google Fonts: Outfit (Modern) & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    
    <!-- SB Admin 2 CSS -->
    <link href="{{ asset('assets/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <!-- PREMIUM ADMIN THEME OVERRIDES -->
    <style>
        :root {
            /* Palette Colours */
            --primary: #ff7e14; /* Lokal Sumatera Orange */
            --primary-dark: #cc5f00;
            --primary-light: #fff4e6;
            --secondary: #1e1e2d; /* Deep Charcoal Sidebar */
            --secondary-light: #2d2d44;
            --bg-body: #f3f4f6;
            --text-dark: #2c3e50;
            --text-muted: #8898aa;
            
            /* Effects */
            --radius-xl: 20px;
            --radius-lg: 15px;
            --shadow-soft: 0 10px 40px rgba(0,0,0,0.04);
            --shadow-hover: 0 20px 50px rgba(255, 126, 20, 0.15);
            --glass: rgba(255, 255, 255, 0.95);
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-dark);
        }

        h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6 {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            color: var(--secondary);
        }

        /* --- SIDEBAR UPGRADE --- */
        .sidebar {
            background: var(--secondary) !important;
            background-image: linear-gradient(180deg, var(--secondary) 10%, #151520 100%) !important;
            box-shadow: 5px 0 30px rgba(0,0,0,0.05);
        }
        
        .sidebar-brand-text {
            font-family: 'Outfit', sans-serif;
            letter-spacing: 1px;
            font-weight: 800;
        }

        .sidebar .nav-item .nav-link {
            border-radius: var(--radius-lg);
            margin: 0 12px;
            padding: 12px 20px;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            font-weight: 500;
            color: rgba(255,255,255,0.6) !important;
        }

        .sidebar .nav-item .nav-link:hover {
            background: rgba(255,255,255,0.08);
            color: #fff !important;
            transform: translateX(5px);
        }

        .sidebar .nav-item .nav-link i {
            color: rgba(255,255,255,0.4);
            transition: 0.3s;
        }
        
        .sidebar .nav-item.active .nav-link {
            background: var(--primary);
            box-shadow: 0 10px 20px rgba(255, 126, 20, 0.3);
            color: #fff !important;
            font-weight: 700;
        }

        .sidebar .nav-item.active .nav-link i {
            color: #fff;
        }

        /* --- CARD UPGRADE --- */
        .card {
            border: none;
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-soft);
            transition: all 0.3s ease;
            background: #fff;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-hover);
        }

        .card-header {
            background: transparent;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            padding: 20px 25px;
        }

        .card-header h6 {
            font-weight: 700;
            color: var(--secondary);
            letter-spacing: 0.5px;
            text-transform: uppercase;
            font-size: 0.85rem;
        }

        /* --- BUTTONS --- */
        .btn-primary {
            background: var(--primary);
            border: none;
            border-radius: 50px;
            padding: 10px 25px;
            box-shadow: 0 5px 15px rgba(255, 126, 20, 0.3);
            transition: 0.3s;
            font-weight: 600;
            font-family: 'Outfit', sans-serif;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            box-shadow: 0 8px 25px rgba(255, 126, 20, 0.4);
            transform: translateY(-2px);
        }

        .btn-icon-split {
            border-radius: 50px;
            overflow: hidden;
            padding: 0;
        }
        .btn-icon-split .icon {
            background: rgba(0,0,0,0.1);
        }

        /* --- FORMS --- */
        .form-control {
            border-radius: 12px;
            padding: 12px 18px;
            height: auto;
            border: 2px solid #eaecf4;
            background: #fcfcfd;
            font-size: 0.95rem;
            transition: 0.3s;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px var(--primary-light);
            background: #fff;
        }

        label {
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--secondary);
            margin-bottom: 8px;
        }

        /* --- TABLE --- */
        .table thead th {
            background: var(--secondary-light);
            color: #fff;
            border: none;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 1px;
            padding: 15px;
        }
        
        .table tbody td {
            vertical-align: middle;
            padding: 15px;
            font-size: 0.95rem;
            border-bottom: 1px solid #f0f0f5;
        }

        .table-hover tbody tr:hover {
            background-color: var(--primary-light);
        }

        .img-thumbnail {
            border-radius: 10px;
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        /* Stats Cards (Dashboard) */
        .border-left-primary { border-left: 5px solid var(--primary) !important; }
        .border-left-success { border-left: 5px solid #00c853 !important; }
        .border-left-info { border-left: 5px solid #00b0ff !important; }
        .border-left-warning { border-left: 5px solid #ffd600 !important; }
        
        .text-xs { font-size: 0.8rem; letter-spacing: 1px; }

    </style>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        @include('admin.layouts.sidebar')
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                @include('admin.layouts.navbar')
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                     <!-- Page Heading -->
                     <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">@yield('title')</h1>
                    </div>

                    @yield('content')
                    <!-- /.container-fluid -->

                </div>
                <!-- End of Main Content -->
                
            </div>
            <!-- End of Content Div -->

            <!-- Footer -->
            @include('admin.layouts.footer')
            <!-- Footer includes closing wrappers -->

