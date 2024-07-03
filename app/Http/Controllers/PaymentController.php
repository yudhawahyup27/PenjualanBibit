<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }


    public function processPayment(Request $request)
    {
        $request->validate([
            'produkborong_select' => 'required',
            'lahan' => 'required',
            'jumlah_perbatang' => 'required|numeric',
            'total' => 'required|numeric',
            'pengiriman' => 'required',
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

        $tanggalHariIni = now();
        $tanggalTanam = $tanggalHariIni->addDays(15)->toDateString();
        $buktiPembayaranDefault = '/images/about.jpeg';

        // Generate unique transaction ID and order ID using UUID
        $orderId = (string) Str::uuid();

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
            'total_transaksi' => $request->input('total'),
            'pengiriman' => $request->input('pengiriman'),
            'detail_rumah' => $request->input('detail_rumah'),
            'status_transaksi' => '1',
            'created_at' => now(),
            'updated_at' => null,
        ]);

        if (!$inserted) {
            return redirect()->back()->withErrors(['error' => 'Failed to insert transaction data']);
        }
        // Retrieve the inserted transaction data
        $transaction = DB::table('tb_transaksi_borong')->where('id', $inserted)->first();
        // $totalRupiah = number_format($transaction->total_transaksi, 0, ',', '.');

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
            // 'item_details' => [
            //     [
            //         'id' => $request->input('produkborong_select'),
            //         'price' => $transaction->total_transaksi,
            //         'quantity' => $transaction->kuantitas_bibit,
            //         'name' => 'Bibit ' . $request->input('produkborong_select'),
            //     ],
            // ],
            'merchant_id' => config('midtrans.merchant_id'),
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
