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
        return redirect()->to('/pegawai/produkbibit');
    }

    // public function dashboard(Request $request)
    // {
    //     $session_role = $request->session()->get('role');
    //     if ($session_role == 1) {
    //         return redirect()->to('/admin');
    //     } elseif ($session_role == 3) {
    //         return redirect()->to('/pemilik');
    //     } elseif ($session_role == 4) {
    //         return redirect()->to('/');
    //     } elseif ($session_role == '') {
    //         return redirect()->to('/');
    //     }

    //     $data = [
    //         'menu'      =>  'dashboard',
    //         'submenu'   =>  'pegawai',
    //     ];
    //     return view('pegawai/dashboard', $data);
    // }

    public function produkbibit(Request $request)
    {
        $tblProduk = DB::table('tb_produk')
            ->join('tb_user', 'tb_produk.produk_id_user', '=', 'tb_user.id_user')
            ->get();
        $data = [
            'menu'          =>  'produkbibit',
            'submenu'       =>  'pegawai',
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

        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'detail' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'harga_borongan' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'image1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            // Generate kode bibit
            $getProdukById = DB::table('tb_produk')->orderBy('id_produk', 'DESC')->limit(1)->first();
            if ($getProdukById) {
                $urutan = (int) substr($getProdukById->kode_bibit, 3, 3);
                $urutan++;
                $huruf = "A";
                $kodeBarang = $huruf . sprintf("%03s", $urutan);
            } else {
                $kodeBarang = 'A001';
            }

            // Proses upload gambar jika ada
            if ($request->hasFile('image1')) {
                $imageName = time() . '_' . rand(1000, 9999) . '.' . $request->file('image1')->extension();
                $request->file('image1')->move(public_path('images'), $imageName);
            } else {
                $imageName = null;
            }

            // Cek apakah nama bibit sudah ada
            $getCount_fromNama = DB::table('tb_produk')->where('nama_bibit', $request->input('nama'))->count();
            if ($getCount_fromNama < 1) {
                // Insert data produk baru
                DB::table('tb_produk')->insert([
                    'kode_bibit' => $kodeBarang,
                    'produk_id_user' => $request->session()->get('id'), // Sesuaikan dengan logic Anda
                    'nama_bibit' => $request->input('nama'),
                    'detail_bibit' => $request->input('detail'),
                    'harga_bibit' => $request->input('harga'),
                    'harga_borong' => $request->input('harga_borongan'),
                    'stok_bibit' => $request->input('stok'),
                    'gambar_bibit' => $imageName,
                    'status_bibit' => '1',
                    'created_produk' => now(),
                ]);
                // Insert atau update stok
                DB::table('tb_stok')->updateOrInsert(
                    ['stok_kode_barang' => $kodeBarang],
                    [
                        'nama_bibit' => $request->input('nama'),
                        'stok_jumlah' => $request->input('stok'),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            } else {
                // Jika nama bibit sudah ada, update stok
                $getData_fromNama = DB::table('tb_produk')->where('nama_bibit', $request->input('nama'))->first();
                $getDataStok = DB::table('tb_stok')->where('stok_kode_barang', $getData_fromNama->kode_bibit)->first();
                DB::table('tb_produk')->where('nama_bibit', $request->input('nama'))->update([
                    'detail_bibit' => $request->input('detail'),
                    'harga_bibit' => $request->input('harga'),
                    'harga_borong' => $request->input('harga_borongan'),
                    'stok_bibit' => $request->input('stok'),
                    'gambar_bibit' => $imageName,
                    'status_bibit' => '1',
                    'created_produk' => now(),
                ]);
                DB::table('tb_stok')->where('stok_kode_barang', $getData_fromNama->kode_bibit)->update([
                    'stok_jumlah' => $getDataStok->stok_jumlah + $request->input('stok'),
                    'nama_bibit' => $getDataStok->nama_bibit . ' ' . $request->input('nama'),
                    'updated_at' => now(),
                ]);
            }

            return redirect()->to('/pegawai/produkbibit')->with('success', 'Produk berhasil ditambahkan!');
        } catch (\Exception $e) {
            // Tangkap dan tampilkan error jika terjadi
            return redirect()->back()->withErrors(['error' => 'Failed to add product: ' . $e->getMessage()]);
        }
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
                'harga_borong'        => $request->harga_borongan,
                'gambar_bibit'      => $imageName,
                'status_bibit'      => '1',
                'updated_produk'    => date('Y-m-d H:i:s'),
            ]);
        } else {
            DB::table('tb_produk')->where('id_produk', $uri_one)->update([
                'nama_bibit'        => $request->nama,
                'detail_bibit'      => $request->detail,
                'harga_bibit'       => $request->harga,
                'harga_borong'        => $request->harga_borongan,
                'stok_bibit'        => $request->stok,
                'status_bibit'      => '1',
                'updated_produk'    => date('Y-m-d H:i:s'),
            ]);
        }

        return redirect()->to('/pegawai/produkbibit');
    }
    public function editProdukbibitStock($id, Request $request)
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

        $tblProduk = DB::table('tb_produk')->where('id_produk', $id)->first();
        $getuserpemilik = DB::table('tb_user')->where('role_user', '3')->get();

        if (!$tblProduk) {
            return redirect()->to('/pegawai/produkbibit')->with('error', 'Produk bibit tidak ditemukan.');
        }

        $data = [
            'menu'              =>  'produkbibit',
            'submenu'           =>  'pegawai',
            'get_produk'        =>  $tblProduk,
            'getuserpemilik'    =>  $getuserpemilik,
        ];
        return view('pegawai/ubah_produkbibitstock', $data);
    }

    public function updateProdukbibitStock($id, Request $request)
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

        $tblProduk = DB::table('tb_produk')->where('id_produk', $id)->first();
        if ($request->image1) {
            $imageName = rand(1000, 9999) . time() . '.' . $request->image1->extension();
            $request->image1->move(public_path('images'), $imageName);

            if ($tblProduk && $tblProduk->gambar_bibit) {
                unlink(public_path('images/') . $tblProduk->gambar_bibit);
            }

            DB::table('tb_produk')->where('id_produk', $id)->update([
                'nama_bibit'        => $request->nama,
                'detail_bibit'      => $request->detail,
                'harga_bibit'       => $request->harga,
                'stok_bibit'        => $request->stok,
                'harga_borong'      => $request->harga_borongan,
                'gambar_bibit'      => $imageName,
                'status_bibit'      => '1',
                'updated_produk'    => now(),
            ]);
        } else {
            DB::table('tb_produk')->where('id_produk', $id)->update([
                'nama_bibit'        => $request->nama,
                'detail_bibit'      => $request->detail,
                'harga_bibit'       => $request->harga,
                'harga_borong'      => $request->harga_borongan,
                'stok_bibit'        => $request->stok,
                'status_bibit'      => '1',
                'updated_produk'    => now(),
            ]);
        }
        return redirect()->to('/pegawai/produkbibit');
    }


    public function stokbibit(Request $request)
    {

        $tblProduk = DB::table('tb_produk')
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

        $tblOngkir = DB::table('tb_kecamatan')->get();
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
        DB::table('tb_kecamatan')->insert([
            'kecamatan_name'     => $request->ke,
            'ongkir'          => $request->harga,
            'kecamatan_created'        => date('Y-m-d H:i:s'),
            'kecamatan_updated'        => date('Y-m-d H:i:s'),
        ]);
        return redirect()->to('/pegawai/ongkir');
    }

    public function ongkoskirim_delete(Request $request)
    {
        $uri_one = request()->segment(4);
        DB::table('tb_kecamatan')->where('kecamatan_id', $uri_one)->delete();
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
        $tblOngkir = DB::table('tb_kecamatan')->where('kecamatan_id', $uri_one)->first();

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
        DB::table('tb_kecamatan')->where('kecamatan_id', $uri_one)->update([
            // 'ongkir_fromlocation'   => 'Kertosono',
            'Kecamatan_name'     => $request->ke,
            'ongkir'          => $request->harga,
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
        } elseif ($session_role == 4 || $session_role == '') {
            return redirect()->to('/');
        }


            $pesen = DB::table('tb_transaksi')->join('tb_user', 'tb_transaksi.id_user_transaksi', '=', 'tb_user.id_user')
            ->join('tb_kecamatan','tb_transaksi.pengiriman','=','tb_kecamatan.kecamatan_id')
            ->join('tb_produk','tb_transaksi.id_produk','=','tb_produk.id_produk')
            ->orderBy('created_transaksi','desc')
            ->get();

                // ->join('tb_user', 'tb_transaksi.id_user_transaksi', '=', 'tb_user.id_user')
                // ->join('tb_status', 'tb_transaksi.status_transaksi', '=', 'tb_status.status_id')
                // ->select('tb_transaksi.*', 'tb_user.nama_user', 'tb_status.status_name')

            // Debug data
            // dd($pesen);

            $data = [
                'menu'          =>  'pesanan',
                'submenu'       =>  'pegawai',
                'pesen'  =>  $pesen,
            ];

            return view('pegawai.pesanan', $data);
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
    public function pesanan_sudahdiproses(Request $request)
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

        $tblTransaksi = DB::table('tb_transaksi_borong')
        ->orderBy('id','desc')
        ->join('tb_user', 'tb_transaksi_borong.id_user_transaksi', '=', 'tb_user.id_user')
        ->join('tb_produk', 'tb_transaksi_borong.nama_bibit', '=', 'tb_produk.id_produk')
        ->join('tb_status','tb_transaksi_borong.status_transaksi','=','tb_status.status_id')
        ->join('tb_kecamatan','tb_transaksi_borong.pengiriman','=','tb_kecamatan.kecamatan_id')
            ->get();

            // dd($tblTransaksi);

        $data = [
            'menu'                  =>  'monitoringbibit',
            'submenu'               =>  'pegawai',
            'tblTransaksi'          =>  $tblTransaksi,
        ];

        return view('pegawai/monitoringbibit', $data);
    }


    public function monitoringbibit_detail(Request $request, $id)
    {
        date_default_timezone_set('Asia/Jakarta');

        $session_role = $request->session()->get('role');
        if ($session_role == 1) {
            return redirect()->to('/admin');
        } elseif ($session_role == 3) {
            return redirect()->to('/pemilik');
        } elseif ($session_role == 4 || $session_role == '') {
            return redirect()->to('/');
        }

        // Tampilkan nilai-nilai dari $request tanpa validasi
        // dd($request->all());

        if ($request->hasFile('perkembangan_gambar')) {
            $file = $request->file('perkembangan_gambar');
            $filename = time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('image'), $filename);

            DB::table('tb_perkembangan')->insert([
                'perkembangan_kode_transaksi' => $id,
                'perkembangan_gambar' => $filename,
                'perkembangan_tanggal' => $request->input('perkembangan_tanggal'),
                'perkembangan_umur' => $request->input('perkembangan_umur'),
                'perkembangan_tinggi' => $request->input('perkembangan_tinggi'),
                'perkembangan_deskripsi' => $request->input('perkembangan_deskripsi'),
                'perkembangan_created' => now(),
                'perkembangan_updated' => now(),
            ]);

            return redirect()->to('/pegawai/monitoringbibit')->with('success', 'Data berhasil ditambahkan');
        }

        $tblTransaksi = DB::table('tb_perkembangan')
            ->where('perkembangan_kode_transaksi', $id)
            ->get();

        $data = [
            'menu' => 'monitoringbibit',
            'submenu' => 'pegawai',
            'id' => $id,
            'tblTransaksi' => $tblTransaksi,
        ];

        // Load view dengan data yang telah disiapkan
        return view('pegawai/monitoringbibit_detail', $data);
    }



    // public function monitoringbibit_tambah(Request $request)
    // {
    //     date_default_timezone_set('Asia/Jakarta');

    //     $session_role = $request->session()->get('role');
    //     if ($session_role == 1) {
    //         return redirect()->to('/admin');
    //     } elseif ($session_role == 3) {
    //         return redirect()->to('/pemilik');
    //     } elseif ($session_role == 4) {
    //         return redirect()->to('/');
    //     } elseif ($session_role == '') {
    //         return redirect()->to('/');
    //     }
    //     $uri_one = request()->segment(4);

    //     $tblTransaksi = DB::table('tb_transaksi_borong')
    //         ->join('tb_user', 'tb_transaksi_borong.id_user_transaksi', '=', 'tb_user.id_user')
    //         ->join('tb_status', 'tb_transaksi_borong.status_transaksi', '=', 'tb_status.status_id')
    //         ->where('id_transaksi', $uri_one)
    //         ->first();

    //     $data = [
    //         'menu'          =>  'monitoringbibit',
    //         'submenu'       =>  'pegawai',
    //         'tblTransaksi'  =>  $tblTransaksi,
    //     ];

    //     return view('pegawai/monitoringbibit_tambah', $data);
    // }

    // public function monitoringbibit_create(Request $request)
    // {
    //     date_default_timezone_set('Asia/Jakarta');
    //     $uri_one = request()->segment(4);

    //     $imageName = rand(1000, 9999) . time() . '.' . $request->image1->extension();
    //     $request->image1->move(public_path('images'), $imageName);
    //     $getTblTransaksi = DB::table('tb_transaksi')->where('id_transaksi', $uri_one)->first();
    //     if ($request->image1) {
    //         DB::table('tb_perkembangan')->insert([
    //             'perkembangan_kode_transaksi'    => $getTblTransaksi->kode_transaksi,
    //             'perkembangan_gambar'        => $imageName,
    //             'perkembangan_umur'        => $request->umur,
    //             'perkembangan_tinggi'      => $request->tinggi,
    //             'perkembangan_deskripsi'       => $request->keterangan,
    //             'perkembangan_created'    => date('Y-m-d H:i:s'),
    //             'perkembangan_updated'    => date('Y-m-d H:i:s'),
    //         ]);
    //         return redirect()->to('/pegawai/monitoringbibit/detail/');
    //     }
    // }

    public function monitoringbibit_delete(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $uri_one = request()->segment(4);
        DB::table('tb_perkembangan')->where('id_pbk', $uri_one)->delete();

    }



    public function pesanan_sudahbayarborong(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $uri_one = request()->segment(4);
        $tblTransaksi = DB::table('tb_transaksi_borong')->where('id', $uri_one)->first();

        if ($tblTransaksi) {
            DB::table('tb_transaksi_borong')->where('id', $uri_one)->update([
                'status_transaksi' => '2',
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            return redirect()->to('/pegawai/monitoringbibit');
        } else {
            // Handle the case when no record is found
            return redirect()->to('/pegawai/monitoringbibit')->with('error', 'Transaction not found.');
        }
    }



    public function pesanan_sudahdikirimborong(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $uri_one = request()->segment(4);
        $tblTransaksi = DB::table('tb_transaksi_borong')->where('id', $uri_one)->first();

        if ($tblTransaksi) {
            DB::table('tb_transaksi_borong')->where('id', $uri_one)->update([
                'status_transaksi' => '3',
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            return redirect()->to('/pegawai/monitoringbibit');
        } else {
            // Handle the case when no record is found
            return redirect()->to('/pegawai/monitoringbibit')->with('error', 'Transaction not found.');
        }
    }
    public function pesanan_sudahdiprosesborong(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $uri_one = request()->segment(4);
        $tblTransaksi = DB::table('tb_transaksi_borong')->where('id', $uri_one)->first();

        if ($tblTransaksi) {
            DB::table('tb_transaksi_borong')->where('id', $uri_one)->update([
                'status_transaksi' => '2',
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            return redirect()->to('/pegawai/monitoringbibit');
        } else {
            // Handle the case when no record is found
            return redirect()->to('/pegawai/monitoringbibit')->with('error', 'Transaction not found.');
        }
    }


    public function pesanan_sudahditerimaborong(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $uri_one = request()->segment(4);
        $tblTransaksi = DB::table('tb_transaksi_borong')->where('id', $uri_one)->first();

        if ($tblTransaksi) {
            DB::table('tb_transaksi_borong')->where('id', $uri_one)->update([
                'status_transaksi' => '4',
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            return redirect()->to('/pegawai/monitoringbibit');
        } else {
            // Handle the case when no record is found
            return redirect()->to('/pegawai/monitoringbibit')->with('error', 'Transaction not found.');
        }
    }
    public function getOngkir($kecamatan_id)
    {
        $kecamatan = DB::table('tb_kecamatan')::find($kecamatan_id);
        return response()->json(['ongkir' => $kecamatan->ongkir]);
    }
}
