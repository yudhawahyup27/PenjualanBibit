<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Support\Str;
use App\Services\RajaOngkirService;

class PaymentController extends Controller
{
    protected $rajaOngkirService;
    public function __construct(RajaOngkirService $rajaOngkirService)
    {
        $this->rajaOngkirService = $rajaOngkirService;
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }


    public function processPayment(Request $request)
    {
        $request->validate([
            'province' => 'required|numeric',
            'city' => 'required|numeric',
            'courier' => 'required|string',
        ]);

        date_default_timezone_set('Asia/Jakarta');
        $request->validate([
            'produkborong_select' => 'required',
            'lahan' => 'required',
            'jumlah_perbatang' => 'required|numeric',
            'total' => 'required|numeric',
        ]);

        $getSesionId = $request->session()->get('id');
        if (!$getSesionId) {
            return redirect()->back()->withErrors(['error' => 'User not authenticated']);
        }

        // Retrieve user details
        $user = DB::table('tb_user')->where('id_user', $getSesionId)->first();
        if (!$user) {
            return redirect()->back()->withErrors(['error' => 'User not found']);
        }

        // Calculate the weight
        $weight = ceil($request->jumlah_perbatang / 30) * 1000;

        // Validate the calculated weight
        if ($weight <= 0) {
            return redirect()->back()->withErrors(['error' => 'Invalid weight calculated']);
        }

        $province = $request->province;
        $city = $request->city;
        $courier = $request->courier;

        // Make the request to RajaOngkir API to get the shipping cost
        try {
            $shippingResponse = $this->rajaOngkirService->getCost(1, $city, $weight, $courier);
            $shippingCost = $shippingResponse['rajaongkir']['results'][0]['costs'][0]['cost'][0]['value'];
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to fetch shipping cost: ' . $e->getMessage()]);
        }

        $tanggalHariIni = now();
        $tanggalTanam = $tanggalHariIni->addDays(15)->toDateString();
        $buktiPembayaranDefault = '/images/about.jpeg';

        // Generate unique transaction ID and order ID using UUID
        $orderId = (string) Str::uuid();
        $province = $request->province;

        // Insert transaction data into the database
        $inserted = DB::table('tb_transaksi_borong')->insertGetId([
            'id_user_transaksi' => $getSesionId,
            'kode_transaksi' => uniqid(),
            'nama_bibit' => $request->input('produkborong_select'),
            'tanggal_tanam' => $tanggalTanam,
            'luas_lahan' => $request->input('lahan'),
            'metodepembayaran' => 2,
            'bukti_pembayaran' => $buktiPembayaranDefault,
            'kuantitas_bibit' => $request->input('jumlah_perbatang'),
            'total_transaksi' => $request->input('total')+ $shippingCost,
            'pengiriman' => $request->input('city'),
            'detail_rumah' => $request->input('detail_rumah'),
            'status_transaksi' => '1',
            'created_at' => now(),
            'beban'=> $request->input('totalWeightInput'),
            'kurir' =>  $request->input('courier'),
            'provinsi' =>  $province,
            'ongkir' => $shippingCost,
            'updated_at' => null,
        ]);

        if (!$inserted) {
            return redirect()->back()->withErrors(['error' => 'Failed to insert transaction data']);
        }

        // Retrieve the inserted transaction data
        $transaction = DB::table('tb_transaksi_borong')->where('id', $inserted)->first();

        // Setup parameters for Midtrans Snap API
        $params = [
            'transaction_details' => [
                'order_id' => $orderId, // Use UUID for order_id
                'gross_amount' => $transaction->total_transaksi,
            ],
            'customer_details' => [
                'first_name' => $user->nama_user,
                'email' => $user->email_user,
                'phone' => $user->nomortelepon_user,
            ],
            'merchant_id' => config('midtrans.merchant_id'),
            'item_details' => [
                [
                    'id' => 'SHIPPING',
                    'price' =>$transaction->ongkir,
                    'quantity' =>1 ,
                    'name' => 'Ongkir',
                ],
                [
                    'id' => 'Harga',
                    'price' =>  $transaction->total_transaksi,
                    'quantity' => 1,
                    'name' => 'Harga',
                ]
            ],
        ];

        // Get Snap token from Midtrans
        $snapToken = Snap::getSnapToken($params);

        return view('pelanggan.paymentmidtrans', compact('snapToken'));
    }

    public function callback(Request $request)
    {
        return redirect()->to('/');
    }
}
