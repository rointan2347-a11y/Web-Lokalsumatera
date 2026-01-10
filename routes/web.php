<?php

use App\Http\Controllers\depan\UserDashboardController as UserDashboardController;
use App\Http\Controllers\depan\ProdukController as DepanProdukController;
use App\Http\Controllers\depan\DesainSendiriController as DepanDesainSendiriController;
use App\Http\Controllers\depan\pesananController as DepanPesananController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProdukController as AdminProdukController;
use App\Http\Controllers\Auth\LoginController as AuthLoginController;
use App\Http\Controllers\Admin\DesainController as AdminDesainKaosController;
use App\Http\Controllers\Admin\PesananController as AdminPesananController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\RekeningController as AdminRekeningController;

use App\Http\Controllers\BiodataController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\ProdukController;
use App\Models\BerandaWeb;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/link-storage', function () {
    if (app()->environment('local')) {
        Artisan::call('storage:link');
        return 'Storage link created';
    }
    abort(403);
});


Route::get('/faq', function () {
    return view('depan.faq.faq');
});

Route::get('/', function () {
  $produk = Produk::withCount('ulasan')
    ->withAvg('ulasan', 'rating')
    ->take(8)
    ->get();
    $produkBaruCount = Produk::where('created_at', '>=', Carbon::now()->subDays(7))->count();
    $beranda = BerandaWeb::first();
    $user = User::where('role', 'user')->count();
    return view('beranda', compact('produk', 'beranda', 'user', 'produkBaruCount'));
});

// Admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'adminDashboard'])->name('admin.dashboard');

    Route::resource('/admin/produk', AdminProdukController::class);
    Route::resource('/admin/desain', AdminDesainKaosController::class);
    Route::resource('/admin/rekening', AdminRekeningController::class);
    
    // AI Product Wizard
    Route::post('/admin/produk/generate-ai', [AdminProdukController::class, 'ajaxGenerateContent'])->name('admin.produk.generateAi');

    // admin beranda web
    Route::get('/admin/berandaWeb', [AdminDashboardController::class, 'adminBerandaWeb'])->name('admin.berandaWeb.index');
    Route::get('/admin/berandaWeb/edit', [AdminDashboardController::class, 'adminBerandaWebEdit'])->name('admin.berandaWeb.edit');
    Route::put('/admin/berandaWeb', [AdminDashboardController::class, 'adminBerandaWebUpdate'])->name('admin.berandaWeb.update');

    // Pesanan
    Route::get('/admin/pesanan', [AdminPesananController::class, 'index'])->name('admin.pesanan.index');
    Route::get('/admin/pesanan/{id}', [AdminPesananController::class, 'show'])->name('admin.pesanan.detail');
    Route::put('/admin/pesanan/{id}/status', [AdminPesananController::class, 'updateStatus'])->name('admin.pesanan.updateStatus');

    Route::get('/admin/pesanan/{id}/desain-print', [AdminPesananController::class, 'previewDesain'])->name('admin.preview.desain');

    // Pengguna
    Route::get('/admin/user', [AdminUserController::class, 'index'])->name('admin.user.index');
    Route::get('/admin/user/{id}', [AdminUserController::class, 'show'])->name('admin.user.show');

    // Profile
    Route::get('/admin/profile', [AdminProfileController::class, 'index'])->name('admin.profile.index');
    Route::get('/admin/profile/edit', [AdminProfileController::class, 'edit'])->name('admin.profile.edit');
    Route::put('/admin/profile/update', [AdminProfileController::class, 'update'])->name('admin.profile.update');
});

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/dashboardSaya', [UserDashboardController::class, 'userDashboard'])->name('user.dashboard');

    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
    Route::post('/keranjang/tambah', [KeranjangController::class, 'tambahItemKeranjang'])->name('keranjang.tambah.item');
    Route::delete('/keranjang/hapus/{id}', [KeranjangController::class, 'hapus'])->name('keranjang.hapus');
    Route::get('/checkout/{id}', [KeranjangController::class, 'checkoutForm'])->name('checkout.form');
    Route::post('/checkout/{id}', [KeranjangController::class, 'checkoutProses'])->name('checkout.proses');

    Route::get('/pesananSaya', [DepanPesananController::class, 'index'])->name('pesanan.user.index');
    Route::get('/pesananSaya/{id}', [DepanPesananController::class, 'show'])->name('pesanan.user.show');

    Route::put('/pesanan/terima/{id}', [DepanPesananController::class, 'terimaPesanan'])->name('pesanan.user.terima');

    Route::put('/pesanan/{id}/batal', [DepanPesananController::class, 'batalkan'])->name('pesanan.user.batal');
    Route::delete('/pesanan/{id}/hapus', [DepanPesananController::class, 'hapus'])->name('pesanan.user.hapus');

    Route::get('/riwayat-pesananSaya', [DepanPesananController::class, 'riwayat'])->name('pesanan.user.riwayat');
    Route::get('/riwayat-pesananSaya/{id}', [DepanPesananController::class, 'showRiwayat'])->name('riwayat.pesanan.detail');

    // Ulasan
    Route::get('/ulasanSaya', [DepanPesananController::class, 'ulasanSaya'])->name('ulasan.saya');
    Route::get('/ulasanSaya/ulasan-form/{id}', [DepanPesananController::class, 'formUlasan'])->name('ulasan.form');
    Route::post('/ulasanSaya/ulasan-store/{id}', [DepanPesananController::class, 'ulasanFormStore'])->name('ulasan.form.store');


    // biodata
    Route::get('/user-biodata', [BiodataController::class, 'create'])->name('biodata.create');
    Route::post('/user-biodata', [BiodataController::class, 'store'])->name('biodata.simpan');

    // Profile
    Route::get('/user-profile', [BiodataController::class, 'showProfile'])->name('profile.show');
    Route::put('/user-profile', [BiodataController::class, 'updateProfile'])->name('profile.update');

    Route::put('/profil-login', [BiodataController::class, 'updateLogin'])->name('profile.updateLogin')->middleware('auth');


    Route::get('/desain_sendiri', [DepanDesainSendiriController::class, 'index'])->name('desain.sendiri');
    Route::post('/desain_sendiri', [DepanDesainSendiriController::class, 'desainSendiriSimpan'])->name('kaos.kustom.store');

    Route::delete('/desain-sendiri/destroy/{id}', [DepanDesainSendiriController::class, 'hapusDesainSaya'])->name('desain.sendiri.destroy');

    Route::post('/desain_user_upload', [DepanDesainSendiriController::class, 'uploadDesainUser'])->name('desain.user.upload');
    Route::delete('/desain-user/{id}', [DepanDesainSendiriController::class, 'userDesainUploadHapus'])->name('desain.user.delete');

    Route::get('/preview-desain', [DepanDesainSendiriController::class, 'showPreview'])->name('preview.desain');


    Route::get('/saran-ukuran', [DepanDesainSendiriController::class, 'saranUkuran']);
    Route::post('/saran-ukuran', [DepanDesainSendiriController::class, 'cekUkuran'])->name('saran.ukuran.cek');
    // Route::get('/desain-360', function () {
    //     return view('depan.desain_sendiri.desain360');
    // });
});

// Produk
Route::get('/produk', [DepanProdukController::class, 'index'])->name('produk.depan');
Route::get('/produk/{id}', [DepanProdukController::class, 'show'])->name('produk.depan.show');





Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthLoginController::class, 'formLogin'])->name('login');
    Route::post('/login', [AuthLoginController::class, 'prosesLogin'])->name('login.proses');
    Route::get('/register', [AuthLoginController::class, 'formRegister'])->name('register.form');
    Route::post('/register', [AuthLoginController::class, 'prosesRegister'])->name('register.proses');
});
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthLoginController::class, 'logout'])->name('logout');
});
