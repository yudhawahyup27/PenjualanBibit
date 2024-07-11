
<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\Pegawai;
use App\Http\Controllers\Pelanggan;
use App\Http\Controllers\Pemilik;
use App\Http\Controllers\BoronganController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\EceranController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [Pelanggan::class, 'index']);
Route::get('/registrasi', [Pelanggan::class, 'registrasi']);
Route::post('/registrasi', [Pelanggan::class, 'create_registrasi']);
Route::get('/login', [Pelanggan::class, 'login']);
Route::post('/login', [Pelanggan::class, 'process_login']);
Route::get('/tentang-kami', [Pelanggan::class, 'tentang_kami']);
Route::get('/logout', [Pelanggan::class, 'logout']);

Route::get('/pelanggan', [Pelanggan::class, 'pelanggan']);
Route::get('/pelanggan/detail/{id}', [Pelanggan::class, 'detail_product']);
Route::post('/pelanggan/detail/{id_produk}/beli', [Pelanggan::class, 'cart_create'])->name('cart.create');
Route::get('/pelanggan/pembayaran/{id}', [Pelanggan::class, 'payment_product']);
Route::get('/pelanggan/keranjang/', [Pelanggan::class, 'detail_cart']);
Route::get('/pelanggan/keranjang/{id}/hapus', [Pelanggan::class, 'delete_cart_product']);
Route::get('/pelanggan/keranjang/bayar', [Pelanggan::class, 'detail_cart_payment']);

Route::get('/pelanggan/detail_cart_payment', [EceranController::class, 'detail_cart_payment']);
Route::post('/pelanggan/processpayment', [EceranController::class, 'processPayment']);
Route::post('/midtrans/callback', [EceranController::class, 'handleMidtransCallback']);
Route::get('/pelanggan/download-struk/{id}', [Pelanggan::class, 'downloadStruk'])->name('pelanggan.downloadStruk');
Route::get('/pelanggan/download-strukborongan/{id}', [Pelanggan::class, 'downloadStrukborongan'])->name('pelanggan.downloadStrukborongan');

Route::post('/pelanggan/bayarsekarang', [Pelanggan::class, 'detail_cart_payment_create'])->name('bayar.sekarang');
Route::get('/pelanggan/statustransaksi', [Pelanggan::class, 'status_transaksi']);
Route::get('/pelanggan/statustransaksi/detail/{id}', [Pelanggan::class, 'status_transaksi_detail']);
Route::post('/pelanggan/processpayment', [EceranController::class, 'processPayment']);

Route::get('/profil', [Pelanggan::class, 'profil']);
Route::post('/profil', [Pelanggan::class, 'update_profil']);
Route::get('/alamat-pengiriman', [Pelanggan::class, 'alamatpengiriman']);
Route::get('/alamat-pengiriman/tambah', [Pelanggan::class, 'add_alamatpengiriman']);
Route::post('/alamat-pengiriman/tambah', [Pelanggan::class, 'create_alamatpengiriman']);
Route::get('/alamat-pengiriman/ubah/{id}', [Pelanggan::class, 'edit_alamatpengiriman']);
Route::post('/alamat-pengiriman/ubah/{id}', [Pelanggan::class, 'update_alamatpengiriman']);
Route::get('/alamat-pengiriman/hapus/{id}', [Pelanggan::class, 'delete_alamatpengiriman']);

