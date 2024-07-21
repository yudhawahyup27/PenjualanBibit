<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Support\Facades\Session;

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

        $cart = DB::table('tb_keranjang')
            ->join('tb_produk', 'tb_keranjang.keranjang_id_produk', '=', 'tb_produk.id_produk')
            ->select('tb_keranjang.*', 'tb_produk.gambar_bibit', 'tb_produk.nama_bibit', 'tb_produk.harga_bibit')
            ->where('keranjang_id_user', $getSesionId)
            ->get();

        $countCart = DB::table('tb_keranjang')->where('keranjang_id_user', $getSesionId)->count('qty_keranjang');

        $sumPrice = DB::table('tb_keranjang')->where('keranjang_id_user', $getSesionId)->sum('price_keranjang');

        $keranjang = DB::table('tb_keranjang')
            ->where('keranjang_id_user', $getSesionId)
            ->first();

        if (!$keranjang) {
            return redirect('/pengguna/keranjang');
        }

        $totalOngkir =  floatval($keranjang->ongkir);
        

        $totalPriceWithOngkir = $sumPrice + $totalOngkir;

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

        $params = [
            'transaction_details' => [
                'order_id' => uniqid(),
                'gross_amount' => $totalPriceWithOngkir,
            ],
            'customer_details' => [
                'first_name' => $users->nama_user,
                'email' => $users->email_user,
                'phone' => $users->nomortelepon_user,
            ],
            'merchant_id' => config('midtrans.merchant_id'),
            'item_details' => [
                [
                    'id' => 'SHIPPING',
                    'price' =>$totalOngkir,
                    'quantity' =>$countCart ,
                    'name' => 'Ongkir',
                ],
                [
                    'id' => 'Harga',
                    'price' =>  $sumPrice,
                    'quantity' => 1,
                    'name' => 'Harga',
                ]
            ],
        ];

        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $snapToken = Snap::getSnapToken($params);

        $data['snapToken'] = $snapToken;

        return view('pelanggan.checkoutcartmidtrans', $data);
    }

    public function processPayment(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $getSesionId = $request->session()->get('id');
        $user = DB::table('tb_user')->where('id_user', $getSesionId)->first();

        $cart = DB::table('tb_keranjang')
            ->join('tb_produk', 'tb_keranjang.keranjang_id_produk', '=', 'tb_produk.id_produk')
            ->select('tb_keranjang.*', 'tb_produk.nama_bibit', 'tb_produk.stok_bibit', 'tb_keranjang.kode_transaksi')
            ->where('keranjang_id_user', $getSesionId)
            ->get();

        $sumTotalKeranjang = DB::table('tb_keranjang')->where('keranjang_id_user', $getSesionId)->sum('price_keranjang');
        $totalOngkir = 0;

        foreach ($cart as $item) {
            if ($item->pengiriman_keranjang != 0) {
                $kecamatan = DB::table('tb_kecamatan')->where('kecamatan_id', $item->pengiriman_keranjang)->first();
                if ($kecamatan) {
                    $totalOngkir += $kecamatan->ongkir;
                }
            }
        }

        $totalTransaksi = $sumTotalKeranjang + $totalOngkir;

        $itemDetails = [];
        foreach ($cart as $item) {
            $itemPrice = intval($item->price_keranjang / $item->qty_keranjang);

            $itemDetails[] = [
                'id' => $item->keranjang_id_produk,
                'price' => $itemPrice,
                'quantity' => $item->qty_keranjang,
                'name' => 'Bibit ' . $item->nama_bibit,
            ];
        }

        $itemDetails[] = [
            'id' => 'SHIPPING',
            'price' => $totalOngkir,
            'quantity' => 1,
            'name' => 'Shipping Cost',
        ];

        $params = [
            'transaction_details' => [
                'order_id' => uniqid(),
                'gross_amount' => $totalTransaksi,
            ],
            'customer_details' => [
                'first_name' => $user->nama_user,
                'email' => $user->email_user,
                'phone' => $user->nomortelepon_user,
            ],
            'item_details' => $itemDetails,
        ];

        $snapToken = Snap::getSnapToken($params);

        $getKodeBarang = uniqid();
        $buktiTransferPath = '/path/to/bukti_transfer2';
        $tanggalhariini = now();

        foreach ($cart as $item) {
            DB::table('tb_transaksi')->insert([
                'id_user_transaksi' => $getSesionId,
                'id_produk' => $item->keranjang_id_produk,
                'detail_rumah'=>  $item->detail_rumah,
                'kode_transaksi' => $item->kode_transaksi,
                'total_transaksi' => $totalTransaksi + $item->ongkir,
                'pengiriman'=> $item->pengiriman_keranjang,
                'status_transaksi' => '1',
                'created_transaksi' => $tanggalhariini,
                'Qty_beli' => $item->qty_keranjang,
                'bukti_transfer' => $buktiTransferPath,
                'kurir' => $item->kurir,
                'provinsi'=> $item->provinsi,
                'beban' => $item-> berat,
                'ongkir'=> $item->ongkir,

            ]);

            // Reduce stock in the product table
            DB::table('tb_produk')
                ->where('id_produk', $item->keranjang_id_produk)
                ->decrement('stok_bibit', $item->qty_keranjang);
        }

        $this->clearCart($getSesionId);

        return redirect('/pelanggan/statustransaksi');
    }

    private function clearCart($userId)
    {
        DB::table('tb_keranjang')->where('keranjang_id_user', $userId)->delete();

        Session::forget('cart');
    }

    public function handleMidtransCallback(Request $request)
    {
        $json = json_decode($request->input('json'), true);

        return redirect()->to('/pelanggan/statustransaksi');
    }
}
