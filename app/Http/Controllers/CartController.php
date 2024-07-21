<?php

namespace App\Http\Controllers;

use App\Services\RajaOngkirService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class CartController extends Controller
{
    protected $rajaOngkirService;

    public function __construct(RajaOngkirService $rajaOngkirService)
    {
        $this->rajaOngkirService = $rajaOngkirService;
    }

    public function cart_create(Request $request, $id_produk)
    {
        $request->validate([
            'province' => 'required|numeric',
            'city' => 'required|numeric',
            'courier' => 'required|string',
        ]);

        date_default_timezone_set('Asia/Jakarta');
        $sessionUserId = $request->session()->get('id');
        $product = DB::table('tb_produk')->where('id_produk', $id_produk)->first();

        if (!$product) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan.');
        }

        $totalSold = $product->terjual_bibit + $request->qty;
        $remainingStock = $product->stok_bibit - $request->qty;

        if ($remainingStock < 0) {
            return redirect()->back()->with('error', 'Jumlah barang yang diminta melebihi stok yang tersedia.');
        }

        $province = $request->province;
        $city = $request->city;
        $courier = $request->courier;

        $weight = ceil($request->qty / 30) * 1000; // 1 kg = 30 items, below 30 items = 1 kg

        $shippingCost = 0;
        $detailRumah = '';

        $shippingResponse = $this->rajaOngkirService->getCost(1, $city, $weight, $courier);
        $shippingCost = $shippingResponse['rajaongkir']['results'][0]['costs'][0]['cost'][0]['value'];



        $kode_transaksi = "Ttx2" . uniqid();

        $existingCartItem = DB::table('tb_keranjang')
            ->where('keranjang_id_produk', $id_produk)
            ->where('keranjang_id_user', $sessionUserId)
            ->where('pengiriman_keranjang', $city)
            ->first();

        if ($existingCartItem) {
            $newQty = $existingCartItem->qty_keranjang + $request->qty;

            DB::table('tb_keranjang')
                ->where('id_keranjang', $existingCartItem->id_keranjang)
                ->update([
                    'qty_keranjang' => $newQty,
                    'price_keranjang' => ($product->harga_bibit * $newQty) + $shippingCost,
                ]);

            if ($request->action == 'cart') {
                return redirect()->to('/pelanggan/keranjang');
            } elseif ($request->action == 'beli_langsung') {
                return redirect()->to('/pelanggan/detail_cart_payment');
            }
        } else {
            DB::table('tb_produk')
                ->where('id_produk', $id_produk)
                ->update(['terjual_bibit' => $totalSold]);

            DB::table('tb_keranjang')->insert([
                'keranjang_id_produk' => $id_produk,
                'kode_transaksi' => $kode_transaksi,
                'keranjang_id_user' => $sessionUserId,
                'qty_keranjang' => $request->qty,
                'berat'=> $request->input('totalWeightInput'),
                'kurir' =>  $request->input('courier'),
                'ongkir'=>  $shippingCost,
                'pengiriman_keranjang' => $city,
                'provinsi' =>  $province,
                'detail_rumah' => $request->input('detail_rumah'),
                'price_keranjang' => ($product->harga_bibit * $request->qty),
                'created_keranjang' => now(),
                'updated_keranjang' => now(),
            ]);

            if ($request->action == 'cart') {
                return redirect()->to('/pelanggan/keranjang');
            } elseif ($request->action == 'beli_langsung') {
                return redirect()->to('/pelanggan/detail_cart_payment');
            }
        }
    }

    public function showProductPage($id_produk,Request $request)
    {
        $product = DB::table('tb_produk')->where('id_produk', $id_produk)->first();
        $provinces = $this->rajaOngkirService->getProvinces();
        $qty = $request->qty;
        $totalWeight = ceil($qty / 30) * 1000;

        if (!$product) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan.');
        }
        $sessionUserId = $request->session()->get('id');

        $users = DB::table('tb_user')->where('id_user', $sessionUserId )->limit(1)->first();
        return view('pelanggan/detail_produk', [
            'produk' => $product,
            'nama'          =>   $users->nama_user,
            'provinces' => $provinces['rajaongkir']['results'],
            'totalWeight' => $totalWeight
        ]);
    }

    public function getShippingCost(Request $request)
    {
        $origin = '399';
        $destination = $request->input('destination');
        $weight = $request->input('weight');
        $courier = $request->input('courier');


       
        $response = Http::withHeaders([
            'key' => '1365b0cb5a5a58e86a22df82f8084a94'
        ])->post('https://api.rajaongkir.com/starter/cost', [
            'origin' => $origin,
            'destination' => $destination,
            'weight' => $weight,
            'courier' => $courier
        ]);

        return $response->json();
    }
    public function getProvinces()
    {
        $provinces = $this->rajaOngkirService->getProvinces();
        return response()->json($provinces['rajaongkir']['results']);
    }

    public function getCities($provinceId)
    {
        $cities = $this->rajaOngkirService->getCities($provinceId);
        return response()->json($cities['rajaongkir']['results']);
    }
}