Route::get('/admin', [Admin::class, 'redirectdashboard']);
Route::get('/admin/data-pelanggan', [Admin::class, 'dashboard']);
Route::get('/admin/datauser', [Admin::class, 'datauser']);
Route::get('/admin/datauser/tambah', [Admin::class, 'add_dataUser']);
Route::post('/admin/datauser/tambah', [Admin::class, 'create_dataUser']);
Route::get('/admin/datauser/hapus/{id}', [Admin::class, 'delete_dataUser']);
Route::get('/admin/datauser/ubah/{id}', [Admin::class, 'edit_dataUser']);
Route::post('/admin/datauser/ubah/{id}', [Admin::class, 'update_dataUser']);
Route::get('/admin/datauser/ubah-status/{id}', [Admin::class, 'nonaktifkan_dataUser']);
Route::get('/admin/metodepembayaran', [Admin::class, 'MetodePembayaran']);
Route::get('/admin/metodepembayaran/tambah', [Admin::class, 'add_MetodePembayaran']);
Route::post('/admin/metodepembayaran/tambah', [Admin::class, 'create_MetodePembayaran']);
Route::get('/admin/metodepembayaran/hapus/{id}', [Admin::class, 'delete_MetodePembayaran']);
Route::get('/admin/metodepembayaran/ubah/{id}', [Admin::class, 'edit_MetodePembayaran']);
Route::post('/admin/metodepembayaran/ubah/{id}', [Admin::class, 'update_MetodePembayaran']);

Route::get('/pegawai', [Pegawai::class, 'redirectdashboard']);
Route::get('/pegawai/dashboard', [Pegawai::class, 'dashboard']);
Route::get('/pegawai/produkbibit', [Pegawai::class, 'produkbibit']);
Route::get('/pegawai/produkbibit/tambah', [Pegawai::class, 'add_produkbibit']);
Route::post('/pegawai/produkbibit/tambah', [Pegawai::class, 'create_produkbibit']);
Route::get('/pegawai/produkbibit/hapus/{id}', [Pegawai::class, 'delete_produkbibit']);
Route::get('/pegawai/produkbibit/ubah/{id}', [Pegawai::class, 'edit_produkbibit']);
Route::post('/pegawai/produkbibit/ubah/{id}', [Pegawai::class, 'update_produkbibit']);
Route::get('/pegawai/stokbibit', [Pegawai::class, 'stokbibit']);
Route::get('/pegawai/ongkir', [Pegawai::class, 'ongkoskirim']);
Route::get('/pegawai/ongkir/tambah', [Pegawai::class, 'ongkoskirim_tambah']);
Route::post('/pegawai/ongkir/tambah', [Pegawai::class, 'ongkoskirim_create']);
Route::get('/pegawai/ongkir/hapus/{id}', [Pegawai::class, 'ongkoskirim_delete']);
Route::get('/pegawai/ongkir/ubah/{id}', [Pegawai::class, 'ongkoskirim_ubah']);
Route::post('/pegawai/ongkir/ubah/{id}', [Pegawai::class, 'ongkoskirim_update']);
Route::get('/pegawai/pesanan/', [Pegawai::class, 'pesanan']);
Route::get('/pegawai/pesanan/sudahproses/{id}', [Pegawai::class, 'pesanan_sudahdiproses']);
Route::get('/pegawai/pesanan/sudahbayar/{id}', [Pegawai::class, 'pesanan_sudahbayar']);
Route::get('/pegawai/pesanan/sudahdikirim/{id}', [Pegawai::class, 'pesanan_sudahdikirim']);
Route::get('/pegawai/pesanan/sudahditerima/{id}', [Pegawai::class, 'pesanan_sudahditerima']);
Route::get('/pegawai/pesanan/sudahbayarborong/{id}', [Pegawai::class, 'pesanan_sudahbayarborong']);
Route::get('/pegawai/pesanan/sudahprosesborong/{id}', [Pegawai::class, 'pesanan_sudahdiprosesborong']);
Route::get('/pegawai/pesanan/sudahdikirimborong/{id}', [Pegawai::class, 'pesanan_sudahdikirimborong']);
Route::get('/pegawai/pesanan/sudahditerimaborong/{id}', [Pegawai::class, 'pesanan_sudahditerimaborong']);
Route::get('/pegawai/monitoringbibit', [Pegawai::class, 'monitoringbibit']);
Route::get('/pegawai/monitoringbibit/detail/{id}', [Pegawai::class, 'monitoringbibit_detail'])->name('pegawai.monitoringbibit.detail');
Route::post('/pegawai/monitoringbibit/detail/{id}', [Pegawai::class, 'monitoringbibit_detail']);

