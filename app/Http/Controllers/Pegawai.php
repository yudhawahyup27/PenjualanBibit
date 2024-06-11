<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class Pegawai extends Controller
{
    //
    public function redirectdashboard()
    {
        return redirect()->to('/pegawai/dashboard');
    }

    public function dashboard(Request $request)
    {
        $session_role = $request->session()->get('role');
        if ($session_role == 1) {
            return redirect()->to('/admin');
        } elseif ($session_role == 3) {
            return redirect()->to('/pemilik');
        } elseif ($session_role == 4) {
            return redirect()->to('/');
        } elseif ($session_role == '') {
            return redirect()->to('/');
        }

        $data = [
            'menu'      =>  'dashboard',
            'submenu'   =>  'pegawai',
        ];
        return view('pegawai/dashboard', $data);
    }

    public function produkbibit(Request $request)
    {
        $session_role = $request->session()->get('role');
        if ($session_role == 1) {
            return redirect()->to('/admin');
        } elseif ($session_role == 3) {
            return redirect()->to('/pemilik');
        } elseif ($session_role == 4) {
            return redirect()->to('/');
        } elseif ($session_role == '') {
            return redirect()->to('/');
        }

        $tblProduk = DB::table('tb_produk')
            ->join('tb_user', 'tb_produk.produk_id_user', '=', 'tb_user.id_user')
            ->get();
        $data = [
            'menu'          =>  'produkbibit',
            'submenu'       =>  'pemilik',
            'dataproduk'    =>  $tblProduk,
        ];
        return view('pegawai/produkbibit', $data);
    }

    public function add_produkbibit(Request $request)
    {
        $session_role = $request->session()->get('role');
        if ($session_role == 1) {
            return redirect()->to('/admin');
        } elseif ($session_role == 3) {
            return redirect()->to('/pemilik');
        } elseif ($session_role == 4) {
            return redirect()->to('/');
        } elseif ($session_role == '') {
            return redirect()->to('/');
        }

        $getuserpemilik = DB::table('tb_user')->where('role_user', '3')->get();

        $data = [
            'menu'              =>  'produkbibit',
            'submenu'           =>  'pegawai',
            'getuserpemilik'    =>  $getuserpemilik,
        ];
        return view('pegawai/tambah_produkbibit', $data);
    }


    public function create_produkbibit(Request $request)
    {
        $session_role = $request->session()->get('role');
        if ($session_role == 1) {
            return redirect()->to('/admin');
        } elseif ($session_role == 3) {
            return redirect()->to('/pemilik');
        } elseif ($session_role == 4) {
            return redirect()->to('/');
        } elseif ($session_role == '') {
            return redirect()->to('/');
        }

        $getProdukById = DB::table('tb_produk')->orderBy('id_produk', 'DESC')->limit(1)->first();
        if ($getProdukById) {
            $urutan = (int) substr($getProdukById->kode_bibit, 3, 3);
            $urutan++;
            $huruf = "A";
            $kodeBarang = $huruf . sprintf("%03s", $urutan);
        } else {
            $kodeBarang = 'A001';
        }

        if ($request->image1) {
            $imageName = rand(1000, 9999) . time() . '.' . $request->image1->extension();
            $request->image1->move(public_path('images'), $imageName);
            $getCount_fromNama = DB::table('tb_produk')->where('nama_bibit', $request->nama)->count();
            if ($getCount_fromNama < 1) {
                DB::table('tb_produk')->insert([
                    'kode_bibit'        => $kodeBarang,
                    'produk_id_user'    => $request->user,
                    'nama_bibit'        => $request->nama,
                    'detail_bibit'      => $request->detail,
                    'harga_bibit'       => $request->harga,
                    'stok_bibit'        => $request->stok,
                    'gambar_bibit'      => $imageName,
                    'status_bibit'      => '1',
                    'created_produk'    => date('Y-m-d H:i:s'),
                ]);
                DB::table('tb_stok')->insert([
                    'stok_kode_barang'      => $kodeBarang,
                    'nama_bibit' => $request->nama,
                    'stok_jumlah'           => $request->stok,
                    'created_at'            => date('Y-m-d H:i:s'),
                ]);
            } else {
                $getData_fromNama = DB::table('tb_produk')->where('nama_bibit', $request->nama)->first();
                $getDataStok = DB::table('tb_stok')->where('stok_kode_barang', $getData_fromNama->kode_bibit)->first();
                DB::table('tb_produk')->insert([
                    'kode_bibit'        => $getData_fromNama->kode_bibit,
                    'produk_id_user'    => $request->user,
                    'nama_bibit'        => $request->nama,
                    'detail_bibit'      => $request->detail,
                    'harga_bibit'       => $request->harga,
                    'stok_bibit'        => $request->stok,
                    'gambar_bibit'      => $imageName,
                    'status_bibit'      => '1',
                    'created_produk'    => date('Y-m-d H:i:s'),
                ]);
                DB::table('tb_stok')->where('stok_kode_barang', $getData_fromNama->kode_bibit)->update([
                    'stok_jumlah'           => $getDataStok->stok_jumlah + $request->stok,
                    'nama_bibit' => $getDataStok->nama_bibit + $request->nama,
                    'updated_at'            => date('Y-m-d H:i:s'),
                ]);
            }
        } else {
            $getCount_fromNama = DB::table('tb_produk')->where('nama_bibit', $request->nama)->count();
            if ($getCount_fromNama < 1) {
                DB::table('tb_produk')->insert([
                    'kode_bibit'        => $kodeBarang,
                    'produk_id_user'    => $request->user,
                    'nama_bibit'        => $request->nama,
                    'detail_bibit'      => $request->detail,
                    'harga_bibit'       => $request->harga,
                    'stok_bibit'        => $request->stok,
                    'status_bibit'      => '1',
                    'created_produk'    => date('Y-m-d H:i:s'),
                ]);
                DB::table('tb_stok')->insert([
                    'stok_kode_barang'      => $kodeBarang,
                    'nama_bibit' => $request->nama,
                    'stok_jumlah'           => $request->stok,
                    'created_at'            => date('Y-m-d H:i:s'),
                ]);
            } else {
                $getData_fromNama = DB::table('tb_produk')->where('nama_bibit', $request->nama)->first();
                $getDataStok = DB::table('tb_stok')->where('stok_kode_barang', $getData_fromNama->kode_bibit)->first();
                DB::table('tb_produk')->insert([
                    'kode_bibit'        => $getData_fromNama->kode_bibit,
                    'produk_id_user'    => $request->user,
                    'nama_bibit'        => $request->nama,
                    'detail_bibit'      => $request->detail,
                    'harga_bibit'       => $request->harga,
                    'stok_bibit'        => $request->stok,
                    'status_bibit'      => '1',
                    'created_produk'    => date('Y-m-d H:i:s'),
                ]);
                DB::table('tb_stok')->where('stok_kode_barang', $getData_fromNama->kode_bibit)->update([
                    'stok_jumlah'           => $getDataStok->stok_jumlah + $request->stok,
                    'nama_bibit' => $getDataStok->nama_bibit + $request->nama,
                    'updated_at'            => date('Y-m-d H:i:s'),
                ]);
            }
        }
        return redirect()->to('/pegawai/produkbibit');
    }

    public function delete_produkbibit(Request $request)
    {
        $session_role = $request->session()->get('role');
        if ($session_role == 1) {
            return redirect()->to('/admin');
        } elseif ($session_role == 3) {
            return redirect()->to('/pemilik');
        } elseif ($session_role == 4) {
            return redirect()->to('/');
        } elseif ($session_role == '') {
            return redirect()->to('/');
        }

        $uri_one = request()->segment(4);
        $getProdukById = DB::table('tb_produk')->where('id_produk', $uri_one)->first();

        // Check if data is found
        if ($getProdukById) {
            $getStokByKode = DB::table('tb_stok')->where('stok_kode_barang', $getProdukById->kode_bibit)->first();
            $numProdukInProduk = DB::table('tb_produk')->where('kode_bibit', $getProdukById->kode_bibit)->count();
            $numProdukInStok = DB::table('tb_stok')->where('stok_kode_barang', $getProdukById->kode_bibit)->count();

            DB::table('tb_produk')->where('id_produk', $uri_one)->delete();
            if ($numProdukInProduk == 1) {
                DB::table('tb_stok')->where('stok_kode_barang', $getProdukById->kode_bibit)->delete();
            } else {
                DB::table('tb_stok')->where('stok_kode_barang', $getProdukById->kode_bibit)->update([
                    'stok_jumlah' => (int)$getStokByKode->stok_jumlah - (int)$getProdukById->stok_bibit,
                    'updated_at' => date('Y-m-d H:i:s'),
                    'nama_bibit' => $getProdukById->nama_bibit,
                ]);
            }
        } else {
            // Handle case when data is not found
            // Redirect or show error message
            return redirect()->back()->with('error', 'Data not found.');
        }

        return redirect()->to('/pegawai/produkbibit');
    }


    public function edit_produkbibit(Request $request)
    {
        $session_role = $request->session()->get('role');
        if ($session_role == 1) {
            return redirect()->to('/admin');
        } elseif ($session_role == 3) {
            return redirect()->to('/pemilik');
        } elseif ($session_role == 4) {
            return redirect()->to('/');
        } elseif ($session_role == '') {
            return redirect()->to('/');
        }

        $uri_one = request()->segment(4);
        $tblProduk = DB::table('tb_produk')->where('id_produk', $uri_one)->first();
        $getuserpemilik = DB::table('tb_user')->where('role_user', '3')->get();

        $data = [
            'menu'              =>  'produkbibit',
            'submenu'           =>  'pegawai',
            'get_produk'        =>  $tblProduk,
            'getuserpemilik'    =>  $getuserpemilik,
        ];
        return view('pegawai/ubah_produkbibit', $data);
    }

    public function update_produkbibit(Request $request)
    {
        $session_role = $request->session()->get('role');
        if ($session_role == 1) {
            return redirect()->to('/admin');
        } elseif ($session_role == 3) {
            return redirect()->to('/pemilik');
        } elseif ($session_role == 4) {
            return redirect()->to('/');
        } elseif ($session_role == '') {
            return redirect()->to('/');
        }

        $uri_one = request()->segment(4);
        if ($request->image1) {
            $imageName = rand(1000, 9999) . time() . '.' . $request->image1->extension();
            $request->image1->move(public_path('images'), $imageName);

            $tblProduk = DB::table('tb_produk')->where('id_produk', $uri_one)->first();
            unlink(public_path('images/') . $tblProduk->gambar_bibit);
            DB::table('tb_produk')->where('id_produk', $uri_one)->update([
                'nama_bibit'        => $request->nama,
                'detail_bibit'      => $request->detail,
                'harga_bibit'       => $request->harga,
                'stok_bibit'        => $request->stok,
                'gambar_bibit'      => $imageName,
                'status_bibit'      => '1',
                'created_produk'    => date('Y-m-d H:i:s'),
            ]);
        } else {
            DB::table('tb_produk')->where('id_produk', $uri_one)->update([
                'nama_bibit'        => $request->nama,
                'detail_bibit'      => $request->detail,
                'harga_bibit'       => $request->harga,
                'stok_bibit'        => $request->stok,
                'status_bibit'      => '1',
                'created_produk'    => date('Y-m-d H:i:s'),
            ]);
        }
        return redirect()->to('/pegawai/produkbibit');
    }

    public function stokbibit(Request $request)
    {
        $session_role = $request->session()->get('role');
        if ($session_role == 1) {
            return redirect()->to('/admin');
        } elseif ($session_role == 3) {
            return redirect()->to('/pemilik');
        } elseif ($session_role == 4) {
            return redirect()->to('/');
        } elseif ($session_role == '') {
            return redirect()->to('/');
        }

        $tblProduk = DB::table('tb_stok')
            // ->rightJoin('tb_produk', 'tb_stok.stok_kode_barang', '=', 'tb_produk.kode_bibit')
            ->get();
        $data = [
            'menu'          =>  'stokbibit',
            'submenu'       =>  'pegawai',
            'dataproduk'    =>  $tblProduk,
        ];
        return view('pegawai/stokbibit', $data);
    }

    public function ongkoskirim(Request $request)
    {
        $session_role = $request->session()->get('role');
        if ($session_role == 1) {
            return redirect()->to('/admin');
        } elseif ($session_role == 3) {
            return redirect()->to('/pemilik');
        } elseif ($session_role == 4) {
            return redirect()->to('/');
        } elseif ($session_role == '') {
            return redirect()->to('/');
        }

        $tblOngkir = DB::table('tb_ongkir')->get();
        $data = [
            'menu'          =>  'ongkir',
            'submenu'       =>  'pegawai',
            'dataongkir'    =>  $tblOngkir,
        ];
        return view('pegawai/ongkir', $data);
    }

    public function ongkoskirim_tambah(Request $request)
    {
        $session_role = $request->session()->get('role');
        if ($session_role == 1) {
            return redirect()->to('/admin');
        } elseif ($session_role == 3) {
            return redirect()->to('/pemilik');
        } elseif ($session_role == 4) {
            return redirect()->to('/');
        } elseif ($session_role == '') {
            return redirect()->to('/');
        }

        $data = [
            'menu'              =>  'ongkir',
            'submenu'           =>  'pegawai',
        ];
        return view('pegawai/ongkir_tambah', $data);
    }

    public function ongkoskirim_create(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        DB::table('tb_ongkir')->insert([
            'ongkir_fromlocation'   => $request->dari,
            'ongkir_tolocation'     => $request->ke,
            'ongkir_price'          => $request->harga,
            'ongkir_created'        => date('Y-m-d H:i:s'),
            'ongkir_updated'        => date('Y-m-d H:i:s'),
        ]);
        return redirect()->to('/pegawai/ongkir');
    }

    public function ongkoskirim_delete(Request $request)
    {
        $uri_one = request()->segment(4);
        DB::table('tb_ongkir')->where('ongkir_id', $uri_one)->delete();
        return redirect()->to('/pegawai/ongkir');
    }

    public function ongkoskirim_ubah(Request $request)
    {
        $session_role = $request->session()->get('role');
        if ($session_role == 1) {
            return redirect()->to('/admin');
        } elseif ($session_role == 3) {
            return redirect()->to('/pemilik');
        } elseif ($session_role == 4) {
            return redirect()->to('/');
        } elseif ($session_role == '') {
            return redirect()->to('/');
        }

        $uri_one = request()->segment(4);
        $tblOngkir = DB::table('tb_ongkir')->where('ongkir_id', $uri_one)->first();

        $data = [
            'menu'              =>  'ongkir',
            'submenu'           =>  'pegawai',
            'dataongkir'        =>  $tblOngkir,
        ];
        return view('pegawai/ongkir_ubah', $data);
    }

    public function ongkoskirim_update(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $uri_one = request()->segment(4);
        DB::table('tb_ongkir')->where('ongkir_id', $uri_one)->update([
            'ongkir_fromlocation'   => $request->dari,
            'ongkir_tolocation'     => $request->ke,
            'ongkir_price'          => $request->harga,
            'ongkir_created'        => date('Y-m-d H:i:s'),
            'ongkir_updated'        => date('Y-m-d H:i:s'),
        ]);
        return redirect()->to('/pegawai/ongkir');
    }

    public function pesanan(Request $request)
    {
        $session_role = $request->session()->get('role');
        if ($session_role == 1) {
            return redirect()->to('/admin');
        } elseif ($session_role == 3) {
            return redirect()->to('/pemilik');
        } elseif ($session_role == 4) {
            return redirect()->to('/');
        } elseif ($session_role == '') {
            return redirect()->to('/');
        }

        $tblTransaksi = DB::table('tb_transaksi')
            ->join('tb_user', 'tb_transaksi.id_user_transaksi', '=', 'tb_user.id_user')
            ->join('tb_status', 'tb_transaksi.status_transaksi', '=', 'tb_status.status_id')
            ->get();
        $data = [
            'menu'          =>  'pesanan',
            'submenu'       =>  'pegawai',
            'tblTransaksi'  =>  $tblTransaksi,
        ];
        return view('pegawai/pesanan', $data);
    }

    public function pesanan_sudahbayar(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $uri_one = request()->segment(4);
        $tblTransaksi = DB::table('tb_transaksi')->where('id_transaksi', $uri_one)->first();
        DB::table('tb_transaksi')->where('id_transaksi', $uri_one)->update([
            'status_transaksi'          => '2',
            'created_transaksi'         => date('Y-m-d H:i:s'),
        ]);
        DB::table('tb_statuspengiriman')->insert([
            'statuspengiriman_id_status'        => '2',
            'statuspengiriman_kodetransaksi'    => $tblTransaksi->kode_transaksi,
            'statuspengiriman_created'          => date('Y-m-d H:i:s'),
        ]);
        return redirect()->to('/pegawai/pesanan');
    }

    public function pesanan_sudahdikirim(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $uri_one = request()->segment(4);
        $tblTransaksi = DB::table('tb_transaksi')->where('id_transaksi', $uri_one)->first();
        DB::table('tb_transaksi')->where('id_transaksi', $uri_one)->update([
            'status_transaksi'          => '3',
            'created_transaksi'         => date('Y-m-d H:i:s'),
        ]);
        DB::table('tb_statuspengiriman')->insert([
            'statuspengiriman_id_status'        => '3',
            'statuspengiriman_kodetransaksi'    => $tblTransaksi->kode_transaksi,
            'statuspengiriman_created'          => date('Y-m-d H:i:s'),
        ]);
        return redirect()->to('/pegawai/pesanan');
    }

    public function pesanan_sudahditerima(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $uri_one = request()->segment(4);
        $tblTransaksi = DB::table('tb_transaksi')->where('id_transaksi', $uri_one)->first();
        DB::table('tb_transaksi')->where('id_transaksi', $uri_one)->update([
            'status_transaksi'          => '4',
            'created_transaksi'         => date('Y-m-d H:i:s'),
        ]);
        DB::table('tb_statuspengiriman')->insert([
            'statuspengiriman_id_status'        => '4',
            'statuspengiriman_kodetransaksi'    => $tblTransaksi->kode_transaksi,
            'statuspengiriman_created'          => date('Y-m-d H:i:s'),
        ]);
        return redirect()->to('/pegawai/pesanan');
    }

    public function monitoringbibit(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $uri_one = request()->segment(4);

        $session_role = $request->session()->get('role');
        if ($session_role == 1) {
            return redirect()->to('/admin');
        } elseif ($session_role == 3) {
            return redirect()->to('/pemilik');
        } elseif ($session_role == 4) {
            return redirect()->to('/');
        } elseif ($session_role == '') {
            return redirect()->to('/');
        }

        $tblTransaksi = DB::table('tb_transaksi')
            ->join('tb_user', 'tb_transaksi.id_user_transaksi', '=', 'tb_user.id_user')
            ->join('tb_status', 'tb_transaksi.status_transaksi', '=', 'tb_status.status_id')
            ->get();
        $data = [
            'menu'                  =>  'monitoringbibit',
            'submenu'               =>  'pegawai',
            'tblTransaksi'          =>  $tblTransaksi,
        ];

        return view('pegawai/monitoringbibit', $data);
    }

    public function monitoringbibit_detail(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $session_role = $request->session()->get('role');
        if ($session_role == 1) {
            return redirect()->to('/admin');
        } elseif ($session_role == 3) {
            return redirect()->to('/pemilik');
        } elseif ($session_role == 4) {
            return redirect()->to('/');
        } elseif ($session_role == '') {
            return redirect()->to('/');
        }
        $uri_one = request()->segment(4);

        $tblTransaksi = DB::table('tb_transaksi')
            ->join('tb_user', 'tb_transaksi.id_user_transaksi', '=', 'tb_user.id_user')
            ->join('tb_status', 'tb_transaksi.status_transaksi', '=', 'tb_status.status_id')
            ->where('id_transaksi', $uri_one)
            ->first();

        $tblPerkembangan = DB::table('tb_perkembangan')
        ->where('perkembangan_kode_transaksi', $tblTransaksi->kode_transaksi)
        ->get();
        $data = [
            'menu'          =>  'monitoringbibit',
            'submenu'       =>  'pegawai',
            'tblTransaksi'  =>  $tblTransaksi,
            'tblPerkembangan'   => $tblPerkembangan

        ];

        return view('pegawai/monitoringbibit_detail', $data);
    }

    public function monitoringbibit_tambah(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $session_role = $request->session()->get('role');
        if ($session_role == 1) {
            return redirect()->to('/admin');
        } elseif ($session_role == 3) {
            return redirect()->to('/pemilik');
        } elseif ($session_role == 4) {
            return redirect()->to('/');
        } elseif ($session_role == '') {
            return redirect()->to('/');
        }
        $uri_one = request()->segment(4);

        $tblTransaksi = DB::table('tb_transaksi')
            ->join('tb_user', 'tb_transaksi.id_user_transaksi', '=', 'tb_user.id_user')
            ->join('tb_status', 'tb_transaksi.status_transaksi', '=', 'tb_status.status_id')
            ->where('id_transaksi', $uri_one)
            ->first();

        $data = [
            'menu'          =>  'monitoringbibit',
            'submenu'       =>  'pegawai',
            'tblTransaksi'  =>  $tblTransaksi,
        ];

        return view('pegawai/monitoringbibit_tambah', $data);
    }

    public function monitoringbibit_create(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $uri_one = request()->segment(4);

        $imageName = rand(1000, 9999) . time() . '.' . $request->image1->extension();
        $request->image1->move(public_path('images'), $imageName);
        $getTblTransaksi = DB::table('tb_transaksi')->where('id_transaksi', $uri_one)->first();
        if ($request->image1) {
            DB::table('tb_perkembangan')->insert([
                'perkembangan_kode_transaksi'    => $getTblTransaksi->kode_transaksi,
                'perkembangan_gambar'        => $imageName,
                'perkembangan_umur'        => $request->umur,
                'perkembangan_tinggi'      => $request->tinggi,
                'perkembangan_deskripsi'       => $request->keterangan,
                'perkembangan_created'    => date('Y-m-d H:i:s'),
                'perkembangan_updated'    => date('Y-m-d H:i:s'),
            ]);
            return redirect()->to('/pegawai/monitoringbibit/detail/' . $uri_one);
        }
    }

    public function monitoringbibit_delete(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $uri_one = request()->segment(4);
        DB::table('tb_perkembangan')->where('id_pbk', $uri_one)->delete();

    }
}
