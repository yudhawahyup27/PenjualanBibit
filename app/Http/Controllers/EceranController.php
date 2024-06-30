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

        // Calculate total shipping cost
        $totalOngkir = 0;
        foreach ($cart as $item) {
            if ($item->pengiriman_keranjang != 0) { // If not self-pickup
                $totalOngkir += $item->ongkir;
            }
        }

        $totalPriceWithOngkir = $sumPrice + $totalOngkir;

        // Prepare data to pass to view
        $data = [
            'menu' => 'home',
            'submenu' => 'pelanggan',
            'nama' => $users->nama_user,
            'cart' => $cart,
            'countCart' => $countCart,
            'sumPrice' => $sumPrice,
            'totalOngkir' => $totalOngkir,
            'totalPriceWithOngkir' => $totalPriceWithOngkir,
            'keranjang' => $keranjang,
        ];

        // Prepare Midtrans Snap token
        $params = [
            'transaction_details' => [
                'order_id' => uniqid(), // Generate unique order ID
                'gross_amount' => $totalPriceWithOngkir, // Add shipping cost to the total amount
            ],
            'customer_details' => [
                'first_name' => $users->nama_user,
                'email' => $users->email_user,
                'phone' => $users->nomortelepon_user,
            ],
            'merchant_id' => config('midtrans.merchant_id'),
            // Add item_details including shipping cost as a separate item
            'item_details' => [
                [
                    'id' => 'SHIPPING',
                    'price' =>        $totalPriceWithOngkir,
                    'quantity' => 1,
                    'name' => 'Shipping Cost',
                ]
            ],
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

        // Retrieve cart items and kode_transaksi from tb_keranjang
        $cart = DB::table('tb_keranjang')
                ->join('tb_produk', 'tb_keranjang.keranjang_id_produk', '=', 'tb_produk.id_produk')
                ->select('tb_keranjang.*', 'tb_produk.nama_bibit', 'tb_keranjang.kode_transaksi')
                ->where('keranjang_id_user', $getSesionId)
                ->get();

        // Calculate total price including shipping
        $sumTotalKeranjang = DB::table('tb_keranjang')->where('keranjang_id_user', $getSesionId)->sum('price_keranjang');
        $totalOngkir = 0;

        foreach ($cart as $item) {
            if ($item->pengiriman_keranjang != 0) { // If not self-pickup
                $kecamatan = DB::table('tb_kecamatan')->where('kecamatan_id', $item->pengiriman_keranjang)->first();
                if ($kecamatan) {
                    $totalOngkir += $kecamatan->ongkir;
                }
            }
        }

        $totalTransaksi = $sumTotalKeranjang + $totalOngkir;

        // Prepare item_details
        $itemDetails = [];
        foreach ($cart as $item) {
            $itemPrice = intval($item->price_keranjang / $item->qty_keranjang); // Ensure integer price without cents

            $itemDetails[] = [
                'id' => $item->keranjang_id_produk,
                'price' => $itemPrice,
                'quantity' => $item->qty_keranjang,
                'name' => 'Bibit ' . $item->nama_bibit,
            ];
        }

        // Add shipping cost as a separate item
        $itemDetails[] = [
            'id' => 'SHIPPING',
            'price' => $totalOngkir,
            'quantity' => 1,
            'name' => 'Shipping Cost',
        ];

        // Prepare transaction details
        $params = [
            'transaction_details' => [
                'order_id' => uniqid(), // Generate unique order ID
                'gross_amount' => $totalTransaksi, // Set the correct gross amount
            ],
            'customer_details' => [
                'first_name' => $user->nama_user,
                'email' => $user->email_user,
                'phone' => $user->nomortelepon_user,
            ],
            'item_details' => $itemDetails,
        ];

        // Get Snap token from Midtrans
        $snapToken = Snap::getSnapToken($params);

        // Insert into tb_transaksi
        $getKodeBarang = uniqid(); // Generate unique transaction code for tb_transaksi
        $buktiTransferPath = '/path/to/bukti_transfer2'; // Adjust this based on your logic

        DB::table('tb_transaksi')->insert([
            'id_user_transaksi' => $getSesionId,
            'kode_transaksi' => $cart[0]->kode_transaksi, // Assuming kode_transaksi is the same for all items in the cart
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
