<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class Pelanggan extends Controller
{
    //
    public function index(Request $request)
    {
        if ($request->session()->get('login')) {
            $getSesionId = $request->session()->get('id');
            $users = DB::table('tb_user')->where('id_user', $getSesionId)->limit(1)->first();
            $product = DB::table('tb_produk')->where('stok_bibit', '>', 0)->get();

            $countAlamat = DB::table('tb_alamatpengiriman')->where('alamatpengiriman_user_id', $users->id_user)->count();
            if ($countAlamat == 0) {
                return redirect()->to('/alamat-pengiriman');
            }

            $data = [
                'menu'      =>  'home',
                'submenu'   =>  'pelanggan',
                'nama'      =>   $users->nama_user,
                'produk'    =>   $product,
            ];
            return view('pelanggan/index_afterlogin', $data);
        } else {
            $product = DB::table('tb_produk')->where('stok_bibit', '>', 0)->orderBy('terjual_bibit', 'desc')->limit(4)->get();
            $data = [
                'menu'      => 'home',
                'submenu'   => 'pelanggan',
                'produk'    =>   $product,
            ];
            return view('pelanggan/index', $data);
        }
    }


    public function alamatpengiriman(Request $request)
    {
        $getSesionId = $request->session()->get('id');
        $users = DB::table('tb_user')->where('id_user', $getSesionId)->limit(1)->first();
        $alamat = DB::table('tb_alamatpengiriman')->join('tb_kecamatan', 'tb_alamatpengiriman.alamatpengiriman_kecamatan_id', '=', 'tb_kecamatan.kecamatan_id')->where('alamatpengiriman_user_id', $users->id_user)->get();
        $countAlamat    = DB::table('tb_alamatpengiriman')->where('alamatpengiriman_user_id', $users->id_user)->count();
        $data = [
            'menu'          =>  'home',
            'submenu'       =>  'pelanggan',
            'nama'          =>   $users->nama_user,
            'alamat'        =>   $alamat,
            'countAlamat'   =>   $countAlamat,
        ];
        return view('pelanggan/alamatpengiriman', $data);
    }

    public function add_alamatpengiriman(Request $request)
    {
        $getSesionId = $request->session()->get('id');
        $users = DB::table('tb_user')->where('id_user', $getSesionId)->limit(1)->first();
        $kecamatan      = DB::table('tb_kecamatan')->get();
        $data = [
            'menu'          =>  'home',
            'submenu'       =>  'pelanggan',
            'nama'          =>   $users->nama_user,
            'kecamatan'     =>   $kecamatan

        ];
        return view('pelanggan/tambah_alamatpengiriman', $data);
    }

    public function edit_alamatpengiriman(Request $request)
    {
        $getSesionId = $request->session()->get('id');
        $users = DB::table('tb_user')->where('id_user', $getSesionId)->limit(1)->first();
        $alamat = DB::table('tb_alamatpengiriman')->where('alamatpengiriman_id', request()->segment(3))->limit(1)->first();
        $kecamatan      = DB::table('tb_kecamatan')->get();
        $data = [
            'menu'          =>  'home',
            'submenu'       =>  'pelanggan',
            'nama'          =>   $users->nama_user,
            'alamat'        =>   $alamat,
            'kecamatan'     =>   $kecamatan
        ];
        return view('pelanggan/ubah_alamatpengiriman', $data);
    }

    public function create_alamatpengiriman(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $getSesionId = $request->session()->get('id');
        $users = DB::table('tb_user')->where('id_user', $getSesionId)->limit(1)->first();
        DB::table('tb_alamatpengiriman')->insert([
            'alamatpengiriman_user_id' => $getSesionId,
            'alamatpengiriman_kecamatan_id' => $request->kecamatan,
            'alamatpengiriman_alamat' => $request->alamat,
            'alamatpengiriman_deskripsi' => $request->deskripsi,
            'alamatpengiriman_created'  => date('Y-m-d H:i:s'),
        ]);
        return redirect()->to('/alamat-pengiriman');
    }

    public function update_alamatpengiriman(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        DB::table('tb_alamatpengiriman')->where('alamatpengiriman_id', request()->segment(3))->update([
            'alamatpengiriman_alamat'       => $request->alamat,
            'alamatpengiriman_kecamatan_id' => $request->kecamatan,
            'alamatpengiriman_deskripsi'    => $request->deskripsi,
            'alamatpengiriman_updated'      => date('Y-m-d H:i:s'),
        ]);
        return redirect()->to('/alamat-pengiriman');
    }

    public function delete_alamatpengiriman(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        DB::table('tb_alamatpengiriman')->where('alamatpengiriman_id', request()->segment(3))->delete();
        return redirect()->to('/alamat-pengiriman');
    }

    public function detail_product(Request $request)
    {
        $uri_one = request()->segment(3);
        $getSesionId = $request->session()->get('id');

        // Fetch the product details
        $product = DB::table('tb_produk')->where('id_produk', $uri_one)->first();

        // Initialize the data array with product details
        $data = [
            'menu'    => 'home',
            'submenu' => 'pelanggan',
            'produk'  => $product,
        ];
        if ($getSesionId) {
            $users = DB::table('tb_user')->where('id_user', $getSesionId)->limit(1)->first();
            $kecamatan = DB::table('tb_alamatpengiriman')
                ->where('alamatpengiriman_user_id', $getSesionId)
                ->join('tb_kecamatan', 'tb_alamatpengiriman.alamatpengiriman_kecamatan_id', '=', 'tb_kecamatan.kecamatan_id')
                ->get();
            $data['nama'] = $users->nama_user;
            $data['kecamatan'] = $kecamatan;
        } else {

            $data['nama'] = null;
            $data['kecamatan'] = collect();
        }
        return view('pelanggan/detail_produk', $data);
    }


    public function payment_product(Request $request)
    {
        $uri_one = request()->segment(3);
        $getSesionId = $request->session()->get('id');
        $users = DB::table('tb_user')->where('id_user', $getSesionId)->limit(1)->first();
        $product = DB::table('tb_produk')->where('id_produk', $uri_one)->first();

        $data = [
            'menu'      =>  'home',
            'submenu'   =>  'pelanggan',
            'nama'      =>   $users->nama_user,
            'produk'    =>   $product,
        ];
        return view('pelanggan/payment', $data);
    }

    public function tentang_kami()
    {
        $data =
            [
                'menu'      => 'tentang-kami',
                'submenu'   => 'pelanggan',
            ];
        return view('pelanggan/tentangkami', $data);
    }

    public function registrasi()
    {
        $data =
            [
                'menu'      => 'registrasi',
                'submenu'   => 'pelanggan',
            ];
        return view('pelanggan/registrasi', $data);
    }

    public function create_registrasi(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        DB::table('tb_user')->insert([
            'nama_user' => $request->nama,
            'nomortelepon_user' => $request->nomortelepon,
            'alamat_user' => $request->alamat,
            'username_user' => $request->username,
            'password_user' => $request->password,
            'role_user' => '4',
            'status_user'   => '1',
            'created_user'  => date('Y-m-d H:i:s'),
        ]);
        return redirect()->to('/login');
    }

    public function login(Request $request)
    {
        if (!$request->session()->get('login')) {
            $data =
                [
                    'menu'      => 'login',
                    'submenu'   => 'pelanggan',
                ];
            return view('pelanggan/login', $data);
        } else {
            return redirect()->to('/');
        }
    }

    public function process_login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        $users = DB::table('tb_user')->where('username_user', $username)->where('password_user', $password)->limit(1)->get();

        if ($users) {
            foreach ($users as $key) {
                $data_id        = $key->id_user;
                $data_username  = $key->username_user;
                $data_role      = $key->role_user;
            }
            $request->session()->put('id', $data_id);
            $request->session()->put('username', $data_username);
            $request->session()->put('role', $data_role);
            $request->session()->put('login', TRUE);

            if ($data_role == 1) {
                return redirect('/admin/dashboard');
            } elseif ($data_role == 2) {
                return redirect('/pegawai/dashboard');
            } elseif ($data_role == 3) {
                return redirect('/pemilik/dashboard');
            } elseif ($data_role == 4) {
                return redirect('/');
            } else {
                return redirect('/');
            }
        }
    }

    public function detail_one()
    {
        return view('pelanggan/detail_one');
    }

    public function profil(Request $request)
    {
        $getSesionId = $request->session()->get('id');
        $users = DB::table('tb_user')->where('id_user', $getSesionId)->limit(1)->first();
        $user = DB::table('tb_user')->where('id_user', $getSesionId)->first();

        $data = [
            'menu'      =>  'profil',
            'submenu'   =>  'pelanggan',
            'nama'      =>  $users->nama_user,
            'get_user'  =>  $user
        ];
        return view('pelanggan/profil', $data);
    }

    public function update_profil(Request $request)
    {
        $getId = $request->session()->get('id');
        DB::table('tb_user')->where('id_user', $getId)->update([
            'nama_user' => $request->nama,
            'nomortelepon_user' => $request->nomortelepon,
            'alamat_user' => $request->alamat,
            'password_user' => $request->password,
        ]);
        return redirect()->to('profil');
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('/');
    }

    public function cart_create(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $uri_one = request()->segment(3);
        $getSesionId = $request->session()->get('id');
        $getProduk = DB::table('tb_produk')->where('id_produk', $uri_one)->first();

        // Hitung total terjual dan total sisa stok
        $totalterjual = $getProduk->terjual_bibit + $request->qty;
        $sisa_stok = $getProduk->stok_bibit - $request->qty;

        // Validasi apakah jumlah yang diminta melebihi stok yang tersedia
        if ($sisa_stok >= 0) {
            if ($request->action == 'cart') {
                DB::table('tb_keranjang')->insert([
                    'keranjang_id_produk' => $uri_one,
                    'keranjang_id_user' => $getSesionId,
                    'qty_keranjang' => $request->qty,
                    'pengiriman_keranjang' => $request->pengiriman,
                    'price_keranjang' => $getProduk->harga_bibit * $request->qty,
                    'created_keranjang'  => date('Y-m-d H:i:s'),
                ]);

                // Update total terjual dan sisa stok
                DB::table('tb_produk')
                    ->where('id_produk', $uri_one)
                    ->update([
                        'terjual_bibit' => $totalterjual,
                        'stok_bibit' => $sisa_stok
                    ]);

                return redirect()->to('/pelanggan/keranjang');
            }
        } else {
            // Pesanan melebihi stok yang tersedia, tangani kesalahan di sini
            return redirect()->back()->with('error', 'Jumlah barang yang diminta melebihi stok yang tersedia.');
        }
    }


    public function detail_cart(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $uri_one = request()->segment(3);
        $getSesionId = $request->session()->get('id');
        $users = DB::table('tb_user')->where('id_user', $getSesionId)->limit(1)->first();
        $product = DB::table('tb_produk')->where('id_produk', $uri_one)->first();
        $cart   = DB::table('tb_keranjang')
            ->join('tb_produk', 'tb_keranjang.keranjang_id_produk', '=', 'tb_produk.id_produk')
            ->join('tb_kecamatan', 'tb_keranjang.pengiriman_keranjang', '=', 'tb_kecamatan.kecamatan_id')
            ->where('keranjang_id_user', $getSesionId)->get();

        $countCart = DB::table('tb_keranjang')->where('keranjang_id_user', $getSesionId)->count();

        $data = [
            'menu'      =>  'home',
            'submenu'   =>  'pelanggan',
            'nama'      =>   $users->nama_user,
            'produk'    =>   $product,
            'cart'      =>   $cart,
            'countCart' =>   $countCart

        ];

        return view('pelanggan/cart', $data);
    }

    public function delete_cart_product()
    {
        DB::table('tb_keranjang')->where('id_keranjang', request()->segment(3))->delete();
        return redirect()->to('/pelanggan/keranjang');
    }


    public function detail_cart_payment(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $uri_one = request()->segment(3);
        $getSesionId = $request->session()->get('id');
        $users = DB::table('tb_user')->where('id_user', $getSesionId)->limit(1)->first();
        $product = DB::table('tb_produk')->where('id_produk', $uri_one)->first();
        $cart   = DB::table('tb_keranjang')
            ->join('tb_produk', 'tb_keranjang.keranjang_id_produk', '=', 'tb_produk.id_produk')
            ->join('tb_kecamatan', 'tb_keranjang.pengiriman_keranjang', '=', 'tb_kecamatan.kecamatan_id')
            ->where('keranjang_id_user', $getSesionId)->get();

        $countCart = DB::table('tb_keranjang')->where('keranjang_id_user', $getSesionId)->count();
        $metodepembayaran = DB::table('tb_metodepembayaran')->get();
        $sumPrice = DB::table('tb_keranjang')->where('keranjang_id_user', $getSesionId)->sum('price_keranjang');
        $keranjang = DB::table('tb_keranjang')->where('keranjang_id_user', $getSesionId)->first();

        $data = [
            'menu'      =>  'home',
            'submenu'   =>  'pelanggan',
            'nama'      =>   $users->nama_user,
            'produk'    =>   $product,
            'cart'      =>   $cart,
            'countCart' =>   $countCart,
            'metodepembayaran'  => $metodepembayaran,
            'sumPrice'  =>   $sumPrice,
            'keranjang' => $keranjang,
        ];
        return view('pelanggan/checkoutcart', $data);
    }

    public function detail_cart_payment_create(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $uri_one = request()->segment(3);
        $getSesionId = $request->session()->get('id');
        $keranjang = DB::table('tb_keranjang')->where('keranjang_id_user', $getSesionId)->get();
        $sumTotalKeranjang = DB::table('tb_keranjang')->where('keranjang_id_user', $getSesionId)->sum('price_keranjang');
        $getMaxKeranjangId = DB::table('tb_transaksi')->max('id_transaksi');

        if ($getMaxKeranjangId == 0) {
            $getKodeBarang = 'T' . date('Ymd') . '1';
        } else {
            $getKodeBarang =  'T' . date('Ymd') . intval($getMaxKeranjangId) + 1;
        }

        DB::table('tb_transaksi')->insert([
            'id_user_transaksi' => $getSesionId,
            'kode_transaksi' => $getKodeBarang,
            'total_transaksi' => $sumTotalKeranjang,
            'status_transaksi' => '1',
            'created_transaksi'  => date('Y-m-d H:i:s'),
        ]);

        DB::table('tb_statuspengiriman')->insert([
            'statuspengiriman_id_status' => '1',
            'statuspengiriman_kodetransaksi' => $getKodeBarang,
            'statuspengiriman_created'  => date('Y-m-d H:i:s'),
        ]);


        foreach ($keranjang as $key) {
            DB::table('tb_transaksi_keranjang')->insert([
                'kode_transaksi_keranjang' => $getKodeBarang,
                'keranjang_id_produk' => $key->keranjang_id_produk,
                'keranjang_id_user' => $getSesionId,
                'qty_keranjang' => $key->qty_keranjang,
                'pengiriman_keranjang' => $key->pengiriman_keranjang,
                'price_keranjang' => $key->price_keranjang,
                'created_keranjang'  => date('Y-m-d H:i:s'),
            ]);
        }

        return redirect()->to('/pelanggan/statustransaksi');
    }

    public function status_transaksi(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $uri_one = request()->segment(3);
        $getSesionId = $request->session()->get('id');
        $users = DB::table('tb_user')->where('id_user', $getSesionId)->limit(1)->first();

        $cart = DB::table('tb_transaksi')->where('id_user_transaksi', $getSesionId)->get();

        $getTransaksi = DB::table('tb_transaksi')->where('id_user_transaksi', $getSesionId)->get();

        $data = [
            'menu'          =>  'home',
            'submenu'       =>  'pelanggan',
            'nama'          =>   $users->nama_user,
            'getTransaksi'  =>   $getTransaksi,
            'cart'          =>   $cart
        ];

        return view('pelanggan/statustransaksi', $data);
    }

    public function status_transaksi_detail(Request $request)
    {
        if ($request->session()->get('login')) {

            date_default_timezone_set('Asia/Jakarta');
            $uri_one = request()->segment(4);
            $getSesionId = $request->session()->get('id');
            $users = DB::table('tb_user')->where('id_user', $getSesionId)->limit(1)->first();

            $cart = DB::table('tb_transaksi')->where('id_transaksi', $uri_one)->first();

            $getStatusTransaksi_one = DB::table('tb_statuspengiriman')->join('tb_status', 'tb_statuspengiriman.statuspengiriman_id_status', '=', 'tb_status.status_id')->where('statuspengiriman_kodetransaksi', $cart->kode_transaksi)->where('statuspengiriman_id_status', '1')->first();
            $getStatusTransaksi_two = DB::table('tb_statuspengiriman')->join('tb_status', 'tb_statuspengiriman.statuspengiriman_id_status', '=', 'tb_status.status_id')->where('statuspengiriman_kodetransaksi', $cart->kode_transaksi)->where('statuspengiriman_id_status', '2')->first();
            $getStatusTransaksi_three = DB::table('tb_statuspengiriman')->join('tb_status', 'tb_statuspengiriman.statuspengiriman_id_status', '=', 'tb_status.status_id')->where('statuspengiriman_kodetransaksi', $cart->kode_transaksi)->where('statuspengiriman_id_status', '3')->first();
            $getStatusTransaksi_four = DB::table('tb_statuspengiriman')->join('tb_status', 'tb_statuspengiriman.statuspengiriman_id_status', '=', 'tb_status.status_id')->where('statuspengiriman_kodetransaksi', $cart->kode_transaksi)->where('statuspengiriman_id_status', '4')->first();

            $getTransaction   = DB::table('tb_transaksi_keranjang')
                ->join('tb_produk', 'tb_transaksi_keranjang.keranjang_id_produk', '=', 'tb_produk.id_produk')
                ->join('tb_kecamatan', 'tb_transaksi_keranjang.pengiriman_keranjang', '=', 'tb_kecamatan.kecamatan_id')
                ->where('kode_transaksi_keranjang', $cart->kode_transaksi)->get();

            $data = [
                'menu'                  =>  'home',
                'submenu'               =>  'pelanggan',
                'nama'                  =>   $users->nama_user,
                'cart'                  =>   $cart,
                'getStatusTransaksi_one'    =>   $getStatusTransaksi_one,
                'getStatusTransaksi_two'    =>   $getStatusTransaksi_two,
                'getStatusTransaksi_three'  =>   $getStatusTransaksi_three,
                'getStatusTransaksi_four'   =>   $getStatusTransaksi_four,
                'getTransaction'            =>   $getTransaction,
            ];

            return view('pelanggan/statustransaksi_detail', $data);
        }else {
            return redirect()->to('/');
        }
    }
}
