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
        // Fetch all data without any filter
        $allTransactionsEceran = DB::table('tb_transaksi')
            ->select(DB::raw('DAY(created_transaksi) as day'), DB::raw('MONTH(created_transaksi) as month'), DB::raw('YEAR(created_transaksi) as year'), DB::raw('SUM(total_transaksi) as total'))
            ->groupBy('day', 'month', 'year')
            ->get();

        $allTransactionsBorong = DB::table('tb_transaksi_borong')
            ->select(DB::raw('DAY(created_at) as day'), DB::raw('MONTH(created_at) as month'), DB::raw('YEAR(created_at) as year'), DB::raw('SUM(total_transaksi) as total'))
            ->groupBy('day', 'month', 'year')
            ->get();

            
        // Get filter inputs
        $selectedDay = $request->input('selectedDay', 'all');
        $selectedMonth = $request->input('selectedMonth', 'all');
        $selectedYear = $request->input('selectedYear', 'all');

        // Filter data based on selected inputs
        $filteredTransactionsEceran = $allTransactionsEceran->filter(function ($transaction) use ($selectedDay, $selectedMonth, $selectedYear) {
            return ($selectedYear === 'all' || $transaction->year == $selectedYear) &&
                   ($selectedMonth === 'all' || $transaction->month == $selectedMonth) &&
                   ($selectedDay === 'all' || $transaction->day == $selectedDay);
        });

        $filteredTransactionsBorong = $allTransactionsBorong->filter(function ($transaction) use ($selectedDay, $selectedMonth, $selectedYear) {
            return ($selectedYear === 'all' || $transaction->year == $selectedYear) &&
                   ($selectedMonth === 'all' || $transaction->month == $selectedMonth) &&
                   ($selectedDay === 'all' || $transaction->day == $selectedDay);
        });

        // Group filtered data by day, month, and year as needed
        $transactionsPerDayEceran = $filteredTransactionsEceran->groupBy('day');
        $transactionsPerMonthEceran = $filteredTransactionsEceran->groupBy('month');
        $transactionsPerYearEceran = $filteredTransactionsEceran->groupBy('year');

        $transactionsPerDayBorong = $filteredTransactionsBorong->groupBy('day');
        $transactionsPerMonthBorong = $filteredTransactionsBorong->groupBy('month');
        $transactionsPerYearBorong = $filteredTransactionsBorong->groupBy('year');

        // Fill missing months if selected year only
        if ($selectedMonth === 'all' && $selectedDay === 'all') {
            $transactionsPerMonthEceran = $this->fillMissingMonths($transactionsPerMonthEceran);
            $transactionsPerMonthBorong = $this->fillMissingMonths($transactionsPerMonthBorong);
        }

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

    private function fillMissingMonths($data)
    {
        $data = $data->keyBy('month')->all();
        for ($i = 1; $i <= 12; $i++) {
            if (!isset($data[$i])) {
                $data[$i] = collect([(object)[
                    'month' => $i,
                    'total' => 0
                ]]);
            }
        }
        ksort($data);
        return collect($data);
    }

    public function produkbibit2(Request $request)
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
        // Retrieve data produk
        $tblProduk = DB::table('tb_produk')->get();

        $data = [
            'menu' => 'bibit',
            'submenu' => 'pemilik',
            'dataproduk' => $tblProduk,
        ];

        return view('pemilik/produk', $data);
    }
    public function add_bibit(Request $request)
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
            'menu'              =>  'bibit',
            'submenu'           =>  'pemilik',
        ];
        return view('pemilik.tambah_bibit', $data);
    }

    public function create_bibit(Request $request)
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
        return redirect()->to('/pemilik/bibit');
    }

    public function delete_bibit(Request $request)
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
        return redirect()->to('/pemilik/bibit');
    }

    public function edit_bibit(Request $request)
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
            'menu'              =>  'bibit',
            'submenu'           =>  'pemilik',
            'get_produk'        =>  $tblProduk,
            'getuserpemilik'    =>  $getuserpemilik,
        ];
        return view('pegawai/ubah_bibit', $data);
    }

    public function update_bibit(Request $request)
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
        return redirect()->to('/pemilik/bibit');
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
            'menu'          =>  'stokbibit2',
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

        // Query untuk data laporan penjualan tanpa filter
        $query = DB::table('tb_transaksi as tk')
            ->select(
                'tk.kode_transaksi as kode_transaksi',
                'p.kode_bibit',
                'p.nama_bibit',
                'tk.total_transaksi as harga_beli',
                'tk.Qty_beli as terjual',
                'tk.created_transaksi as tanggal_transaksi'
            )
            ->join('tb_produk as p', 'tk.id_produk', '=', 'p.id_produk');
            // ->join('tb_transaksi as t', 'tk.kode_transaksi', '=', 't.kode_transaksi');

        // Ambil semua data tanpa filter
        $allData = $query->get();

        // Terapkan filter jika ada input dari pengguna
        if ($selectedDay) {
            $query->whereDay('tk.created_transaksi', $selectedDay);
        }
        if ($selectedMonth) {
            $query->whereMonth('tk.created_transaksi', $selectedMonth);
        }
        if ($selectedYear) {
            $query->whereYear('tk.created_transaksi', $selectedYear);
        }

        $laporanData = $query->paginate(10);

        // Debug: cek hasil query
        // dd($laporanData);

        // Definisikan variabel menu untuk navigasi
        $menu = 'laporanpenjualan';

        // Data yang akan dikirimkan ke view
        $data = [
            'menu' => $menu,
            'submenu' => 'pemilik',
            'data' => $laporanData,
            'allData' => $allData,
            'selectedDay' => $selectedDay,
            'selectedMonth' => $selectedMonth,
            'selectedYear' => $selectedYear,
        ];

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
