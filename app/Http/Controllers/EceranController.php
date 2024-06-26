<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;

class EceranController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    public function detail_cart_payment(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $getSesionId = $request->session()->get('id');
        $users = DB::table('tb_user')->where('id_user', $getSesionId)->first();

        // Ambil semua item keranjang dengan informasi tambahan
        $cart = DB::table('tb_keranjang')
                ->join('tb_produk', 'tb_keranjang.keranjang_id_produk', '=', 'tb_produk.id_produk')
                ->leftJoin('tb_kecamatan', function($join) {
                    $join->on('tb_keranjang.pengiriman_keranjang', '=', 'tb_kecamatan.kecamatan_id')
                         ->where('tb_keranjang.pengiriman_keranjang', '!=', 0);
                })
                ->select('tb_keranjang.*', 'tb_produk.gambar_bibit', 'tb_produk.nama_bibit', 'tb_produk.harga_bibit', 'tb_kecamatan.kecamatan_name', 'tb_kecamatan.ongkir')
                ->where('keranjang_id_user', $getSesionId)
                ->get();

        $countCart = DB::table('tb_keranjang')->where('keranjang_id_user', $getSesionId)->count();

        $sumPrice = DB::table('tb_keranjang')->where('keranjang_id_user', $getSesionId)->sum('price_keranjang');

        $keranjang = DB::table('tb_keranjang')
                    ->leftJoin('tb_kecamatan', function($join) {
                        $join->on('tb_keranjang.pengiriman_keranjang', '=', 'tb_kecamatan.kecamatan_id')
                             ->where('tb_keranjang.pengiriman_keranjang', '!=', 0);
                    })
                    ->select('tb_keranjang.*', 'tb_kecamatan.ongkir')
                    ->where('keranjang_id_user', $getSesionId)
                    ->first();

        if (!$keranjang) {
            return redirect('/pengguna/keranjang');
        }

        // Prepare data to pass to view
        $data = [
            'menu' => 'home',
            'submenu' => 'pelanggan',
            'nama' => $users->nama_user,
            'cart' => $cart,
            'countCart' => $countCart,
            'sumPrice' => $sumPrice,
            'keranjang' => $keranjang,
        ];

        // Prepare Midtrans Snap token
        $params = [
            'transaction_details' => [
                'order_id' => uniqid(), // Generate unique order ID
                'gross_amount' => $sumPrice, // Or use 'total' from your cart calculation
            ],
            'customer_details' => [
                'first_name' => $users->nama_user,
                'email' => $users->email_user,
                'phone' => $users->nomortelepon_user,
            ],
            // Add item_details, merchant_id, and other necessary parameters
            'merchant_id' => config('midtrans.merchant_id'),
        ];

        // Set Midtrans configuration
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Get Snap token from Midtrans
        $snapToken = Snap::getSnapToken($params);

        // Pass $snapToken to the view
        $data['snapToken'] = $snapToken;

        return view('pelanggan.checkoutcartmidtrans', $data);
    }

    public function processPayment(Request $request)
    {
        $getSesionId = $request->session()->get('id');
        $user = DB::table('tb_user')->where('id_user', $getSesionId)->first();

        $cart = DB::table('tb_keranjang')
                ->join('tb_produk', 'tb_keranjang.keranjang_id_produk', '=', 'tb_produk.id_produk')
                ->select('tb_keranjang.*', 'tb_produk.nama_bibit')
                ->where('keranjang_id_user', $getSesionId)
                ->get();

        // Prepare transaction details
        $params = [
            'transaction_details' => [
                'order_id' => uniqid(), // Generate unique order ID
                'gross_amount' => $request->input('total'),
            ],
            'customer_details' => [
                'first_name' => $user->nama_user,
                'email' => $user->email_user,
                'phone' => $user->nomortelepon_user,
            ],
            'item_details' => $cart->map(function($item) {
                return [
                    'id' => $item->keranjang_id_produk,
                    'price' => $item->price_keranjang / $item->qty_keranjang,
                    'quantity' => $item->qty_keranjang,
                    'name' => 'Bibit ' . $item->nama_bibit,
                ];
            })->toArray(),
        ];

        // Get Snap token from Midtrans
        $snapToken = Snap::getSnapToken($params);
        $keranjang = DB::table('tb_keranjang')->where('keranjang_id_user', $getSesionId)->get();
        $sumTotalKeranjang = DB::table('tb_keranjang')->where('keranjang_id_user', $getSesionId)->sum('price_keranjang');
        $getMaxKeranjangId = DB::table('tb_transaksi')->max('id_transaksi');

                    if ($getMaxKeranjangId == 0) {
                        $getKodeBarang = 'T' . date('Ymd') . '1';
                    } else {
                        $getKodeBarang = 'T' . date('Ymd') . intval($getMaxKeranjangId) + 1;
                    }

                    $totalOngkir = 0;
                    foreach ($keranjang as $key) {
                        if ($key->pengiriman_keranjang != 0) { // Bukan ambil di toko
                            $kecamatan = DB::table('tb_kecamatan')->where('kecamatan_id', $key->pengiriman_keranjang)->first();
                            if ($kecamatan) {
                                $totalOngkir += $kecamatan->ongkir;
                            }
                        }
                    }

                    $totalTransaksi = $sumTotalKeranjang + $totalOngkir;

        // Insert into tb_transaksi
        $getKodeBarang = uniqid(); // Generate unique transaction code for tb_transaksi
        $buktiTransferPath = '/path/to/bukti_transfer2'; // Adjust this based on your logic

        DB::table('tb_transaksi')->insert([
            'id_user_transaksi' => $getSesionId,
            'kode_transaksi' => $getKodeBarang,
            'total_transaksi' => $totalTransaksi,
            'status_transaksi' => '1',
            'created_transaksi' => now(),
            'bukti_transfer' => $buktiTransferPath,
        ]);

        // Redirect to / after payment is completed
        return redirect('/pelanggan/statustransaksi');
    }

    public function handleMidtransCallback(Request $request)
    {
        $json = json_decode($request->input('json'), true);

        // Logika untuk memproses callback Midtrans

        return redirect()->to('/pelanggan/statustransaksi');
    }
}