// Route::get('/pegawai/monitoringbibit/detail/{id}/tambah', [Pegawai::class, 'monitoringbibit_tambah']);
// Route::post('/pegawai/monitoringbibit/detail/{id}/tambah', [Pegawai::class, 'monitoringbibit_create']);
Route::get('/pegawai/monitoringbibit/hapus/{id}', [Pegawai::class, 'monitoringbibit_delete']);

Route::get('/pemilik', [Pemilik::class, 'redirectdashboard']);
Route::get('/pemilik/dashboard22', [Pemilik::class, 'dashboard'])->name('dashboard');
Route::get('/pemilik/produkbibit', [Pemilik::class, 'produkbibit2']);
Route::get('/pemilik/produkbibit/tambah', [Pemilik::class, 'add_produkbibit']);
Route::post('/pemilik/produkbibit/tambah', [Pemilik::class, 'create_produkbibit']);
Route::get('/pemilik/produkbibit/hapus/{id}', [Pemilik::class, 'delete_produkbibit']);
Route::get('/pemilik/produkbibit/ubah/{id}', [Pemilik::class, 'edit_produkbibit']);
Route::post('/pemilik/produkbibit/ubah/{id}', [Pemilik::class, 'update_produkbibit']);
Route::get('/pemilik/stokbibit2', [Pemilik::class, 'stokbibit']);
// Route::get('/chart', [ChartController::class, 'index']);
// Route::get('/chart/data', [ChartController::class, 'getData']);

Route::get('/pemilik/laporanpenjualan', [Pemilik::class, 'laporanpenjualan'])->name('laporanpenjualan');
Route::get('/pemilik/laporanpenjualanborongan', [Pemilik::class, 'laporanpenjualanborongan'])->name('laporanpenjualanborongan');

Route::get('/get-price/{id}', [BoronganController::class, 'getPrice']);
Route::get('/get-price/{id}', [Pelanggan::class, 'getPrice']);
Route::get('/get-batang/{id}', [Pelanggan::class, 'getkuantitas']);
Route::post('/pelanggan/bibitborongan/checkout', [PaymentController::class, 'processPayment'])->name('payment.process');
Route::post('/midtrans/callback', [PaymentController::class, 'callback'])->name('midtrans.callback');;
Route::get('/pelanggan/bibitborongan/checkout', [BoronganController::class, 'checkoutForm'])->name('borongan.checkout');

Route::get('/pelanggan/bibitborongan', [Pelanggan::class, 'bibitborongan']);
Route::post('/pelanggan/bibitborongan', [Pelanggan::class, 'bayar_cart_borongan']);
Route::post('/pelanggan/get_product_price', [BoronganController::class, 'getProductPrice']);
Route::get('/pelanggan/monitorbibit/{id}', [Pelanggan::class, 'monitoring'])->name('pelanggan.monitorbibit');
Route::get('/pelanggan/tablemonitorbibit', [Pelanggan::class,'monitoring']);


Route::get('/pelanggan/tablemonitoring', [Pelanggan::class, 'monitoringbibittable']);
// In your routes file

Route::post('/pelanggan/keranjang/update', [Pelanggan::class, 'updateCartQuantity']);
// routes/web.php
Route::get('/charts', [ChartController::class, 'index']);
Route::get('/chart-data', [ChartController::class, 'getChartData']);
Route::get('pemilik/dashboard2', [Pemilik::class, 'dashboard2'])->name('dashboard2');

Route::get('/get-ongkir/{kecamatan_id}', [Pegawai::class, 'getOngkir'])->name('get-ongkir');
Route::get('/pegawai/produkbibit/ubah/stock/{id}', [Pegawai::class, 'editProdukbibitStock']);
Route::post('/pegawai/produkbibit/ubah/stock/{id}', [Pegawai::class, 'updateProdukbibitStock']);
