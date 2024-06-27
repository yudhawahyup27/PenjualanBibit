<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class Pemilik extends Controller
{
    //
    public function redirectdashboard()
    {
        return redirect()->to('/pemilik/dashboard22');
    }

    public function dashboard(Request $request)
    {
        $session_role = $request->session()->get('role');
        if ($session_role == 1) {
            return redirect()->to('/admin');
        } elseif ($session_role == 2) {
            return redirect()->to('/pegawai');
        } elseif ($session_role == 4 || $session_role == '') {
            return redirect()->to('/');
        }

        // Mendapatkan nilai input dari request atau default ke tanggal saat ini
        $selectedDay = $request->input('selectedDay', date('d'));
        $selectedMonth = $request->input('selectedMonth', date('m'));
        $selectedYear = $request->input('selectedYear', date('Y'));

        // Query untuk jumlah transaksi per hari (Eceran)
        $transactionsPerDayEceran = DB::table('tb_keranjang')
            ->select(DB::raw('DAY(created_keranjang) as day'), DB::raw('SUM(price_keranjang) as total'))
            ->whereMonth('created_keranjang', $selectedMonth)
            ->whereYear('created_keranjang', $selectedYear)
            ->groupBy('day')
            ->get();

        // Query untuk jumlah transaksi per hari (Borong)
        $transactionsPerDayBorong = DB::table('tb_transaksi_borong')
            ->select(DB::raw('DAY(created_at) as day'), DB::raw('SUM(total_transaksi) as total'))
            ->whereMonth('created_at', $selectedMonth)
            ->whereYear('created_at', $selectedYear)
            ->groupBy('day')
            ->get();

        // Query untuk jumlah transaksi per bulan (Eceran)
        $transactionsPerMonthEceran = DB::table('tb_keranjang')
            ->select(DB::raw('MONTH(created_keranjang) as month'), DB::raw('SUM(price_keranjang) as total'))
            ->whereYear('created_keranjang', $selectedYear)
            ->groupBy('month')
            ->get();

        // Query untuk jumlah transaksi per bulan (Borong)
        $transactionsPerMonthBorong = DB::table('tb_transaksi_borong')
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(total_transaksi) as total'))
            ->whereYear('created_at', $selectedYear)
            ->groupBy('month')
            ->get();

        // Query untuk jumlah transaksi per tahun (Eceran)
        $transactionsPerYearEceran = DB::table('tb_keranjang')
            ->select(DB::raw('YEAR(created_keranjang) as year'), DB::raw('SUM(price_keranjang) as total'))
            ->groupBy('year')
            ->get();

        // Query untuk jumlah transaksi per tahun (Borong)
        $transactionsPerYearBorong = DB::table('tb_transaksi_borong')
            ->select(DB::raw('YEAR(created_at) as year'), DB::raw('SUM(total_transaksi) as total'))
            ->groupBy('year')
            ->get();

        $data = [
            'menu' => 'dashboard2',
            'submenu' => 'pemilik',
            'transactionsPerDayEceran' => $transactionsPerDayEceran,
            'transactionsPerMonthEceran' => $transactionsPerMonthEceran,
            'transactionsPerYearEceran' => $transactionsPerYearEceran,
            'transactionsPerDayBorong' => $transactionsPerDayBorong,
            'transactionsPerMonthBorong' => $transactionsPerMonthBorong,
            'transactionsPerYearBorong' => $transactionsPerYearBorong,
            'selectedDay' => $selectedDay,
            'selectedMonth' => $selectedMonth,
            'selectedYear' => $selectedYear,
        ];

        return view('pemilik.dashboard', $data);
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


        // $tblProduk = DB::table('tb_produk')->where('produk_id_user', $request->session()->get('id'))->get();
        $tblProduk = DB::table('tb_produk')->get();
        $data = [
            'menu'          =>  'produkbibit',
            'submenu'       =>  'pemilik',
            'dataproduk'    => $tblProduk,
        ];
        return view('pemilik/produkbibit', $data);
    }

    public function add_produkbibit(Request $request)
    {
        $session_role = $request->session()->get('role');
        if ($session_role == 1) {
            return redirect()->to('/admin');
        } elseif ($session_role == 2) {
            return redirect()->to('/pegawai');
        } elseif ($session_role == 4) {
            return redirect()->to('/');
        } elseif ($session_role == '') {
            return redirect()->to('/');
        }

        $data = [
            'menu'              =>  'produkbibit',
            'submenu'           =>  'pemilik',
        ];
        return view('pemilik/tambah_produkbibit', $data);
    }

    public function create_produkbibit(Request $request)
    {
        $session_role = $request->session()->get('role');
        if ($session_role == 1) {
            return redirect()->to('/admin');
        } elseif ($session_role == 2) {
            return redirect()->to('/pegawai');
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
                    'produk_id_user'    => $request->session()->get('id'),
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
                    'stok_jumlah'           => $request->stok,
                    'created_at'            => date('Y-m-d H:i:s'),
                ]);
            } else {
                $getData_fromNama = DB::table('tb_produk')->where('nama_bibit', $request->nama)->first();
                $getDataStok = DB::table('tb_stok')->where('stok_kode_barang', $getData_fromNama->kode_bibit)->first();
                DB::table('tb_produk')->insert([
                    'kode_bibit'        => $getData_fromNama->kode_bibit,
                    'produk_id_user'    => $request->session()->get('id'),
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
                    'updated_at'            => date('Y-m-d H:i:s'),
                ]);
            }
        } else {
            $getCount_fromNama = DB::table('tb_produk')->where('nama_bibit', $request->nama)->count();
            if ($getCount_fromNama < 1) {
                DB::table('tb_produk')->insert([
                    'kode_bibit'        => $kodeBarang,
                    'produk_id_user'    => $request->session()->get('id'),
                    'nama_bibit'        => $request->nama,
                    'detail_bibit'      => $request->detail,
                    'harga_bibit'       => $request->harga,
                    'stok_bibit'        => $request->stok,
                    'status_bibit'      => '1',
                    'created_produk'    => date('Y-m-d H:i:s'),
                ]);
                DB::table('tb_stok')->insert([
                    'stok_kode_barang'      => $kodeBarang,
                    'stok_jumlah'           => $request->stok,
                    'created_at'            => date('Y-m-d H:i:s'),
                ]);
            } else {
                $getData_fromNama = DB::table('tb_produk')->where('nama_bibit', $request->nama)->first();
                $getDataStok = DB::table('tb_stok')->where('stok_kode_barang', $getData_fromNama->kode_bibit)->first();
                DB::table('tb_produk')->insert([
                    'kode_bibit'        => $getData_fromNama->kode_bibit,
                    'produk_id_user'    => $request->session()->get('id'),
                    'nama_bibit'        => $request->nama,
                    'detail_bibit'      => $request->detail,
                    'harga_bibit'       => $request->harga,
                    'stok_bibit'        => $request->stok,
                    'status_bibit'      => '1',
                    'created_produk'    => date('Y-m-d H:i:s'),
                ]);
                DB::table('tb_stok')->where('stok_kode_barang', $getData_fromNama->kode_bibit)->update([
                    'stok_jumlah'           => $getDataStok->stok_jumlah + $request->stok,
                    'updated_at'            => date('Y-m-d H:i:s'),
                ]);
            }
        }
        return redirect()->to('/pemilik/produkbibit');
    }

    public function delete_produkbibit(Request $request)
    {
        $session_role = $request->session()->get('role');
        if ($session_role == 1) {
            return redirect()->to('/admin');
        } elseif ($session_role == 2) {
            return redirect()->to('/pegawai');
        } elseif ($session_role == 4) {
            return redirect()->to('/');
        } elseif ($session_role == '') {
            return redirect()->to('/');
        }

        $uri_one = request()->segment(4);
        $getProdukById = DB::table('tb_produk')->where('id_produk', $uri_one)->first();
        $getStokByKode = DB::table('tb_stok')->where('stok_kode_barang', $getProdukById->kode_bibit)->first();
        $numProdukInProduk = DB::table('tb_produk')->where('kode_bibit', $getProdukById->kode_bibit)->count();
        $numProdukInStok = DB::table('tb_stok')->where('stok_kode_barang', $getProdukById->kode_bibit)->count();

        DB::table('tb_produk')->where('id_produk', $uri_one)->delete();
        if ($numProdukInProduk == 1) {
            DB::table('tb_stok')->where('stok_kode_barang', $getProdukById->kode_bibit)->delete();
        }else {
            DB::table('tb_stok')->where('stok_kode_barang', $getProdukById->kode_bibit)->update([
                'stok_jumlah'           => $getStokByKode->stok_jumlah - $getProdukById->stok_bibit,
                'updated_at'            => date('Y-m-d H:i:s'),
            ]);
        }
        return redirect()->to('/pemilik/produkbibit');
    }

    public function edit_produkbibit(Request $request)
    {
        $session_role = $request->session()->get('role');
        if ($session_role == 1) {
            return redirect()->to('/admin');
        } elseif ($session_role == 2) {
            return redirect()->to('/pegawai');
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
            'submenu'           =>  'pemilik',
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
        } elseif ($session_role == 2) {
            return redirect()->to('/pegawai');
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
        return redirect()->to('/pemilik/produkbibit');
    }

    public function stokbibit(Request $request)
    {
        $session_role = $request->session()->get('role');
        if ($session_role == 1) {
            return redirect()->to('/admin');
        } elseif ($session_role == 2) {
            return redirect()->to('/pegawai');
        } elseif ($session_role == 4) {
            return redirect()->to('/');
        } elseif ($session_role == '') {
            return redirect()->to('/');
        }

        $tblStok = DB::table('tb_produk')->get();
        $data = [
            'menu'          =>  'stokbibit',
            'submenu'       =>  'pemilik',
            'dataproduk'    =>  $tblStok,
        ];
        return view('pemilik/stokbibit', $data);
    }


    public function laporanpenjualan(Request $request)
    {
        // Ambil nilai filter dari request atau default ke null
        $selectedDay = $request->input('selectedDay', null);
        $selectedMonth = $request->input('selectedMonth', null);
        $selectedYear = $request->input('selectedYear', null);

        // Query untuk data laporan penjualan dengan filter
        $query = DB::table('tb_keranjang as tk')
            ->select(
                'tk.kode_transaksi as kode_transaksi',
                'p.kode_bibit',
                'p.nama_bibit',
                'tk.price_keranjang as harga_beli',
                'p.terjual_bibit as terjual',
                'tk.created_keranjang as tanggal_transaksi'
            )
            ->join('tb_produk as p', 'tk.keranjang_id_produk', '=', 'p.id_produk')
            ->join('tb_transaksi as t', 'tk.kode_transaksi', '=', 't.kode_transaksi');

        // Apply filters based on the selected values
        if ($selectedDay) {
            $query->whereDay('tk.created_keranjang', $selectedDay);
        }
        if ($selectedMonth) {
            $query->whereMonth('tk.created_keranjang', $selectedMonth);
        }
        if ($selectedYear) {
            $query->whereYear('tk.created_keranjang', $selectedYear);
        }

        $laporanData = $query->paginate(10);

        // Definisikan variabel menu untuk navigasi
        $menu = 'laporanpenjualan';

        // Data yang akan dikirimkan ke view
        $data = [
            'menu' => $menu,
            'submenu' => 'pemilik',
            'data' => $laporanData,
            'selectedDay' => $selectedDay,
            'selectedMonth' => $selectedMonth,
            'selectedYear' => $selectedYear,
        ];
// dd($data);
        return view('pemilik.laporanpenjualan', $data);
    }

    public function laporanpenjualanborongan(Request $request)
    {
        // Get filter values from request or set to null if not present
        $selectedDay = $request->input('selectedDay', null);
        $selectedMonth = $request->input('selectedMonth', null);
        $selectedYear = $request->input('selectedYear', null);

        // Start building the query
        $query = DB::table('tb_transaksi_borong as tb')
            ->select(
                'tb.kode_transaksi as kode_transaksi',
                'tb.nama_bibit as nama_bibit',
                'tb.total_transaksi as harga_beli',
                'tb.kuantitas_bibit as terjual',
                'tb.created_at as tanggal_transaksi'
            );

        // Apply filters if provided
        if ($selectedDay) {
            $query->whereDay('tb.created_at', $selectedDay);
        }
        if ($selectedMonth) {
            $query->whereMonth('tb.created_at', $selectedMonth);
        }
        if ($selectedYear) {
            $query->whereYear('tb.created_at', $selectedYear);
        }

        // Get the paginated result
        $laporanData = $query->paginate(10);

        // Definisikan variabel menu untuk navigasi
        $menu = 'laporanpenjualan';

        // Data yang akan dikirimkan ke view
        $data = [
            'menu' => $menu,
            'submenu' => 'pemilik',
            'data' => $laporanData,
            'selectedDay' => $selectedDay,
            'selectedMonth' => $selectedMonth,
            'selectedYear' => $selectedYear,
        ];

        return view('pemilik.laporanpenjualanborongan', $data);
    }



}
