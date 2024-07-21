<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\RajaOngkirService;

class BoronganController extends Controller
{
    protected $rajaOngkirService;

    public function __construct(RajaOngkirService $rajaOngkirService)
    {
        $this->rajaOngkirService = $rajaOngkirService;
    }


    public function checkoutForm(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $produkborong = DB::table('tb_produk')->get();
        $kecamatan = DB::table('tb_kecamatan')->get();
        $tanggalTanam = now()->addDays(15)->toDateString();

        $provinces = $this->rajaOngkirService->getProvinces();
        // Fetch customer data
        $getId = $request->session()->get('id');

                 // Fetch rumah and kecamatan data
        $rumah = DB::table('tb_alamatpengiriman')
        ->where('alamatpengiriman_user_id',  $getId)
        ->join('tb_kecamatan', 'tb_alamatpengiriman.alamatpengiriman_kecamatan_id', '=', 'tb_kecamatan.kecamatan_id')
        ->select('tb_alamatpengiriman.*', 'tb_kecamatan.kecamatan_name', 'tb_kecamatan.kecamatan_id', 'tb_kecamatan.ongkir')
        ->get();
        $customer = DB::table('tb_user')->where('id_user', $getId)->first();
        // $paymentMethodsResponse = $this->tripayService->getPaymentMethods();
        // $paymentMethods = isset($paymentMethodsResponse['data']) ? $paymentMethodsResponse['data'] : [];


        $data = [
            'menu' => 'dashboard',
            'submenu' => 'pegawai',
            'kecamatan' => $kecamatan,
            'provinces' => $provinces['rajaongkir']['results'],
            // 'paymentMethods' => $paymentMethods,
            'customer' => $customer,
            'rumah' => $rumah,
            'nama' =>  $customer->nama_user ?? null,
            'produkborong' => $produkborong,
            'tanggalTanam' => $tanggalTanam
        ];

        return view('pelanggan.checkout', $data);
    }

    public function getProductPrice($productId)
    {
        $product = DB::table('produkborong')->where('id_produk', $productId)->first();
        return response()->json(['harga_borong' => $product->harga_borong]);
    }

//     public function bayar_cart_borongan(Request $request)
//     {
//         date_default_timezone_set('Asia/Jakarta');
//         $request->validate([
//             'produkborong_select' => 'required|exists:tb_produk,id_produk',
//             'harga_bibit' => 'required|numeric',
//             'lahan' => 'required|numeric|min:175',
//             // 'jumlah_perbatang' => 'required|numeric',
//             'pengiriman' => 'required|numeric',
//             // 'payment_method' => 'required',
//             'total' => 'required',
//         ]);

//         $getSesionId = $request->session()->get('id');
//         if (!$getSesionId) {
//             return redirect()->back()->withErrors(['error' => 'User not authenticated']);
//         }

//         $getKodeBarang = 'TRX_' . uniqid();
//         $tanggalHariIni = now();
//         $tanggalTanam = $tanggalHariIni->addDays(15)->toDateString();

//         // Fetch customer data
//         $customer = DB::table('tb_user')->where('id_user', $getSesionId)->first();
// dd($customer);
//         $data = [
//             'method'            => $request->input('payment_method'),
//             'merchant_ref'      => $getKodeBarang,
//             'amount'            => number_format((float)$request->input('total'), 2, '.', ''),
//             'customer_name'     => $customer->nama_user,
//             'customer_email'    => $customer->email_user,
//             'customer_phone'    => $customer->nomortelepon_user,
//             'order_items'       => [
//                 [
//                     'sku'       => $request->input('produkborong_select'),
//                     'name'      => 'Bibit Borongan',
//                     'price'     => $request->input('harga_bibit'),
//                     'quantity'  => $request->input('jumlah_perbatang'),
//                 ]
//             ],
//             'callback_url'      => url('/callback'),
//             'return_url'        => url('/pelanggan/statustransaksi'),
//             'expired_time'      => (time() + (24 * 60 * 60)), // 24 hours
//         ];

//         // Generate signature
//         $data['signature'] = $this->tripayService->createSignature($data['merchant_ref'], $data['amount'], $data['method']);

//         // Create transaction using TripayService
//         $result = $this->tripayService->createTransaction($data);

//         if ($result['success']) {
//             DB::table('tb_transaksi_borong')->insert([
//                 'id_user_transaksi' => $getSesionId,
//                 'kode_transaksi' => $getKodeBarang,
//                 'nama_bibit' => $request->input('produkborong_select'),
//                 'tanggal_tanam' => $tanggalTanam,
//                 'luas_lahan' => $request->input('lahan'),
//                 'kuantitas_bibit' => $request->input('jumlah_perbatang'),
//                 'total_transaksi' => $request->input('total'),
//                 'pengiriman' => $request->input('pengiriman'),
//                 'metodepembayaran' => 'Tripay',
//                 'status_transaksi' => '1',
//                 'created_at' => now(),
//             ]);

//             return redirect('/pelanggan/statustransaksi')->with('success', 'Transaksi berhasil dilakukan. Silakan selesaikan pembayaran melalui Tripay.');
//         } else {
//             return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat melakukan transaksi: ' . $result['message']]);
//         }
//     }

    public function getPrice($id)
    {
        $product = DB::table('tb_produk')->where('id_produk', $id)->first();
        if ($product) {
            return response()->json(['harga_borong' => $product->harga_borong]);
        } else {
            return response()->json(['error' => 'Produk tidak ditemukan'], 404);
        }
    }
}
