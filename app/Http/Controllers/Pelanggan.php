<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
  use Barryvdh\DomPDF\Facade\Pdf;

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
        // Validate the incoming request

        // Retrieve the product ID from the URI
        $productId = $request->segment(3);
        // Retrieve the session user ID
        $sessionUserId = $request->session()->get('id');

        // Fetch the product details
        $product = DB::table('tb_produk')->where('id_produk', $productId)->first();

        // Fetch rumah and kecamatan data
        $rumah = DB::table('tb_alamatpengiriman')
            ->where('alamatpengiriman_user_id', $sessionUserId)
            ->join('tb_kecamatan', 'tb_alamatpengiriman.alamatpengiriman_kecamatan_id', '=', 'tb_kecamatan.kecamatan_id')
            ->select('tb_alamatpengiriman.*', 'tb_kecamatan.kecamatan_name', 'tb_kecamatan.kecamatan_id')
            ->get();

        // Initialize the data array with product details
        $data = [
            'menu'    => 'home',
            'submenu' => 'pelanggan',
            'produk'  => $product,
            'rumah'   => $rumah
        ];

        // Fetch user and kecamatan data if session ID is available
        if ($sessionUserId) {
            $user = DB::table('tb_user')->where('id_user', $sessionUserId)->first();
            $kecamatan = DB::table('tb_kecamatan')->get();

            // Add user and kecamatan data to the response
            $data['nama'] = $user ? $user->nama_user : null;
            $data['kecamatan'] = $kecamatan;
        } else {
            // Set default values if no session ID
            $data['nama'] = null;
            $data['kecamatan'] = collect();
        }

        // Return the view with the prepared data
        return view('pelanggan/detail_produk', $data);
    }




    public function getkuantitas($id)
    {
        $product = DB::table('luas_tb')->find($id);
        if ($product) {
            return response()->json(['jumlah_batang' => $product->jumlah_batang]);
        } else {
            return response()->json(['error' => 'Luas Kosong'], 404);
        }
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

        // Fetch the user from the database
        $user = DB::table('tb_user')
                    ->where('username_user', $username)
                    ->where('password_user', $password)
                    ->first();

        // Check if the user exists
        if ($user) {
            // User exists, set session variables
            $request->session()->put('id', $user->id_user);
            $request->session()->put('username', $user->username_user);
            $request->session()->put('role', $user->role_user);
            $request->session()->put('login', TRUE);

            // Redirect based on user role
            switch ($user->role_user) {
                case 1:
                    return redirect('/admin/dashboard');
                case 2:
                    return redirect('/pegawai/produkbibit');
                case 3:
                    return redirect('/pemilik/dashboard22');
                case 4:
                    return redirect('/');
                default:
                    return redirect('/');
            }
        } else {
            // User does not exist, redirect back with an error message
            return redirect()->back()->with('error', 'Invalid username or password');
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
    public function downloadStrukborongan($id)
    {
        // Ambil data transaksi berdasarkan kode_transaksi
        $transaksi = DB::table('tb_transaksi_borong')
                        ->where('kode_transaksi', $id)
                        ->first();

        // Jika transaksi tidak ditemukan, redirect kembali dengan pesan error
        if (!$transaksi) {
            return redirect()->back()->with('error', 'Transaksi tidak ditemukan.');
        }

        $cart = DB::table('tb_transaksi_borong')
                        ->where('kode_transaksi', $id)
                        ->join('tb_produk', 'tb_transaksi_borong.nama_bibit', '=', 'tb_produk.id_produk')
                        ->get();
        // Ambil data keranjang untuk transaksi ini berdasarkan kode_transaksi
        // $cart = DB::table('tb_transaksi_borong')
        //             ->where('kode_transaksi', $id)
        //             ->join('tb_produk', 'tb_transaksi_borong.id', '=', 'tb_produk.id_produk')
        //             ->select('tb_transaksi_borong.*', 'tb_transaksi_borong.kuantitas_bibit')
        //             ->get();

        // Jika tidak ada keranjang untuk transaksi ini, return dengan pesan error
        // if ($cart->isEmpty()) {
        //     return redirect()->back()->with('error', 'Data keranjang tidak ditemukan.');
        // }

        // Data yang akan dikirim ke view 'pelanggan.strukborongan'
        $data = [
            'transaksi' => $transaksi,
            'cart' => $cart,
        ];

        // Debug: Tampilkan data cart untuk memeriksa hasil query
        // dd($cart);

        // Load view 'pelanggan.strukborongan' sebagai PDF
        $pdf = PDF::loadView('pelanggan.strukborongan', $data);

        // Download file PDF dengan nama 'invoice.pdf'
        return $pdf->download('invoice.pdf');
    }

    public function cart_create(Request $request, $id_produk)
    {
        $request->validate([
            'pengiriman' => 'required|numeric',
        ]);

        date_default_timezone_set('Asia/Jakarta');
        $sessionUserId = $request->session()->get('id');
        $product = DB::table('tb_produk')->where('id_produk', $id_produk)->first();

        if (!$product) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan.');
        }

        // Calculate total sold and remaining stock
        $totalSold = $product->terjual_bibit + $request->qty;
        $remainingStock = $product->stok_bibit - $request->qty;

        $kode_transaksi = "Ttx2" . uniqid();

        // Validate if the requested quantity exceeds the available stock
        if ($remainingStock < 0) {
            return redirect()->back()->with('error', 'Jumlah barang yang diminta melebihi stok yang tersedia.');
        }

        $pengiriman = $request->pengiriman;
        $shippingCost = 0; // Default shipping cost
        $detailRumah = '';

        // If delivery to a kecamatan, get the shipping cost from the kecamatan table
        if ($pengiriman != 0) {
            $kecamatan = DB::table('tb_kecamatan')->where('kecamatan_id', $pengiriman)->first();
            if (!$kecamatan) {
                return redirect()->back()->with('error', 'Kecamatan tidak ditemukan.');
            }
            $shippingCost = $kecamatan->ongkir;
            $detailRumah = $request->input('detail_rumah');
        } else {
            // Ambil di Toko
            $detailRumah = 'Kertosono - Jawa Timur';
        }

        // Check if the product already exists in the cart
        $existingCartItem = DB::table('tb_keranjang')
            ->where('keranjang_id_produk', $id_produk)
            ->where('keranjang_id_user', $sessionUserId)
            ->where('pengiriman_keranjang', $pengiriman)
            ->first();

        if ($existingCartItem) {
            // Update qty_keranjang
            $newQty = $existingCartItem->qty_keranjang + $request->qty;

            // Update existing cart item
            DB::table('tb_keranjang')
                ->where('id_keranjang', $existingCartItem->id_keranjang)
                ->update([
                    'qty_keranjang' => $newQty,
                    'price_keranjang' => ($product->harga_bibit * $newQty),
                    // 'pengiriman'
                ]);
                if ($request->action == 'cart') {
                    return redirect()->to('/pelanggan/keranjang');
                } elseif ($request->action == 'beli_langsung') {
                    return redirect()->to('/pelanggan/detail_cart_payment');
                }
            // Display updated cart item
            $updatedCartItem = DB::table('tb_keranjang')->where('id_keranjang', $existingCartItem->id_keranjang)->first();
            // dd($updatedCartItem);
        } else {
            // Insert new item into the cart table
            DB::table('tb_keranjang')->insert([
                'keranjang_id_produk' => $id_produk,
                'kode_transaksi' => $kode_transaksi,
                'keranjang_id_user' => $sessionUserId,
                'qty_keranjang' => $request->qty,
                'pengiriman_keranjang' => $pengiriman,
                'detail_rumah' => $detailRumah,
                'price_keranjang' => ($product->harga_bibit * $request->qty),
                'created_keranjang' => now(),
                'updated_keranjang' => now(),
            ]);
            if ($request->action == 'cart') {
                return redirect()->to('/pelanggan/keranjang');
            } elseif ($request->action == 'beli_langsung') {
                return redirect()->to('/pelanggan/detail_cart_payment');
            }

            // Display newly inserted cart item
            $newCartItem = DB::table('tb_keranjang')->where('kode_transaksi', $kode_transaksi)->first();
            // dd($newCartItem);
        }
    }





    public function getPrice($id)
    {
        $product = DB::table('tb_produk')->where('id_produk', $id)->first();
        if ($product) {
            return response()->json(['harga_borong' => $product->harga_borong]);
        } else {
            return response()->json(['error' => 'Produk tidak ditemukan'], 404);
        }
    }


            public function bibitborongan(Request $request)
    {
        $getSesionId = $request->session()->get('id');
        $users = DB::table('tb_user')->where('id_user', $getSesionId)->first();
        $produkborong = DB::table('tb_produk')->get();
        $lahan = DB::table('luas_tb')->get();
        $kecamatan = DB::table('tb_kecamatan')->get();
        $metodepembayaran = DB::table('tb_metodepembayaran')->get();
        $rumah = DB::table('tb_alamatpengiriman')
        ->where('alamatpengiriman_user_id', $getSesionId)
        ->join('tb_kecamatan', 'tb_alamatpengiriman.alamatpengiriman_kecamatan_id', '=', 'tb_kecamatan.kecamatan_id')
        ->select('tb_alamatpengiriman.*', 'tb_kecamatan.kecamatan_name')
        ->get();


        // Ensure $metodepembayaran is properly fetched and assigned

        $tanggalHariIni =  Carbon::now();

        $tanggalTanam = $tanggalHariIni->addDays(15)->toDateString();

        // Pass data to the view
        $data = [
            'menu' => 'home',
            'submenu' => 'pelanggan',
            'kecamatan' => $kecamatan,
            'rumah' =>$rumah,
            'produkborong' => $produkborong,
            'lahan' => $lahan,
            'nama' => $users->nama_user,
            'tanggalTanam'=> $tanggalTanam,
            'metodepembayaran' => $metodepembayaran  // Ensure this variable is passed
        ];

        // Return the view with data
        return view('pelanggan.bibitBorongan', $data);
    }

                    public function detail_cart(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $uri_one = request()->segment(3);
        $produkborong = DB::table('tb_produkborong')->get();
        $getSesionId = $request->session()->get('id');
        $users = DB::table('tb_user')->where('id_user', $getSesionId)->first();
        $product = DB::table('tb_produk')->where('id_produk', $uri_one)->first();
        $cart = DB::table('tb_keranjang')
                ->join('tb_produk', 'tb_keranjang.keranjang_id_produk', '=', 'tb_produk.id_produk')
                ->leftJoin('tb_kecamatan', 'tb_keranjang.pengiriman_keranjang', '=', 'tb_kecamatan.kecamatan_id')
                ->where('keranjang_id_user', $getSesionId)
                ->select('tb_keranjang.*', 'tb_produk.nama_bibit', 'tb_produk.gambar_bibit', 'tb_produk.harga_bibit', 'tb_kecamatan.kecamatan_name', 'tb_kecamatan.ongkir')
                ->get();

        $countCart = DB::table('tb_keranjang')->where('keranjang_id_user', $getSesionId)->count();

        $data = [
            'menu'      => 'home',
            'submenu'   => 'pelanggan',
            'nama'      => $users->nama_user,
            'produk'    => $product,
            'cart'      => $cart,
            'produkborong' => $produkborong,
            'countCart' => $countCart
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
    $uri_one = $request->segment(3);
    $getSesionId = $request->session()->get('id');
    $users = DB::table('tb_user')->where('id_user', $getSesionId)->first();
    $product = DB::table('tb_produk')->where('id_produk', $uri_one)->first();
    $produkborong = DB::table('tb_produkborong')->where('id', $uri_one)->first();

    // Ambil semua item keranjang dengan informasi tambahan
    $cart = DB::table('tb_keranjang')
            ->join('tb_produk', 'tb_keranjang.keranjang_id_produk', '=', 'tb_produk.id_produk')
            ->leftJoin('tb_kecamatan', function($join) {
                $join->on('tb_keranjang.pengiriman_keranjang', '=', 'tb_kecamatan.kecamatan_id')
                     ->where('tb_keranjang.pengiriman_keranjang', '!=', 0); // Hanya ambil ongkir jika bukan ambil di toko
            })
            ->select('tb_keranjang.*', 'tb_produk.gambar_bibit', 'tb_produk.nama_bibit', 'tb_produk.harga_bibit', 'tb_kecamatan.kecamatan_name', 'tb_kecamatan.ongkir')
            ->where('keranjang_id_user', $getSesionId)
            ->get();

    // Hitung jumlah total item dalam keranjang
    $countCart = DB::table('tb_keranjang')->where('keranjang_id_user', $getSesionId)->count();

    // Ambil semua metode pembayaran
    $metodepembayaran = DB::table('tb_metodepembayaran')->get();

    // Hitung total harga semua item dalam keranjang
    $sumPrice = DB::table('tb_keranjang')->where('keranjang_id_user', $getSesionId)->sum('price_keranjang');

    // Ambil detail pertama dari keranjang untuk informasi tambahan
    $keranjang = DB::table('tb_keranjang')
                ->leftJoin('tb_kecamatan', function($join) {
                    $join->on('tb_keranjang.pengiriman_keranjang', '=', 'tb_kecamatan.kecamatan_id')
                         ->where('tb_keranjang.pengiriman_keranjang', '!=', 0); // Hanya ambil ongkir jika bukan ambil di toko
                })
                ->select('tb_keranjang.*', 'tb_kecamatan.ongkir')
                ->where('keranjang_id_user', $getSesionId)
                ->first();
              // Jika keranjang kosong, redirect ke halaman keranjang
    if (!$keranjang) {
        return redirect('/pengguna/keranjang');
    }


    // Siapkan data untuk dikirim ke view
    $data = [
        'menu' => 'home',
        'submenu' => 'pelanggan',
        'nama' => $users->nama_user,
        'produk' => $product,
        'cart' => $cart,
        'produkborong' => $produkborong,
        'countCart' => $countCart,
        'metodepembayaran' => $metodepembayaran,
        'sumPrice' => $sumPrice,
        'keranjang' => $keranjang,
    ];

    // Handle aksi Beli Langsung
    if ($request->action == 'direct') {
        // Lakukan proses pembelian langsung di sini sesuai logika bisnis Anda
        // Contoh: Panggil fungsi atau method yang sesuai untuk melakukan pembelian langsung
        // Simpan ke database, lakukan validasi, dll.

        // Redirect ke halaman status transaksi atau halaman konfirmasi pembelian
        return redirect('/pelanggan/statustransaksi')->with('success', 'Pembelian berhasil dilakukan.');
    }

    // Jika bukan aksi Beli Langsung, kembalikan view checkoutcart
    return view('pelanggan/checkoutcart', $data);
}


public function detail_cart_payment_create(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $getSesionId = $request->session()->get('id');
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

                    $buktiTransferPath = null;
                    if ($request->hasFile('bukti_transfer')) {
                        $buktiTransfer = $request->file('bukti_transfer');
                        $buktiTransferPath = $buktiTransfer->store('bukti_transfer', 'public');
                    }

                        DB::table('tb_transaksi')->insert([
                            'id_user_transaksi' => $getSesionId,
                            'kode_transaksi' => $getKodeBarang,
                            'total_transaksi' => $totalTransaksi, // Changed to $totalTransaksi to include shipping
                            'status_transaksi' => '1',
                            'created_transaksi' => date('Y-m-d H:i:s'),
                            'bukti_transfer' => $buktiTransferPath,
                        ]);

                    DB::table('tb_statuspengiriman')->insert([
                        'statuspengiriman_id_status' => '1',
                        'statuspengiriman_kodetransaksi' => $getKodeBarang,
                        'statuspengiriman_created' => date('Y-m-d H:i:s'),
                    ]);

                    foreach ($keranjang as $key) {
                        DB::table('tb_transaksi_keranjang')->insert([
                            'kode_transaksi_keranjang' => $getKodeBarang,
                            'keranjang_id_produk' => $key->keranjang_id_produk,
                            'keranjang_id_user' => $getSesionId,
                            'qty_keranjang' => $key->qty_keranjang,
                            'pengiriman_keranjang' => $key->pengiriman_keranjang,
                            'price_keranjang' => $key->price_keranjang,
                            'created_keranjang' => date('Y-m-d H:i:s'),
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

        $getTransaksi = DB::table('tb_transaksi')
        ->where('id_user_transaksi', $getSesionId)
        ->orderBy('created_transaksi', 'desc')
        ->get();

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
            $uri_one = $request->segment(4);
            $getSesionId = $request->session()->get('id');
            $users = DB::table('tb_user')->where('id_user', $getSesionId)->first();

            // Fetch transaction details from tb_transaksi based on $uri_one
            $cart = DB::table('tb_transaksi')->where('id_transaksi', $uri_one)->first();

            // Fetch status updates from tb_statuspengiriman for the specific transaction
            $statusTransaksis = DB::table('tb_statuspengiriman')
                                ->select('tb_statuspengiriman.*', 'tb_status.status_name')
                                ->join('tb_status', 'tb_statuspengiriman.statuspengiriman_id_status', '=', 'tb_status.status_id')
                                ->where('statuspengiriman_kodetransaksi', $cart->kode_transaksi)
                                ->whereIn('statuspengiriman_id_status', [1, 2, 3, 4])
                                ->get();

            // Fetch product details from tb_keranjang based on $uri_one
            $getTransaction = DB::table('tb_keranjang')
                                ->join('tb_produk', 'tb_keranjang.keranjang_id_produk', '=', 'tb_produk.id_produk')
                                ->select('tb_keranjang.*', 'tb_produk.nama_bibit', 'tb_produk.harga_bibit', 'tb_produk.gambar_bibit')
                                // ->where('keranjang_id_user', $getSesionId)
                                ->where('kode_transaksi', $cart->kode_transaksi)
                                ->get();
// dd($getTransaction);
            $data = [
                'menu'              => 'home',
                'submenu'           => 'pelanggan',
                'nama'              => $users->nama_user,
                'cart'              => $cart,
                'statusTransaksis'  => $statusTransaksis,
                'getTransaction'    => $getTransaction,
            ];

            return view('pelanggan.statustransaksi_detail', $data);
        } else {
            return redirect()->to('/');
        }
    }



    public function monitoring(Request $request, $id)
    {
        date_default_timezone_set('Asia/Jakarta');
        $getSesionId = $request->session()->get('id');
        $users = DB::table('tb_user')->where('id_user', $getSesionId)->first();

        // Ambil data transaksi berdasarkan id transaksi
        $transaksi = DB::table('tb_transaksi_borong')
                        ->where('kode_transaksi', $id)
                        ->first();

        if ($transaksi) {
            // Ambil data produk berdasarkan kode transaksi dari transaksi
            $produk = DB::table('tb_transaksi_borong')
                        ->where('kode_transaksi', $id)
                        ->join('tb_produk', 'tb_transaksi_borong.nama_bibit', '=', 'tb_produk.id_produk')
                        ->first();

            // Ambil data perkembangan berdasarkan id transaksi
            $monitor = DB::table('tb_perkembangan')
                         ->where('perkembangan_kode_transaksi', $id)
                         ->get();

            $data = [
                'menu'      => 'home',
                'submenu'   => 'pelanggan',
                'nama'      => $users->nama_user,
                'produk'    => $produk,
                'transaksi' => $transaksi,
                'monitor'   => $monitor,
            ];

            return view('pelanggan.monitoringBibit', $data);
        } else {
            // Handle jika tidak ada transaksi ditemukan
            return redirect()->back()->with('error', 'Tidak ada transaksi yang ditemukan.');
        }
    }


    public function monitoringbibittable(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $getSesionId = $request->session()->get('id');
        $users = DB::table('tb_user')->where('id_user', $getSesionId)->first();

        $tblTransaksi = DB::table('tb_transaksi_borong')
        ->orderBy('created_at', 'desc')
            ->join('tb_user', 'tb_transaksi_borong.id_user_transaksi', '=', 'tb_user.id_user')
            ->join('tb_produk', 'tb_transaksi_borong.nama_bibit', '=', 'tb_produk.id_produk')
            ->join('tb_status', 'tb_transaksi_borong.status_transaksi', '=', 'tb_status.status_id')
            ->select('tb_transaksi_borong.*', 'tb_produk.nama_bibit as name', 'tb_status.status_name')
            ->get();

        $data = [
            'menu' => 'tablemonitoring',
            'submenu' => 'pelanggan',
            'nama' => $users->nama_user,
            'tblTransaksi' => $tblTransaksi,
        ];

        return view('pelanggan.tablemonitoring', $data);
    }


    public function updateCartQuantity(Request $request)
    {
        $cartId = $request->input('cart_id');
        $newQty = $request->input('qty');

        // Get the current product price
        $cartItem = DB::table('tb_keranjang')->where('id_keranjang', $cartId)->first();
        $product = DB::table('tb_produk')->where('id_produk', $cartItem->keranjang_id_produk)->first();
        $newTotalPrice = $product->harga_bibit * $newQty;

        // Update the cart with the new quantity and total price
        DB::table('tb_keranjang')
            ->where('id_keranjang', $cartId)
            ->update([
                'qty_keranjang' => $newQty,
                'price_keranjang' => $newTotalPrice
            ]);

        // Redirect back to the cart page with a success message
        return redirect()->back()->with('success', 'Quantity and total price updated successfully.');
    }


}



// mmonitoring bibit
